<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'description',
        'short_description',
        'sku',
        'price',
        'compare_price',
        'cost_price',
        'stock_quantity',
        'low_stock_threshold',
        'weight',
        'dimensions',
        'is_active',
        'is_featured',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ProductImage::class)->where('is_primary', true);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity <= 0) {
            return 'out_of_stock';
        }
        if ($this->stock_quantity <= $this->low_stock_threshold) {
            return 'low_stock';
        }
        return 'in_stock';
    }

    protected static function boot()
    {
        parent::boot();

        // إنشاء إشعار عند انخفاض المخزون
        static::updated(function ($product) {
            if ($product->wasChanged('stock_quantity')) {
                $oldStock = $product->getOriginal('stock_quantity');
                $newStock = $product->stock_quantity;
                
                // إذا كان المخزون الجديد أقل من أو يساوي الحد الأدنى وكان القديم أكبر
                if ($newStock <= $product->low_stock_threshold && $oldStock > $product->low_stock_threshold) {
                    \App\Services\NotificationService::lowStock($product);
                }
            }
        });

        // إنشاء إشعار عند إضافة منتج جديد
        static::created(function ($product) {
            if ($product->is_active) {
                \App\Services\NotificationService::newProduct($product);
            }
        });
    }
}
