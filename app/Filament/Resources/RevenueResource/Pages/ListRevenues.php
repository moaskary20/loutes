<?php

namespace App\Filament\Resources\RevenueResource\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\RevenueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListRevenues extends ListRecords
{
    protected static string $resource = RevenueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('تصدير')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    // يمكن إضافة منطق التصدير هنا
                }),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('الكل')
                ->badge(fn () => \App\Models\Order::where('status', OrderStatus::DELIVERED)->count()),
            'today' => Tab::make('اليوم')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('created_at', today()))
                ->badge(fn () => \App\Models\Order::where('status', OrderStatus::DELIVERED)
                    ->whereDate('created_at', today())
                    ->count()),
            'this_month' => Tab::make('هذا الشهر')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('created_at', now()->month))
                ->badge(fn () => \App\Models\Order::where('status', OrderStatus::DELIVERED)
                    ->whereMonth('created_at', now()->month)
                    ->count()),
            'this_year' => Tab::make('هذا العام')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereYear('created_at', now()->year))
                ->badge(fn () => \App\Models\Order::where('status', OrderStatus::DELIVERED)
                    ->whereYear('created_at', now()->year)
                    ->count()),
        ];
    }
}
