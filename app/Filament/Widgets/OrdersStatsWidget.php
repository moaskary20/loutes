<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrdersStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي الطلبات', Order::count())
                ->description('جميع الطلبات')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
            Stat::make('طلبات قيد الانتظار', Order::where('status', 'pending')->count())
                ->description('في انتظار المعالجة')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('طلبات تم تسليمها', Order::where('status', 'delivered')->count())
                ->description('تم التسليم بنجاح')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('طلبات اليوم', Order::whereDate('created_at', today())->count())
                ->description('طلبات اليوم')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
        ];
    }
}
