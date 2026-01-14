<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'قيد الانتظار',
            self::PROCESSING => 'قيد المعالجة',
            self::SHIPPED => 'تم الشحن',
            self::DELIVERED => 'تم التسليم',
            self::CANCELLED => 'ملغي',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::PROCESSING => 'info',
            self::SHIPPED => 'primary',
            self::DELIVERED => 'success',
            self::CANCELLED => 'danger',
        };
    }
}
