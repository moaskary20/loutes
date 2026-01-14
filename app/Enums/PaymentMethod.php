<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case CARD = 'card';
    case BANK_TRANSFER = 'bank_transfer';
    case ONLINE = 'online';
    case CASH_ON_DELIVERY = 'cash_on_delivery';

    public function label(): string
    {
        return match($this) {
            self::CASH => 'نقدي',
            self::CARD => 'بطاقة',
            self::BANK_TRANSFER => 'تحويل بنكي',
            self::ONLINE => 'دفع إلكتروني',
            self::CASH_ON_DELIVERY => 'الدفع عند الاستلام',
        };
    }
}
