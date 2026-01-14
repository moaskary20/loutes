<?php

use App\Http\Controllers\OrderPrintController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [App\Http\Controllers\HomeController::class, 'submit'])->name('contact.submit');

Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');

Route::get('/products', [App\Http\Controllers\HomeController::class, 'products'])->name('products');
Route::get('/product/{product}', [App\Http\Controllers\HomeController::class, 'product'])->name('product.show');

Route::get('/careers', [App\Http\Controllers\HomeController::class, 'careers'])->name('careers');

// Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{productId}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{productId}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
});

// Checkout Routes
Route::prefix('checkout')->group(function () {
    Route::get('/', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/calculate-shipping', [App\Http\Controllers\CheckoutController::class, 'calculateShipping'])->name('checkout.calculate-shipping');
    Route::post('/process', [App\Http\Controllers\CheckoutController::class, 'processOrder'])->name('checkout.process');
    Route::get('/success/{order}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
});

Route::get('/orders/{order}/print', OrderPrintController::class)
    ->name('orders.print')
    ->middleware('auth');
