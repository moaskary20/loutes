<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\ProductImage;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // حفظ الصور في متغير مؤقت
        $this->productImages = $data['product_images'] ?? [];
        
        // إزالة product_images من البيانات لأنها ليست حقل في جدول products
        unset($data['product_images']);
        
        return $data;
    }

    protected function afterCreate(): void
    {
        $product = $this->record;
        $images = $this->productImages ?? [];
        
        // حفظ الصور في جدول product_images
        foreach ($images as $index => $image) {
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $image,
                'sort_order' => $index,
                'is_primary' => $index === 0, // الصورة الأولى تكون أساسية
            ]);
        }

        // إنشاء سجل مخزون تلقائياً إذا كان هناك كمية مخزون
        // ملاحظة: لا نحدث المخزون هنا لأن المخزون موجود بالفعل في stock_quantity
        if ($product->stock_quantity > 0) {
            \App\Models\InventoryLog::withoutEvents(function () use ($product) {
                \App\Models\InventoryLog::create([
                    'product_id' => $product->id,
                    'quantity' => $product->stock_quantity,
                    'type' => 'in',
                    'reason' => 'إضافة منتج جديد',
                    'reference' => $product->sku,
                    'notes' => "إضافة منتج جديد: {$product->name} - الكمية الابتدائية: {$product->stock_quantity}",
                ]);
            });
        }
    }

    protected $productImages = [];
}
