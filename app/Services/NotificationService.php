<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Mail\NotificationEmail;
use App\Models\EmailSetting;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public static function create(array $data): Notification
    {
        $notification = Notification::create([
            'type' => $data['type'],
            'title' => $data['title'],
            'message' => $data['message'],
            'target_type' => $data['target_type'] ?? 'admin',
            'target_id' => $data['target_id'] ?? null,
            'related_id' => $data['related_id'] ?? null,
            'related_type' => $data['related_type'] ?? null,
            'data' => $data['data'] ?? null,
        ]);

        // إرسال الإشعار عبر البريد الإلكتروني
        self::sendEmailNotification($notification);

        return $notification;
    }

    protected static function sendEmailNotification(Notification $notification): void
    {
        try {
            $settings = EmailSetting::getSettings();
            
            if (!$settings->isEnabled() || !$settings->shouldSendNotification($notification->type->value)) {
                return;
            }

            // تحديث إعدادات Mail
            config([
                'mail.default' => 'brevo',
                'mail.mailers.brevo' => [
                    'transport' => 'brevo',
                    'api_key' => $settings->brevo_api_key,
                ],
                'mail.from' => [
                    'address' => $settings->from_email,
                    'name' => $settings->from_name,
                ],
            ]);

            // إرسال البريد الإلكتروني
            Mail::to($settings->admin_email)->send(new NotificationEmail($notification));
        } catch (\Exception $e) {
            // تسجيل الخطأ بدون إيقاف العملية
            \Log::error('فشل إرسال إشعار عبر البريد الإلكتروني: ' . $e->getMessage());
        }
    }

    public static function lowStock($product): void
    {
        self::create([
            'type' => NotificationType::LOW_STOCK,
            'title' => 'تنبيه: مخزون منخفض',
            'message' => "المنتج '{$product->name}' لديه مخزون منخفض ({$product->stock_quantity} وحدة). الحد الأدنى: {$product->low_stock_threshold}",
            'target_type' => 'admin',
            'related_id' => $product->id,
            'related_type' => 'product',
            'data' => [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'stock_quantity' => $product->stock_quantity,
                'low_stock_threshold' => $product->low_stock_threshold,
            ],
        ]);
    }

    public static function newOrder($order): void
    {
        self::create([
            'type' => NotificationType::NEW_ORDER,
            'title' => 'طلب جديد',
            'message' => "تم إنشاء طلب جديد برقم {$order->order_number} من العميل {$order->customer->name}. المبلغ الإجمالي: {$order->total} ر.س",
            'target_type' => 'admin',
            'related_id' => $order->id,
            'related_type' => 'order',
            'data' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'customer_name' => $order->customer->name,
                'total' => $order->total,
            ],
        ]);
    }

    public static function pendingPayment($order): void
    {
        self::create([
            'type' => NotificationType::PENDING_PAYMENT,
            'title' => 'دفعة معلقة',
            'message' => "الطلب رقم {$order->order_number} لديه دفعة معلقة بقيمة {$order->total} ر.س",
            'target_type' => 'admin',
            'related_id' => $order->id,
            'related_type' => 'order',
            'data' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'total' => $order->total,
            ],
        ]);
    }

    public static function couponExpiring($coupon): void
    {
        $daysLeft = now()->diffInDays($coupon->expires_at, false);
        self::create([
            'type' => NotificationType::COUPON_EXPIRING,
            'title' => 'كوبون منتهي الصلاحية',
            'message' => "الكوبون '{$coupon->code}' سينتهي خلال {$daysLeft} يوم",
            'target_type' => 'admin',
            'related_id' => $coupon->id,
            'related_type' => 'coupon',
            'data' => [
                'coupon_id' => $coupon->id,
                'coupon_code' => $coupon->code,
                'expires_at' => $coupon->expires_at,
            ],
        ]);
    }

    public static function orderStatusChanged($order, $oldStatus, $newStatus): void
    {
        // إشعار للمدير
        self::create([
            'type' => NotificationType::ORDER_STATUS_CHANGED,
            'title' => 'تغيير حالة الطلب',
            'message' => "تم تغيير حالة الطلب رقم {$order->order_number} من {$oldStatus->label()} إلى {$newStatus->label()}",
            'target_type' => 'admin',
            'related_id' => $order->id,
            'related_type' => 'order',
        ]);

        // إشعار للعميل
        if ($order->customer_id) {
            self::create([
                'type' => NotificationType::ORDER_STATUS_CHANGED,
                'title' => 'تغيير حالة طلبك',
                'message' => "تم تغيير حالة طلبك رقم {$order->order_number} إلى {$newStatus->label()}",
                'target_type' => 'customer',
                'target_id' => $order->customer_id,
                'related_id' => $order->id,
                'related_type' => 'order',
            ]);
        }
    }

    public static function orderShipped($order): void
    {
        // إشعار للعميل
        if ($order->customer_id) {
            self::create([
                'type' => NotificationType::ORDER_SHIPPED,
                'title' => 'تم شحن طلبك',
                'message' => "تم شحن طلبك رقم {$order->order_number} وهو في الطريق إليك",
                'target_type' => 'customer',
                'target_id' => $order->customer_id,
                'related_id' => $order->id,
                'related_type' => 'order',
            ]);
        }
    }

    public static function orderDelivered($order): void
    {
        // إشعار للعميل
        if ($order->customer_id) {
            self::create([
                'type' => NotificationType::ORDER_DELIVERED,
                'title' => 'تم توصيل طلبك',
                'message' => "تم توصيل طلبك رقم {$order->order_number} بنجاح. نتمنى أن تكون راضياً عن منتجاتنا!",
                'target_type' => 'customer',
                'target_id' => $order->customer_id,
                'related_id' => $order->id,
                'related_type' => 'order',
            ]);
        }
    }

    public static function newPromotion($promotion): void
    {
        self::create([
            'type' => NotificationType::NEW_PROMOTION,
            'title' => 'عرض جديد',
            'message' => $promotion['message'] ?? 'عرض جديد متاح الآن!',
            'target_type' => 'all',
            'data' => $promotion,
        ]);
    }

    public static function newProduct($product): void
    {
        self::create([
            'type' => NotificationType::NEW_PRODUCT,
            'title' => 'منتج جديد',
            'message' => "تم إضافة منتج جديد: {$product->name}",
            'target_type' => 'all',
            'related_id' => $product->id,
            'related_type' => 'product',
            'data' => [
                'product_id' => $product->id,
                'product_name' => $product->name,
            ],
        ]);
    }
}
