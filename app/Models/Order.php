<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'status',
        'payment_status',
        'payment_method',
        'shipping_method_id',
        'coupon_id',
        'subtotal',
        'tax_amount',
        'shipping_cost',
        'discount_amount',
        'total',
        'notes',
        'shipping_address',
        'billing_address',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
        });

        // إنشاء إشعار عند إنشاء طلب جديد
        static::created(function ($order) {
            \App\Services\NotificationService::newOrder($order);
            
            // إشعار للدفعة المعلقة
            if ($order->payment_status === \App\Enums\PaymentStatus::PENDING) {
                \App\Services\NotificationService::pendingPayment($order);
            }
        });

        // إرجاع المخزون عند إلغاء الطلب وإنشاء إشعارات
        static::updated(function ($order) {
            // إرجاع المخزون عند إلغاء الطلب
            if ($order->wasChanged('status') && $order->status === OrderStatus::CANCELLED) {
                // إرجاع المخزون لجميع عناصر الطلب
                foreach ($order->items as $item) {
                    \App\Models\InventoryLog::create([
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'type' => 'in',
                        'reason' => 'إلغاء طلب',
                        'reference' => $order->order_number,
                        'notes' => "إرجاع المخزون بسبب إلغاء الطلب رقم {$order->order_number}",
                    ]);
                }
            }

            // إشعارات تغيير حالة الطلب
            if ($order->wasChanged('status')) {
                $oldStatus = OrderStatus::from($order->getOriginal('status'));
                $newStatus = $order->status;
                
                \App\Services\NotificationService::orderStatusChanged($order, $oldStatus, $newStatus);
                
                // إشعارات خاصة حسب الحالة
                if ($newStatus === OrderStatus::SHIPPED) {
                    \App\Services\NotificationService::orderShipped($order);
                } elseif ($newStatus === OrderStatus::DELIVERED) {
                    \App\Services\NotificationService::orderDelivered($order);
                }
            }

            // إشعار للدفعة المعلقة
            if ($order->wasChanged('payment_status') && $order->payment_status === \App\Enums\PaymentStatus::PENDING) {
                \App\Services\NotificationService::pendingPayment($order);
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
