<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    protected $fillable = [
        'provider',
        'brevo_api_key',
        'from_email',
        'from_name',
        'admin_email',
        'enabled',
        'send_notifications',
        'notification_types',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'send_notifications' => 'boolean',
        'notification_types' => 'array',
    ];

    public static function getSettings(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'provider' => 'brevo',
                'enabled' => false,
                'send_notifications' => true,
                'notification_types' => [],
            ]
        );
    }

    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->brevo_api_key) && !empty($this->admin_email);
    }

    public function shouldSendNotification(string $type): bool
    {
        if (!$this->isEnabled() || !$this->send_notifications) {
            return false;
        }

        $types = $this->notification_types ?? [];
        return empty($types) || in_array($type, $types);
    }
}
