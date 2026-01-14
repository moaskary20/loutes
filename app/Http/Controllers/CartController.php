<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * عرض صفحة السلة
     */
    public function index()
    {
        $cart = Session::get('cart', []);
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

        $shippingCost = 0; // يمكن حسابها لاحقاً بناءً على طريقة الشحن
        $total = $subtotal + $shippingCost;

        return view('cart', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    /**
     * إضافة منتج للسلة
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1|max:' . ($product->stock_quantity ?? 999),
        ]);

        $quantity = $request->input('quantity', 1);

        // التحقق من المخزون
        if ($product->stock_quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available.',
            ], 400);
        }

        $cart = Session::get('cart', []);

        // إذا كان المنتج موجود بالفعل، زيادة الكمية
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            
            // التحقق من المخزون مرة أخرى
            if ($product->stock_quantity < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available.',
                ], 400);
            }
            
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);

        $cartCount = $this->getCartCount($cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully.',
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * تحديث كمية منتج في السلة
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');
        $cart = Session::get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart.',
            ], 404);
        }

        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        // التحقق من المخزون
        if ($product->stock_quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available.',
            ], 400);
        }

        $cart[$productId]['quantity'] = $quantity;
        Session::put('cart', $cart);

        $itemSubtotal = $product->price * $quantity;
        $cartCount = $this->getCartCount($cart);
        $subtotal = $this->calculateSubtotal($cart);
        $total = $subtotal; // يمكن إضافة رسوم الشحن لاحقاً

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully.',
            'item_subtotal' => number_format($itemSubtotal, 2),
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($total, 2),
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * حذف منتج من السلة
     */
    public function remove($productId)
    {
        $cart = Session::get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart.',
            ], 404);
        }

        unset($cart[$productId]);
        Session::put('cart', $cart);

        $cartCount = $this->getCartCount($cart);
        $subtotal = $this->calculateSubtotal($cart);
        $total = $subtotal;

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart.',
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($total, 2),
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * مسح السلة بالكامل
     */
    public function clear()
    {
        Session::forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully.',
            'cart_count' => 0,
        ]);
    }

    /**
     * حساب عدد المنتجات في السلة
     */
    private function getCartCount($cart)
    {
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    /**
     * حساب المجموع الفرعي
     */
    private function calculateSubtotal($cart)
    {
        $subtotal = 0;
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal += $product->price * $item['quantity'];
            }
        }
        return $subtotal;
    }
}
