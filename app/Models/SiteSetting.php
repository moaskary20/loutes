<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'background_image',
        'background_color',
        'use_background_image',
        'view_products_link',
        'logo',
    ];

    protected $casts = [
        'use_background_image' => 'boolean',
    ];

    public static function getSettings(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'background_color' => '#cead42',
                'use_background_image' => false,
            ]
        );
    }
}
