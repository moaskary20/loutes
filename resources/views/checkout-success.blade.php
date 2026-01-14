<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success - Loutes Store</title>
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
            direction: ltr;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .success-container {
            background: white;
            border-radius: 15px;
            padding: 60px 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 50px;
            color: white;
        }

        .success-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .success-message {
            font-size: 1.1rem;
            color: #777;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .order-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .order-info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .order-info-row:last-child {
            border-bottom: none;
        }

        .order-info-label {
            font-weight: 600;
            color: #555;
        }

        .order-info-value {
            color: #333;
            font-weight: 700;
        }

        .success-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-primary {
            background: #cead42;
            color: white;
        }

        .btn-primary:hover {
            background: #b89a35;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✓</div>
        <h1 class="success-title">Order Placed Successfully!</h1>
        <p class="success-message">
            Thank you for your order. We have received your order and will begin processing it right away.
        </p>

        <div class="order-info">
            <div class="order-info-row">
                <span class="order-info-label">Order Number:</span>
                <span class="order-info-value">{{ $order->order_number }}</span>
            </div>
            <div class="order-info-row">
                <span class="order-info-label">Total Amount:</span>
                <span class="order-info-value">{{ number_format($order->total, 2) }} SAR</span>
            </div>
            <div class="order-info-row">
                <span class="order-info-label">Status:</span>
                <span class="order-info-value">{{ $order->status->label() }}</span>
            </div>
        </div>

        <div class="success-actions">
            <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
            <a href="{{ route('products') }}" class="btn btn-secondary">View Products</a>
        </div>
    </div>
</body>
</html>
