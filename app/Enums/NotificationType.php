<?php

namespace App\Enums;

enum NotificationType: string
{
    case LOW_STOCK = 'low_stock';
    case NEW_ORDER = 'new_order';
    case PENDING_PAYMENT = 'pending_payment';
    case COUPON_EXPIRING = 'coupon_expiring';
    case ORDER_STATUS_CHANGED = 'order_status_changed';
    case ORDER_SHIPPED = 'order_shipped';
    case ORDER_DELIVERED = 'order_delivered';
    case NEW_PROMOTION = 'new_promotion';
    case NEW_PRODUCT = 'new_product';
    case SYSTEM = 'system';

    public function label(): string
    {
        return match($this) {
            self::LOW_STOCK => 'تنبيه مخزون منخفض',
            self::NEW_ORDER => 'طلب جديد',
            self::PENDING_PAYMENT => 'دفعة معلقة',
            self::COUPON_EXPIRING => 'كوبون منتهي الصلاحية',
            self::ORDER_STATUS_CHANGED => 'تغيير حالة الطلب',
            self::ORDER_SHIPPED => 'تم شحن الطلب',
            self::ORDER_DELIVERED => 'تم توصيل الطلب',
            self::NEW_PROMOTION => 'عرض جديد',
            self::NEW_PRODUCT => 'منتج جديد',
            self::SYSTEM => 'إشعار نظام',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::LOW_STOCK => 'heroicon-o-exclamation-triangle',
            self::NEW_ORDER => 'heroicon-o-shopping-cart',
            self::PENDING_PAYMENT => 'heroicon-o-credit-card',
            self::COUPON_EXPIRING => 'heroicon-o-ticket',
            self::ORDER_STATUS_CHANGED => 'heroicon-o-arrow-path',
            self::ORDER_SHIPPED => 'heroicon-o-truck',
            self::ORDER_DELIVERED => 'heroicon-o-check-circle',
            self::NEW_PROMOTION => 'heroicon-o-megaphone',
            self::NEW_PRODUCT => 'heroicon-o-sparkles',
            self::SYSTEM => 'heroicon-o-bell',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::LOW_STOCK => 'warning',
            self::NEW_ORDER => 'info',
            self::PENDING_PAYMENT => 'danger',
            self::COUPON_EXPIRING => 'warning',
            self::ORDER_STATUS_CHANGED => 'primary',
            self::ORDER_SHIPPED => 'info',
            self::ORDER_DELIVERED => 'success',
            self::NEW_PROMOTION => 'success',
            self::NEW_PRODUCT => 'primary',
            self::SYSTEM => 'gray',
        };
    }
}
