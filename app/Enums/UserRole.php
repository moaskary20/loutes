<?php

namespace App\Enums;

enum UserRole: string
{
    case Customer = 'customer';
    case Supervisor = 'supervisor';
    case Admin = 'admin';

    public function label(): string
    {
        return match($this) {
            self::Customer => 'عميل',
            self::Supervisor => 'مشرف',
            self::Admin => 'مدير نظام',
        };
    }

    public static function options(): array
    {
        return [
            self::Customer->value => self::Customer->label(),
            self::Supervisor->value => self::Supervisor->label(),
            self::Admin->value => self::Admin->label(),
        ];
    }
}
