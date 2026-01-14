<?php

namespace App\Filament\Pages;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FinancialStatistics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    
    protected static string $view = 'filament.pages.financial-statistics';
    
    protected static ?string $navigationLabel = 'الإحصائيات المالية';
    
    protected static ?string $title = 'الإحصائيات المالية';
    
    protected static ?string $navigationGroup = 'الحسابات المالية';
    
    protected static ?int $navigationSort = 4;

    public function getAverageOrderValue(): float
    {
        return Order::where('status', OrderStatus::DELIVERED)
            ->where('created_at', '>=', now()->subMonth())
            ->avg('total') ?? 0;
    }

    public function getAverageProfitMargin(): float
    {
        $orders = Order::where('status', OrderStatus::DELIVERED)
            ->where('created_at', '>=', now()->subMonth())
            ->get();

        $totalRevenue = $orders->sum('total');
        
        $totalCost = 0;
        if (Schema::hasTable('order_items')) {
            try {
                $totalCost = OrderItem::whereHas('order', function ($query) {
                    $query->where('status', OrderStatus::DELIVERED)
                          ->where('created_at', '>=', now()->subMonth());
                })
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->sum(DB::raw('order_items.quantity * COALESCE(products.cost_price, 0)'));
            } catch (\Exception $e) {
                $totalCost = 0;
            }
        }

        return $totalRevenue > 0 ? (($totalRevenue - $totalCost) / $totalRevenue) * 100 : 0;
    }

    public function getGrowthRate(): float
    {
        $currentMonth = Order::where('status', OrderStatus::DELIVERED)
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        $lastMonth = Order::where('status', OrderStatus::DELIVERED)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total');

        return $lastMonth > 0 ? (($currentMonth - $lastMonth) / $lastMonth) * 100 : 0;
    }

    public function getInventoryTurnover(): float
    {
        $totalCost = 0;
        if (Schema::hasTable('order_items')) {
            try {
                $totalCost = OrderItem::whereHas('order', function ($query) {
                    $query->where('status', OrderStatus::DELIVERED)
                          ->where('created_at', '>=', now()->subYear());
                })
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->sum(DB::raw('order_items.quantity * COALESCE(products.cost_price, 0)'));
            } catch (\Exception $e) {
                $totalCost = 0;
            }
        }

        $averageInventory = Product::avg(DB::raw('stock_quantity * COALESCE(cost_price, 0)')) ?? 1;

        return $averageInventory > 0 ? $totalCost / $averageInventory : 0;
    }

    public function getROI(): float
    {
        $profit = $this->getProfit();
        $investment = $this->getTotalInvestment();

        return $investment > 0 ? ($profit / $investment) * 100 : 0;
    }

    protected function getProfit(): float
    {
        $revenue = Order::where('status', OrderStatus::DELIVERED)
            ->where('created_at', '>=', now()->subYear())
            ->sum('total');

        $cost = 0;
        if (Schema::hasTable('order_items')) {
            try {
                $cost = OrderItem::whereHas('order', function ($query) {
                    $query->where('status', OrderStatus::DELIVERED)
                          ->where('created_at', '>=', now()->subYear());
                })
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->sum(DB::raw('order_items.quantity * COALESCE(products.cost_price, 0)'));
            } catch (\Exception $e) {
                $cost = 0;
            }
        }

        return $revenue - $cost;
    }

    protected function getTotalInvestment(): float
    {
        return Product::sum(DB::raw('stock_quantity * COALESCE(cost_price, 0)'));
    }

    public function getCustomerLifetimeValue(): float
    {
        $totalRevenue = Order::where('status', OrderStatus::DELIVERED)
            ->sum('total');

        $totalCustomers = \App\Models\Customer::has('orders')->count();

        return $totalCustomers > 0 ? $totalRevenue / $totalCustomers : 0;
    }

    public function getConversionRate(): float
    {
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', OrderStatus::DELIVERED)->count();

        return $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;
    }
}
