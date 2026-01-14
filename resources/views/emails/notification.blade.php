<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $notification->title }}</title>
    <style>
        body {
            font-family: 'Tajawal', Arial, sans-serif;
            direction: rtl;
            text-align: right;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .email-body {
            padding: 30px 20px;
        }
        .notification-type {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .notification-title {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 15px;
        }
        .notification-message {
            font-size: 16px;
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .notification-details {
            background-color: #f9fafb;
            border-right: 4px solid #f59e0b;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
        }
        .notification-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #6b7280;
        }
        .email-footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .email-footer p {
            margin: 5px 0;
            font-size: 12px;
            color: #9ca3af;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #f59e0b;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Loutes Store</h1>
        </div>
        
        <div class="email-body">
            <span class="notification-type" style="background-color: {{ match($notification->type->color()) {
                'danger' => '#ef4444',
                'warning' => '#f59e0b',
                'success' => '#10b981',
                'info' => '#3b82f6',
                'primary' => '#f59e0b',
                default => '#6b7280',
            } }}; color: #ffffff;">
                {{ $notification->type->label() }}
            </span>
            
            <h2 class="notification-title">{{ $notification->title }}</h2>
            
            <div class="notification-message">
                {{ $notification->message }}
            </div>
            
            @if($notification->data)
                <div class="notification-details">
                    <p><strong>التاريخ:</strong> {{ $notification->created_at->format('Y-m-d H:i') }}</p>
                    @if(isset($notification->data['order_number']))
                        <p><strong>رقم الطلب:</strong> {{ $notification->data['order_number'] }}</p>
                    @endif
                    @if(isset($notification->data['product_name']))
                        <p><strong>المنتج:</strong> {{ $notification->data['product_name'] }}</p>
                    @endif
                    @if(isset($notification->data['customer_name']))
                        <p><strong>العميل:</strong> {{ $notification->data['customer_name'] }}</p>
                    @endif
                </div>
            @endif
        </div>
        
        <div class="email-footer">
            <p>هذا بريد إلكتروني تلقائي من نظام Loutes Store</p>
            <p>يرجى عدم الرد على هذا البريد</p>
        </div>
    </div>
</body>
</html>
