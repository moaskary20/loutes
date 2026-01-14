<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_sku',
        'quantity',
        'price',
        'total',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        // إرجاع المخزون عند حذف عنصر الطلب (إذا لم يكن الطلب ملغياً)
        static::deleted(function ($item) {
            $order = $item->order;
            if ($order && $order->status !== \App\Enums\OrderStatus::CANCELLED) {
                // إرجاع المخزون
                \App\Models\InventoryLog::create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'type' => 'in',
                    'reason' => 'إلغاء عنصر طلب',
                    'reference' => $order->order_number,
                    'notes' => "إرجاع المخزون بسبب حذف عنصر من الطلب رقم {$order->order_number}",
                ]);
            }
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
