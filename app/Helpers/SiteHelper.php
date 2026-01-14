<?php

namespace App\Helpers;

use App\Models\SiteSetting;

class SiteHelper
{
    /**
     * الحصول على رابط شعار الموقع
     */
    public static function getLogo(): string
    {
        $settings = SiteSetting::getSettings();
        if ($settings->logo) {
            return asset('storage/' . $settings->logo);
        }
        // Default logo path or return empty string
        return asset('images/logo.svg');
    }

    /**
     * التحقق من وجود شعار مخصص
     */
    public static function hasCustomLogo(): bool
    {
        $settings = SiteSetting::getSettings();
        return !empty($settings->logo);
    }
}
