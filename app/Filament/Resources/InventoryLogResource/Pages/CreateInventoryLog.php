<?php

namespace App\Filament\Resources\InventoryLogResource\Pages;

use App\Filament\Resources\InventoryLogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateInventoryLog extends CreateRecord
{
    protected static string $resource = InventoryLogResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        $product = $this->record->product;
        $newStock = $product ? $product->stock_quantity : 0;
        
        return Notification::make()
            ->success()
            ->title('تم إنشاء سجل المخزون')
            ->body("تم تحديث مخزون المنتج. المخزون الحالي: {$newStock}");
    }
}
