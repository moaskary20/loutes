<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class FinancialDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = today();
        $thisMonth = now()->startOfMonth();
        $thisYear = now()->startOfYear();
        $lastMonth = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        // الإيرادات
        $todayRevenue = Order::whereDate('created_at', $today)
            ->where('status', OrderStatus::DELIVERED)
            ->sum('total');
        
        $monthRevenue = Order::where('created_at', '>=', $thisMonth)
            ->where('status', OrderStatus::DELIVERED)
            ->sum('total');
        
        $lastMonthRevenue = Order::whereBetween('created_at', [$lastMonth, $lastMonthEnd])
            ->where('status', OrderStatus::DELIVERED)
            ->sum('total');
        
        $yearRevenue = Order::where('created_at', '>=', $thisYear)
            ->where('status', OrderStatus::DELIVERED)
            ->sum('total');

        // عدد الطلبات
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $monthOrders = Order::where('created_at', '>=', $thisMonth)->count();
        $yearOrders = Order::where('created_at', '>=', $thisYear)->count();

        // متوسط قيمة الطلب
        $avgOrderValue = Order::where('status', OrderStatus::DELIVERED)
            ->where('created_at', '>=', $thisMonth)
            ->avg('total') ?? 0;

        // هامش الربح (تقدير بناءً على تكلفة المنتجات)
        $monthRevenueTotal = $monthRevenue;
        $monthCost = OrderItem::whereHas('order', function ($query) use ($thisMonth) {
            $query->where('created_at', '>=', $thisMonth)
                  ->where('status', OrderStatus::DELIVERED);
        })
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->sum(DB::raw('order_items.quantity * COALESCE(products.cost_price, 0)'));
        
        $monthProfit = $monthRevenueTotal - $monthCost;
        $profitMargin = $monthRevenueTotal > 0 ? ($monthProfit / $monthRevenueTotal) * 100 : 0;

        // معدل النمو
        $growthRate = $lastMonthRevenue > 0 
            ? (($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        // الطلبات المعلقة
        $pendingOrders = Order::where('status', OrderStatus::PENDING)->count();
        $pendingRevenue = Order::where('status', OrderStatus::PENDING)->sum('total');

        // الطلبات المدفوعة
        $paidOrders = Order::where('payment_status', PaymentStatus::PAID)->count();
        $paidRevenue = Order::where('payment_status', PaymentStatus::PAID)->sum('total');

        return [
            Stat::make('إيرادات اليوم', number_format($todayRevenue, 2) . ' ر.س')
                ->description($todayOrders . ' طلب')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart($this->getDailyRevenueChart()),

            Stat::make('إيرادات الشهر', number_format($monthRevenue, 2) . ' ر.س')
                ->description($monthOrders . ' طلب - ' . number_format($growthRate, 1) . '% نمو')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary')
                ->chart($this->getMonthlyRevenueChart()),

            Stat::make('إيرادات السنة', number_format($yearRevenue, 2) . ' ر.س')
                ->description($yearOrders . ' طلب')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),

            Stat::make('صافي الربح (هذا الشهر)', number_format($monthProfit, 2) . ' ر.س')
                ->description('هامش الربح: ' . number_format($profitMargin, 2) . '%')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($profitMargin > 0 ? 'success' : 'danger'),

            Stat::make('متوسط قيمة الطلب', number_format($avgOrderValue, 2) . ' ر.س')
                ->description('هذا الشهر')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            Stat::make('الطلبات المعلقة', $pendingOrders . ' طلب')
                ->description('قيمة: ' . number_format($pendingRevenue, 2) . ' ر.س')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('الطلبات المدفوعة', $paidOrders . ' طلب')
                ->description('قيمة: ' . number_format($paidRevenue, 2) . ' ر.س')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }

    protected function getDailyRevenueChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = Order::whereDate('created_at', $date)
                ->where('status', OrderStatus::DELIVERED)
                ->sum('total');
            $data[] = $revenue;
        }
        return $data;
    }

    protected function getMonthlyRevenueChart(): array
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();
            $revenue = Order::whereBetween('created_at', [$month, $monthEnd])
                ->where('status', OrderStatus::DELIVERED)
                ->sum('total');
            $data[] = $revenue;
        }
        return $data;
    }
}
