<?php

namespace App\Filament\Pages;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class FinancialReports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    
    protected static string $view = 'filament.pages.financial-reports';
    
    protected static ?string $navigationLabel = 'التقارير المالية';
    
    protected static ?string $title = 'التقارير المالية';
    
    protected static ?string $navigationGroup = 'الحسابات المالية';
    
    protected static ?int $navigationSort = 2;

    public $startDate;
    public $endDate;
    public $reportType = 'sales';

    public function mount(): void
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function getSalesReportData(): array
    {
        $orders = Order::where('status', OrderStatus::DELIVERED)
            ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
            ->get();

        $totalRevenue = $orders->sum('total');
        $totalOrders = $orders->count();
        $totalItems = OrderItem::whereHas('order', function ($query) {
            $query->where('status', OrderStatus::DELIVERED)
                  ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59']);
        })->sum('quantity');
        
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $totalTax = $orders->sum('tax_amount');
        $totalShipping = $orders->sum('shipping_cost');
        $totalDiscount = $orders->sum('discount_amount');

        return [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'total_items' => $totalItems,
            'avg_order_value' => $avgOrderValue,
            'total_tax' => $totalTax,
            'total_shipping' => $totalShipping,
            'total_discount' => $totalDiscount,
        ];
    }

    public function getProductReportData(): array
    {
        $products = OrderItem::whereHas('order', function ($query) {
            $query->where('status', OrderStatus::DELIVERED)
                  ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59']);
        })
        ->select('product_id', 'product_name')
        ->selectRaw('SUM(quantity) as total_quantity')
        ->selectRaw('SUM(total) as total_revenue')
        ->groupBy('product_id', 'product_name')
        ->orderByDesc('total_revenue')
        ->limit(10)
        ->get();

        return $products->toArray();
    }

    public function getCategoryReportData(): array
    {
        $categories = OrderItem::whereHas('order', function ($query) {
            $query->where('status', OrderStatus::DELIVERED)
                  ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59']);
        })
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('categories.name')
        ->selectRaw('SUM(order_items.quantity) as total_quantity')
        ->selectRaw('SUM(order_items.total) as total_revenue')
        ->groupBy('categories.id', 'categories.name')
        ->orderByDesc('total_revenue')
        ->get();

        return $categories->toArray();
    }

    public function getDailyRevenueData(): array
    {
        $data = [];
        $start = \Carbon\Carbon::parse($this->startDate);
        $end = \Carbon\Carbon::parse($this->endDate);

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $revenue = Order::where('status', OrderStatus::DELIVERED)
                ->whereDate('created_at', $date)
                ->sum('total');
            
            $data[] = [
                'date' => $date->format('Y-m-d'),
                'revenue' => $revenue,
            ];
        }

        return $data;
    }
}
