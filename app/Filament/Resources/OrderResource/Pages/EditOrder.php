<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('print')
                ->label('طباعة الطلب')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(fn () => route('orders.print', $this->record))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }
}
