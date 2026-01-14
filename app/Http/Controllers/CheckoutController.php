<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\Province;
use App\Models\Order;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * عرض صفحة Checkout
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::with('images')->find($productId);
            if ($product) {
                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;
                
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemSubtotal,
                ];
            }
        }

        // جلب المحافظات النشطة
        $provinces = Province::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->get();

        // جلب طرق الشحن النشطة
        $shippingMethods = ShippingMethod::where('is_active', true)
            ->with('provinces')
            ->get();

        $shippingCost = 0;
        $total = $subtotal + $shippingCost;

        return view('checkout', compact('cartItems', 'subtotal', 'shippingCost', 'total', 'provinces', 'shippingMethods'));
    }

    /**
     * حساب تكلفة الشحن
     */
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'province_id' => 'required|exists:provinces,id',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
        ]);

        $cart = Session::get('cart', []);
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal += $product->price * $item['quantity'];
            }
        }

        $shippingMethod = ShippingMethod::findOrFail($request->shipping_method_id);
        $shippingCost = $shippingMethod->getCostForProvince($request->province_id);

        // التحقق من عتبة الشحن المجاني
        if ($shippingMethod->free_shipping_threshold && $subtotal >= $shippingMethod->free_shipping_threshold) {
            $shippingCost = 0;
        }

        $total = $subtotal + $shippingCost;

        return response()->json([
            'success' => true,
            'shipping_cost' => number_format($shippingCost, 2),
            'total' => number_format($total, 2),
        ]);
    }

    /**
     * معالجة الطلب
     */
    public function processOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // حساب المجموع الفرعي
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;
                
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemSubtotal,
                ];
            }
        }

        // حساب تكلفة الشحن
        $shippingMethod = ShippingMethod::findOrFail($request->shipping_method_id);
        $shippingCost = $shippingMethod->getCostForProvince($request->province_id);

        // التحقق من عتبة الشحن المجاني
        if ($shippingMethod->free_shipping_threshold && $subtotal >= $shippingMethod->free_shipping_threshold) {
            $shippingCost = 0;
        }

        $province = Province::findOrFail($request->province_id);

        // إنشاء الطلب
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'customer_id' => auth()->id(), // null للضيوف
            'status' => OrderStatus::PENDING,
            'payment_status' => PaymentStatus::PENDING,
            'payment_method' => PaymentMethod::CASH_ON_DELIVERY, // يمكن تغييره لاحقاً
            'shipping_method_id' => $request->shipping_method_id,
            'subtotal' => $subtotal,
            'tax_amount' => 0, // يمكن إضافة ضريبة لاحقاً
            'shipping_cost' => $shippingCost,
            'discount_amount' => 0, // يمكن إضافة كوبونات لاحقاً
            'total' => $subtotal + $shippingCost,
            'notes' => $request->notes,
            'shipping_address' => [
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
                'address' => $request->address,
                'city' => $request->city,
                'province' => $province->name_en ?? $province->name,
                'province_id' => $province->id,
            ],
            'billing_address' => [
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
        ]);

        // إضافة المنتجات للطلب
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'product_sku' => $item['product']->sku ?? '',
                'quantity' => $item['quantity'],
                'price' => $item['product']->price,
                'total' => $item['subtotal'],
            ]);

            // تحديث المخزون
            $item['product']->decrement('stock_quantity', $item['quantity']);
        }

        // مسح السلة
        Session::forget('cart');

        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully!');
    }

    /**
     * صفحة نجاح الطلب
     */
    public function success(Order $order)
    {
        return view('checkout-success', compact('order'));
    }
}
