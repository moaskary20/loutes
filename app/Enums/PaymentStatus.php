<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'قيد الانتظار',
            self::PAID => 'مدفوع',
            self::FAILED => 'فشل',
            self::REFUNDED => 'مسترد',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::PAID => 'success',
            self::FAILED => 'danger',
            self::REFUNDED => 'info',
        };
    }
}
