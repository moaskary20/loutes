<?php

namespace App\Filament\Pages;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class FinancialAnalytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static string $view = 'filament.pages.financial-analytics';
    
    protected static ?string $navigationLabel = 'التحليلات المالية';
    
    protected static ?string $title = 'التحليلات المالية';
    
    protected static ?string $navigationGroup = 'الحسابات المالية';
    
    protected static ?int $navigationSort = 3;

    public $period = 'month';
    public $comparePeriod = false;
    public $startDate;
    public $endDate;

    public function mount(): void
    {
        $this->startDate = \Illuminate\Support\Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = \Illuminate\Support\Carbon::now()->format('Y-m-d');
    }

    public function getRevenueTrend(): array
    {
        $data = [];
        $periods = $this->period === 'month' ? 12 : ($this->period === 'week' ? 12 : 5);

        for ($i = $periods - 1; $i >= 0; $i--) {
            if ($this->period === 'month') {
                $date = now()->subMonths($i)->startOfMonth();
                $endDate = now()->subMonths($i)->endOfMonth();
                $label = $date->format('M Y');
            } elseif ($this->period === 'week') {
                $date = now()->subWeeks($i)->startOfWeek();
                $endDate = now()->subWeeks($i)->endOfWeek();
                $label = 'أسبوع ' . ($i + 1);
            } else {
                $date = now()->subYears($i)->startOfYear();
                $endDate = now()->subYears($i)->endOfYear();
                $label = $date->format('Y');
            }

            $revenue = Order::where('status', OrderStatus::DELIVERED)
                ->whereBetween('created_at', [$date, $endDate])
                ->sum('total');

            $data[] = [
                'label' => $label,
                'revenue' => $revenue,
            ];
        }

        return $data;
    }

    public function getProfitabilityAnalysis(): array
    {
        $orders = Order::where('status', OrderStatus::DELIVERED)
            ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->get();

        $totalRevenue = $orders->sum('total');
        
        $totalCost = OrderItem::whereHas('order', function ($query) {
            $query->where('status', OrderStatus::DELIVERED)
                  ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        })
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->sum(DB::raw('order_items.quantity * COALESCE(products.cost_price, 0)'));

        $profit = $totalRevenue - $totalCost;
        $profitMargin = $totalRevenue > 0 ? ($profit / $totalRevenue) * 100 : 0;

        return [
            'revenue' => $totalRevenue,
            'cost' => $totalCost,
            'profit' => $profit,
            'profit_margin' => $profitMargin,
        ];
    }

    public function getTopProductsByProfit(): array
    {
        $products = OrderItem::whereHas('order', function ($query) {
            $query->where('status', OrderStatus::DELIVERED)
                  ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        })
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->select('order_items.product_id', 'order_items.product_name')
        ->selectRaw('SUM(order_items.quantity) as total_quantity')
        ->selectRaw('SUM(order_items.total) as total_revenue')
        ->selectRaw('SUM(order_items.quantity * COALESCE(products.cost_price, 0)) as total_cost')
        ->selectRaw('SUM(order_items.total) - SUM(order_items.quantity * COALESCE(products.cost_price, 0)) as profit')
        ->groupBy('order_items.product_id', 'order_items.product_name')
        ->orderByDesc('profit')
        ->limit(10)
        ->get();

        return $products->map(function ($product) {
            $profitMargin = $product->total_revenue > 0 
                ? (($product->profit ?? 0) / $product->total_revenue) * 100 
                : 0;
            
            return [
                'product_name' => $product->product_name,
                'quantity' => $product->total_quantity,
                'revenue' => $product->total_revenue,
                'cost' => $product->total_cost ?? 0,
                'profit' => $product->profit ?? 0,
                'profit_margin' => $profitMargin,
            ];
        })->toArray();
    }

    public function getGrowthRate(): array
    {
        $currentPeriod = $this->getPeriodRevenue(0);
        $previousPeriod = $this->getPeriodRevenue(1);
        
        $growthRate = $previousPeriod > 0 
            ? (($currentPeriod - $previousPeriod) / $previousPeriod) * 100 
            : 0;

        return [
            'current' => $currentPeriod,
            'previous' => $previousPeriod,
            'growth_rate' => $growthRate,
        ];
    }

    protected function getPeriodRevenue(int $offset): float
    {
        $start = \Illuminate\Support\Carbon::parse($this->startDate);
        $end = \Illuminate\Support\Carbon::parse($this->endDate);
        $daysDiff = $start->diffInDays($end);
        
        if ($this->period === 'month') {
            $date = $start->copy()->subMonths($offset)->startOfMonth();
            $endDate = $start->copy()->subMonths($offset)->endOfMonth();
        } elseif ($this->period === 'week') {
            $date = $start->copy()->subWeeks($offset)->startOfWeek();
            $endDate = $start->copy()->subWeeks($offset)->endOfWeek();
        } else {
            $date = $start->copy()->subYears($offset)->startOfYear();
            $endDate = $start->copy()->subYears($offset)->endOfYear();
        }

        return Order::where('status', OrderStatus::DELIVERED)
            ->whereBetween('created_at', [$date, $endDate])
            ->sum('total');
    }

    public function getRevenueTrendData(): array
    {
        $data = [];
        $start = \Illuminate\Support\Carbon::parse($this->startDate);
        $end = \Illuminate\Support\Carbon::parse($this->endDate);
        $daysDiff = $start->diffInDays($end);
        
        if ($daysDiff <= 31) {
            // Daily data
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $revenue = Order::where('status', OrderStatus::DELIVERED)
                    ->whereDate('created_at', $date)
                    ->sum('total');
                
                $data[] = [
                    'label' => $date->format('d/m'),
                    'revenue' => $revenue,
                ];
            }
        } elseif ($daysDiff <= 365) {
            // Weekly data
            $weeks = ceil($daysDiff / 7);
            for ($i = 0; $i < $weeks; $i++) {
                $weekStart = $start->copy()->addWeeks($i)->startOfWeek();
                $weekEnd = $weekStart->copy()->endOfWeek();
                if ($weekEnd->gt($end)) {
                    $weekEnd = $end->copy();
                }
                
                $revenue = Order::where('status', OrderStatus::DELIVERED)
                    ->whereBetween('created_at', [$weekStart, $weekEnd])
                    ->sum('total');
                
                $data[] = [
                    'label' => 'أسبوع ' . ($i + 1),
                    'revenue' => $revenue,
                ];
            }
        } else {
            // Monthly data
            for ($date = $start->copy(); $date->lte($end); $date->addMonth()) {
                $monthStart = $date->copy()->startOfMonth();
                $monthEnd = $date->copy()->endOfMonth();
                if ($monthEnd->gt($end)) {
                    $monthEnd = $end->copy();
                }
                
                $revenue = Order::where('status', OrderStatus::DELIVERED)
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->sum('total');
                
                $data[] = [
                    'label' => $monthStart->format('M Y'),
                    'revenue' => $revenue,
                ];
            }
        }

        return $data;
    }
}
