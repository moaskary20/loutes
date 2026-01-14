<?php

namespace Database\Seeders;

use App\Enums\CouponType;
use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => CouponType::PERCENTAGE->value,
            'value' => 10,
            'is_active' => true,
            'usage_limit' => 100,
            'expires_at' => now()->addMonths(3),
            'applicable_to' => 'all',
        ]);

        Coupon::create([
            'code' => 'SAVE50',
            'type' => CouponType::FIXED->value,
            'value' => 50,
            'minimum_purchase' => 200,
            'is_active' => true,
            'usage_limit' => 50,
            'expires_at' => now()->addMonths(6),
            'applicable_to' => 'all',
        ]);
    }
}
