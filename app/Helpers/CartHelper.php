<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartHelper
{
    /**
     * جلب السلة من Session
     */
    public static function getCart()
    {
        return Session::get('cart', []);
    }

    /**
     * حساب المجموع الكلي للسلة
     */
    public static function getCartTotal()
    {
        $cart = self::getCart();
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $total += $product->price * $item['quantity'];
            }
        }

        return $total;
    }

    /**
     * حساب عدد المنتجات في السلة
     */
    public static function getCartCount()
    {
        $cart = self::getCart();
        $count = 0;

        foreach ($cart as $item) {
            $count += $item['quantity'];
        }

        return $count;
    }

    /**
     * حساب المجموع الفرعي لمنتج معين
     */
    public static function cartItemSubtotal($productId, $quantity)
    {
        $product = Product::find($productId);
        if (!$product) {
            return 0;
        }

        return $product->price * $quantity;
    }

    /**
     * التحقق من وجود منتج في السلة
     */
    public static function hasProduct($productId)
    {
        $cart = self::getCart();
        return isset($cart[$productId]);
    }

    /**
     * جلب كمية منتج معين في السلة
     */
    public static function getProductQuantity($productId)
    {
        $cart = self::getCart();
        return $cart[$productId]['quantity'] ?? 0;
    }
}
