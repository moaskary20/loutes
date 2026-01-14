<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryLog extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'type',
        'reason',
        'reference',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        // تحديث المخزون عند إنشاء سجل جديد
        static::created(function ($log) {
            if (!$log->skipStockUpdate) {
                $log->updateProductStock();
            }
        });

        // تحديث المخزون عند تحديث سجل (إرجاع التغيير القديم ثم تطبيق الجديد)
        static::updated(function ($log) {
            if ($log->wasChanged(['quantity', 'type'])) {
                // إرجاع التغيير القديم
                $log->revertProductStock();
                // تطبيق التغيير الجديد
                $log->updateProductStock();
            }
        });

        // إرجاع المخزون عند حذف سجل
        static::deleted(function ($log) {
            $log->revertProductStock();
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * تحديث مخزون المنتج بناءً على نوع الحركة
     */
    protected function updateProductStock(): void
    {
        $product = $this->product;
        if (!$product) {
            return;
        }

        if ($this->type === 'in') {
            // إضافة للكمية
            $product->increment('stock_quantity', $this->quantity);
        } elseif ($this->type === 'out') {
            // خصم من الكمية
            $product->decrement('stock_quantity', $this->quantity);
            // التأكد من عدم وجود كمية سالبة
            $product->refresh();
            if ($product->stock_quantity < 0) {
                $product->update(['stock_quantity' => 0]);
            }
        }
    }

    /**
     * إرجاع المخزون عند حذف السجل أو تحديثه
     */
    protected function revertProductStock(): void
    {
        $product = $this->product;
        if (!$product) {
            return;
        }

        // استخدام القيمة الأصلية إذا كانت موجودة (عند التحديث)
        $quantity = $this->getOriginal('quantity') ?? $this->quantity;
        $type = $this->getOriginal('type') ?? $this->type;

        if ($type === 'in') {
            // إرجاع الخصم (كانت إضافة)
            $product->decrement('stock_quantity', $quantity);
            $product->refresh();
            if ($product->stock_quantity < 0) {
                $product->update(['stock_quantity' => 0]);
            }
        } elseif ($type === 'out') {
            // إرجاع الإضافة (كانت خصم)
            $product->increment('stock_quantity', $quantity);
        }
    }
}
