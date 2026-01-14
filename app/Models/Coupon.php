<?php

namespace App\Models;

use App\Enums\CouponType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'minimum_purchase',
        'maximum_discount',
        'usage_limit',
        'used_count',
        'is_active',
        'starts_at',
        'expires_at',
        'applicable_to',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_purchase' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'type' => CouponType::class,
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    protected static function boot()
    {
        parent::boot();

        // إنشاء إشعار قبل 7 أيام من انتهاء صلاحية الكوبون
        static::updated(function ($coupon) {
            if ($coupon->wasChanged('expires_at') && $coupon->expires_at) {
                $daysUntilExpiry = now()->diffInDays($coupon->expires_at, false);
                
                // إذا كان الكوبون سينتهي خلال 7 أيام أو أقل
                if ($daysUntilExpiry <= 7 && $daysUntilExpiry >= 0) {
                    \App\Services\NotificationService::couponExpiring($coupon);
                }
            }
        });
    }
}
