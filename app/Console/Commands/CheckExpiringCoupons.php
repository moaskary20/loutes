<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckExpiringCoupons extends Command
{
    protected $signature = 'coupons:check-expiring';

    protected $description = 'التحقق من الكوبونات المنتهية الصلاحية وإنشاء إشعارات';

    public function handle()
    {
        $this->info('بدء التحقق من الكوبونات المنتهية الصلاحية...');

        // الكوبونات التي ستنتهي خلال 7 أيام
        $expiringCoupons = Coupon::where('is_active', true)
            ->whereNotNull('expires_at')
            ->whereBetween('expires_at', [now(), now()->addDays(7)])
            ->get();

        $count = 0;
        foreach ($expiringCoupons as $coupon) {
            // التحقق من عدم وجود إشعار سابق لهذا الكوبون
            $existingNotification = \App\Models\Notification::where('type', \App\Enums\NotificationType::COUPON_EXPIRING)
                ->where('related_id', $coupon->id)
                ->where('related_type', 'coupon')
                ->whereDate('created_at', today())
                ->exists();

            if (!$existingNotification) {
                NotificationService::couponExpiring($coupon);
                $count++;
            }
        }

        $this->info("تم إنشاء {$count} إشعار جديد للكوبونات المنتهية الصلاحية.");
        
        return Command::SUCCESS;
    }
}
