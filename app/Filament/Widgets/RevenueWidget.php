<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $todayRevenue = Order::whereDate('created_at', today())->sum('total');
        $monthRevenue = Order::whereMonth('created_at', now()->month)->sum('total');
        $totalRevenue = Order::sum('total');

        return [
            Stat::make('إيرادات اليوم', number_format($todayRevenue, 2) . ' ر.س')
                ->description('إيرادات اليوم')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
            Stat::make('إيرادات الشهر', number_format($monthRevenue, 2) . ' ر.س')
                ->description('إيرادات هذا الشهر')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),
            Stat::make('إجمالي الإيرادات', number_format($totalRevenue, 2) . ' ر.س')
                ->description('جميع الإيرادات')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
        ];
    }
}
