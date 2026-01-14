<?php

namespace App\Enums;

enum ShippingType: string
{
    case FLAT_RATE = 'flat_rate';
    case WEIGHT_BASED = 'weight_based';
    case PRICE_BASED = 'price_based';

    public function label(): string
    {
        return match($this) {
            self::FLAT_RATE => 'سعر ثابت',
            self::WEIGHT_BASED => 'حسب الوزن',
            self::PRICE_BASED => 'حسب السعر',
        };
    }
}
