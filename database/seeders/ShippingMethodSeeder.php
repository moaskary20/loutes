<?php

namespace Database\Seeders;

use App\Enums\ShippingType;
use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    public function run(): void
    {
        ShippingMethod::create([
            'name' => 'شحن سريع',
            'type' => ShippingType::FLAT_RATE->value,
            'cost' => 25.00,
            'is_active' => true,
            'estimated_days' => 2,
        ]);

        ShippingMethod::create([
            'name' => 'شحن عادي',
            'type' => ShippingType::FLAT_RATE->value,
            'cost' => 15.00,
            'is_active' => true,
            'estimated_days' => 5,
        ]);

        ShippingMethod::create([
            'name' => 'شحن مجاني',
            'type' => ShippingType::FLAT_RATE->value,
            'cost' => 0.00,
            'free_shipping_threshold' => 200.00,
            'is_active' => true,
            'estimated_days' => 7,
        ]);
    }
}
