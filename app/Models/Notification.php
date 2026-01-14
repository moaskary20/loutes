<?php

namespace App\Models;

use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'target_type',
        'target_id',
        'related_id',
        'related_type',
        'is_read',
        'read_at',
        'data',
    ];

    protected $casts = [
        'type' => NotificationType::class,
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    public function target(): MorphTo
    {
        return $this->morphTo('target');
    }

    public function related(): MorphTo
    {
        return $this->morphTo('related');
    }

    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForAdmin($query)
    {
        return $query->where('target_type', 'admin')->orWhere('target_type', 'all');
    }

    public function scopeForCustomer($query, $customerId = null)
    {
        $query->where(function ($q) use ($customerId) {
            $q->where('target_type', 'customer')
              ->orWhere('target_type', 'all');
            
            if ($customerId) {
                $q->where(function ($q2) use ($customerId) {
                    $q2->whereNull('target_id')
                       ->orWhere('target_id', $customerId);
                });
            }
        });
        
        return $query;
    }
}
