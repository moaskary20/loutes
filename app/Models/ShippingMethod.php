<?php

namespace App\Models;

use App\Enums\ShippingType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'description',
        'type',
        'cost',
        'free_shipping_threshold',
        'is_active',
        'estimated_days',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
        'is_active' => 'boolean',
        'estimated_days' => 'integer',
        'type' => ShippingType::class,
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function provinces(): BelongsToMany
    {
        return $this->belongsToMany(Province::class, 'shipping_method_province')
            ->withPivot('cost')
            ->withTimestamps();
    }

    public function getCostForProvince(?int $provinceId): float
    {
        if (!$provinceId) {
            return (float) $this->cost;
        }

        $province = $this->provinces()->where('provinces.id', $provinceId)->first();
        
        return $province ? (float) $province->pivot->cost : (float) $this->cost;
    }
}
