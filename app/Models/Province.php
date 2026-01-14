<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Province extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'code',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function shippingMethods(): BelongsToMany
    {
        return $this->belongsToMany(ShippingMethod::class, 'shipping_method_province')
            ->withPivot('cost')
            ->withTimestamps();
    }
}
