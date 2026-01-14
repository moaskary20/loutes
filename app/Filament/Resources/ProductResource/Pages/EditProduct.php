<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\ProductImage;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // حفظ الصور الجديدة في متغير مؤقت
        if (isset($data['product_images'])) {
            $this->newProductImages = $data['product_images'];
            unset($data['product_images']);
        }

        // حفظ القيمة القديمة للمخزون لتسجيل التغيير
        $this->oldStockQuantity = $this->record->stock_quantity ?? 0;
        
        return $data;
    }

    protected function afterSave(): void
    {
        $product = $this->record->fresh();
        
        if (isset($this->newProductImages)) {
            $existingImagesCount = $product->images()->count();
            
            // حفظ الصور الجديدة
            foreach ($this->newProductImages as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $image,
                    'sort_order' => $existingImagesCount + $index,
                    'is_primary' => false, // لا نجعل الصور الجديدة أساسية تلقائياً
                ]);
            }
            
            unset($this->newProductImages);
        }

        // تسجيل تغيير المخزون إذا تغير
        if (isset($this->oldStockQuantity) && $this->oldStockQuantity != $product->stock_quantity) {
            $difference = $product->stock_quantity - $this->oldStockQuantity;
            
            if ($difference != 0) {
                \App\Models\InventoryLog::create([
                    'product_id' => $product->id,
                    'quantity' => abs($difference),
                    'type' => $difference > 0 ? 'in' : 'out',
                    'reason' => 'تعديل يدوي للمنتج',
                    'reference' => $product->sku,
                    'notes' => "تعديل مخزون المنتج من {$this->oldStockQuantity} إلى {$product->stock_quantity}",
                ]);
            }
        }
    }

    protected $newProductImages = [];
    protected $oldStockQuantity = 0;
}
