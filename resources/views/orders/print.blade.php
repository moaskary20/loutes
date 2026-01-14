<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طباعة الطلب - {{ $order->order_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Tajawal', sans-serif;
            direction: rtl;
            padding: 20px;
            background: #fff;
        }
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            z-index: 999;
        }
        .header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        .order-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }
        .info-box h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .info-box p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th,
        table td {
            padding: 12px;
            text-align: right;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background: #f5f5f5;
            font-weight: bold;
            color: #333;
        }
        .totals {
            margin-top: 20px;
            text-align: left;
        }
        .totals table {
            width: 300px;
            margin-left: auto;
        }
        .totals td {
            padding: 8px;
        }
        .totals .total-row {
            font-weight: bold;
            font-size: 18px;
            background: #f5f5f5;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        @media print {
            body {
                padding: 0;
            }
            .invoice {
                border: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        .print-btn {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-btn button {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-btn button:hover {
            background: #059669;
        }
    </style>
</head>
<body>
    <div class="print-btn no-print">
        <button onclick="window.print()">🖨️ طباعة الطلب</button>
    </div>

    <div class="invoice">
        <div class="header">
            <h1>فاتورة الطلب</h1>
            <p>Loutes Store</p>
            <p>رقم الطلب: <strong>{{ $order->order_number }}</strong></p>
        </div>

        <div class="order-info">
            <div class="info-box">
                <h3>معلومات العميل</h3>
                <p><strong>الاسم:</strong> {{ $order->customer->name }}</p>
                <p><strong>البريد:</strong> {{ $order->customer->email }}</p>
                @if($order->customer->phone)
                    <p><strong>الهاتف:</strong> {{ $order->customer->phone }}</p>
                @endif
            </div>
            <div class="info-box">
                <h3>معلومات الطلب</h3>
                <p><strong>التاريخ:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>الحالة:</strong> {{ $order->status->label() }}</p>
                <p><strong>حالة الدفع:</strong> {{ $order->payment_status->label() }}</p>
                @if($order->payment_method)
                    <p><strong>طريقة الدفع:</strong> 
                        @try
                            {{ \App\Enums\PaymentMethod::from($order->payment_method)->label() }}
                        @catch(\ValueError $e)
                            {{ $order->payment_method }}
                        @endtry
                    </p>
                @endif
            </div>
        </div>

        @if($order->shipping_address)
            <div class="info-box" style="margin-bottom: 20px;">
                <h3>عنوان الشحن</h3>
                @foreach($order->shipping_address as $key => $value)
                    <p><strong>{{ $key }}:</strong> {{ $value }}</p>
                @endforeach
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->product_name }}</strong><br>
                            <small style="color: #666;">{{ $item->product_sku }}</small>
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }} ج.م</td>
                        <td>{{ number_format($item->total, 2) }} ج.م</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <td>المجموع الفرعي:</td>
                    <td>{{ number_format($order->subtotal, 2) }} ج.م</td>
                </tr>
                @if($order->tax_amount > 0)
                    <tr>
                        <td>الضريبة:</td>
                        <td>{{ number_format($order->tax_amount, 2) }} ج.م</td>
                    </tr>
                @endif
                @if($order->shipping_cost > 0)
                    <tr>
                        <td>تكلفة الشحن:</td>
                        <td>{{ number_format($order->shipping_cost, 2) }} ج.م</td>
                    </tr>
                @endif
                @if($order->discount_amount > 0)
                    <tr>
                        <td>الخصم:</td>
                        <td>-{{ number_format($order->discount_amount, 2) }} ج.م</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td>الإجمالي:</td>
                    <td>{{ number_format($order->total, 2) }} ج.م</td>
                </tr>
            </table>
        </div>

        @if($order->notes)
            <div class="info-box" style="margin-top: 20px;">
                <h3>ملاحظات</h3>
                <p>{{ $order->notes }}</p>
            </div>
        @endif

        <div class="footer">
            <p>شكراً لاختيارك Loutes Store</p>
            <p>تاريخ الطباعة: {{ now()->format('Y-m-d H:i') }}</p>
        </div>
    </div>
</body>
</html>
