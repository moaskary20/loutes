<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderPrintController extends Controller
{
    public function __invoke(Order $order)
    {
        $order->load(['customer', 'items.product', 'shippingMethod', 'coupon']);
        
        return view('orders.print', compact('order'));
    }
}
