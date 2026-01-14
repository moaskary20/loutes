<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\OrderItem;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // حفظ عناصر الطلب في متغير مؤقت
        $this->orderItems = $data['order_items'] ?? [];
        
        // إزالة order_items من البيانات لأنها ليست حقل في جدول orders
        unset($data['order_items']);

        // حساب الإجمالي إذا لم يكن محدداً
        if (!isset($data['total']) || $data['total'] == 0) {
            $subtotal = $data['subtotal'] ?? 0;
            $tax = $data['tax_amount'] ?? 0;
            $shipping = $data['shipping_cost'] ?? 0;
            $discount = $data['discount_amount'] ?? 0;
            
            $data['total'] = $subtotal + $tax + $shipping - $discount;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $order = $this->record->fresh();
        $items = $this->orderItems ?? [];
        
        // حفظ عناصر الطلب وإنشاء سجلات المخزون
        foreach ($items as $item) {
            if (isset($item['product_id']) && isset($item['quantity'])) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'] ?? '',
                    'product_sku' => $item['product_sku'] ?? '',
                    'quantity' => $item['quantity'],
                    'price' => $item['price'] ?? 0,
                    'total' => $item['total'] ?? 0,
                ]);

                // إنشاء سجل مخزون تلقائياً عند إنشاء الطلب
                \App\Models\InventoryLog::create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'type' => 'out',
                    'reason' => 'طلب مبيعات',
                    'reference' => $order->order_number,
                    'notes' => "خصم من المخزون بسبب الطلب رقم {$order->order_number}",
                ]);
            }
        }
    }

    protected $orderItems = [];
}
