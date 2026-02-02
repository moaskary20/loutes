<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('web.checkout_title') }}</title>
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
            direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
            overflow-x: hidden;
            background: #f5f5f5;
        }

        /* Header Styles - Same as cart page */
        .header {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 95%;
            max-width: 1400px;
            z-index: 1000;
            background: transparent;
            padding: 15px;
            box-sizing: border-box;
        }

        .header-content {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8);
        }

        .top-bar {
            background: rgba(4, 72, 152, 0.95);
            backdrop-filter: blur(10px);
            color: white;
            padding: 8px 15px;
            font-size: 14px;
            overflow: visible;
        }

        .top-bar-content {
            max-width: 100%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            overflow: visible;
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 15px;
            overflow: visible;
        }

        .top-bar-center {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            justify-content: center;
        }

        .language-selector {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            overflow: visible;
        }

        .welcome-text {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .main-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 20px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .main-nav-content {
            max-width: 100%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            justify-content: space-around;
            width: 30px;
            height: 30px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            z-index: 1001;
        }

        .mobile-menu-toggle span {
            width: 100%;
            height: 3px;
            background: #333;
            border-radius: 3px;
            transition: all 0.3s;
        }

        .mobile-menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .mobile-menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(8px, -8px);
        }

        .mobile-menu {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
            pointer-events: none;
        }

        .mobile-menu.active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .mobile-menu-content {
            position: fixed;
            top: 0;
            right: -100%;
            width: 280px;
            max-width: 80%;
            height: 100vh;
            background: white;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            overflow-y: auto;
            z-index: 1000;
        }

        .mobile-menu.active .mobile-menu-content {
            right: 0;
        }

        .mobile-menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            background: #044898;
        }

        .mobile-menu-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
        }

        .mobile-menu-close {
            background: transparent;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-menu-links {
            padding: 20px 0;
        }

        .mobile-menu-link {
            display: block;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s;
        }

        .mobile-menu-link:hover {
            background: #f8f8f8;
            color: #044898;
            padding-left: 25px;
        }

        .get-quote-btn {
            background: #044898;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Tajawal', sans-serif;
        }

        .get-quote-btn:hover {
            background: #033a7a;
            transform: translateY(-2px);
        }

        .search-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #333;
            font-size: 18px;
            transition: all 0.3s;
        }

        .search-icon:hover {
            color: #044898;
        }

        .nav-center {
            display: flex;
            gap: 25px;
            align-items: center;
            flex: 1;
            justify-content: center;
        }

        .nav-link {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            padding-bottom: 5px;
            transition: all 0.3s;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: #044898;
            transform: scaleX(0);
            transition: transform 0.3s;
        }

        .nav-link:hover {
            color: #044898;
        }

        .nav-link:hover::after {
            transform: scaleX(1);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .cart-icon-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .cart-icon-wrapper:hover {
            transform: translateY(-2px);
        }

        .cart-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            font-size: 22px;
            transition: all 0.3s;
        }

        .cart-icon-wrapper:hover .cart-icon {
            color: #044898;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            border: 2px solid white;
            min-width: 20px;
        }

        .cart-badge:empty {
            display: none;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: #044898;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-text-ar {
            font-size: 20px;
            font-weight: bold;
            color: #044898;
            line-height: 1;
        }

        .logo-text-en {
            font-size: 14px;
            color: #666;
            letter-spacing: 2px;
        }

        .header-spacer {
            height: 0;
            width: 100%;
        }

        /* Hero Banner */
        .checkout-hero {
            position: relative;
            width: 100%;
            height: 300px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 0;
            padding-top: 50px;
        }

        .checkout-hero-bg {
            position: absolute;
            top: 25px;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .checkout-hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(4px);
            transform: scale(1.1);
        }

        .checkout-hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(4, 72, 152, 0.4);
            z-index: 2;
        }

        .checkout-hero-content {
            position: relative;
            z-index: 3;
            max-width: 1400px;
            margin: 0 auto;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            padding: 0 20px;
            color: white;
        }

        .checkout-hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        /* Checkout Section */
        .checkout-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .checkout-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 40px;
        }

        .checkout-form-section {
            background: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }

        .checkout-form-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-label.required::after {
            content: ' *';
            color: #dc3545;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Tajawal', sans-serif;
            transition: all 0.3s;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #044898;
            box-shadow: 0 0 0 3px rgba(206, 173, 66, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .shipping-methods {
            margin-top: 20px;
        }

        .shipping-method-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .shipping-method-option:hover {
            border-color: #044898;
            background: #fefefe;
        }

        .shipping-method-option input[type="radio"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .shipping-method-option.selected {
            border-color: #044898;
            background: #fffbf0;
        }

        .shipping-method-info {
            flex: 1;
        }

        .shipping-method-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .shipping-method-description {
            font-size: 0.9rem;
            color: #777;
        }

        .shipping-method-cost {
            font-size: 1.1rem;
            font-weight: 700;
            color: #044898;
        }

        .checkout-summary {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .checkout-summary-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .checkout-items {
            margin-bottom: 20px;
        }

        .checkout-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .checkout-item:last-child {
            border-bottom: none;
        }

        .checkout-item-image {
            width: 60px;
            height: 60px;
            background: #f0f0f0;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .checkout-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .checkout-item-info {
            flex: 1;
        }

        .checkout-item-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .checkout-item-quantity {
            font-size: 0.9rem;
            color: #777;
        }

        .checkout-item-price {
            font-weight: 700;
            color: #044898;
        }

        .checkout-summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            font-size: 1rem;
            color: #555;
        }

        .checkout-summary-row.total {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .checkout-summary-label {
            font-weight: 600;
        }

        .checkout-summary-value {
            font-weight: 700;
            color: #044898;
        }

        .checkout-summary-value.total {
            font-size: 1.8rem;
        }

        .place-order-btn {
            width: 100%;
            padding: 15px;
            background: #044898;
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Tajawal', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .place-order-btn:hover {
            background: #033a7a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(206, 173, 66, 0.3);
        }

        .place-order-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        @media (max-width: 968px) {
            .nav-center {
                display: none;
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .get-quote-btn {
                display: none;
            }

            .welcome-text {
                display: none;
            }
        }

        @media (max-width: 968px) {
            .nav-center {
                display: none;
            }

            .checkout-hero-title {
                font-size: 2.2rem;
            }

            .checkout-container {
                grid-template-columns: 1fr;
            }

            .checkout-summary {
                position: static;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="top-bar">
                <div class="top-bar-content">
                    <div class="top-bar-left">
                        <div class="language-selector">
                            @include('partials.language-dropdown')
                        </div>
                    </div>
                    <div class="top-bar-center">
                        <span class="welcome-text">
                            Welcome To Loutes Store
                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            <nav class="main-nav">
                <div class="main-nav-content">
                    <div class="nav-left">
                        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <div class="search-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="nav-center">
                        <a href="{{ route('home') }}" class="nav-link">{{ __('web.home') }}</a>
                        <a href="{{ route('about') }}" class="nav-link">{{ __('web.about_us') }}</a>
                        <a href="{{ route('products') }}" class="nav-link">{{ __('web.our_products') }}</a>
                        <a href="{{ route('careers') }}" class="nav-link">{{ __('web.careers') }}</a>
                        <a href="{{ route('contact') }}" class="nav-link">{{ __('web.contact_us') }}</a>
                    </div>
                    <div class="nav-right">
                        <button class="get-quote-btn">Get A Quote</button>
                        <a href="{{ route('cart.index') }}" class="cart-icon-wrapper" title="Shopping Cart">
                            <div class="cart-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <span class="cart-badge" id="cartBadge">{{ \App\Helpers\CartHelper::getCartCount() > 0 ? \App\Helpers\CartHelper::getCartCount() : '' }}</span>
                        </a>
                        @include('partials.logo')
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-content">
            <div class="mobile-menu-header">
                @include('partials.mobile-logo')
                <button class="mobile-menu-close" id="mobileMenuClose" aria-label="Close menu">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="mobile-menu-links">
                <a href="{{ route('home') }}" class="mobile-menu-link">{{ __('web.home') }}</a>
                <a href="{{ route('about') }}" class="mobile-menu-link">{{ __('web.about_us') }}</a>
                <a href="{{ route('products') }}" class="mobile-menu-link">{{ __('web.our_products') }}</a>
                <a href="{{ route('careers') }}" class="mobile-menu-link">{{ __('web.careers') }}</a>
                <a href="{{ route('contact') }}" class="mobile-menu-link">{{ __('web.contact_us') }}</a>
                <a href="{{ route('cart.index') }}" class="mobile-menu-link">
                    Shopping Cart
                    @if(\App\Helpers\CartHelper::getCartCount() > 0)
                        <span style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.85rem; margin-left: 10px;">
                            {{ \App\Helpers\CartHelper::getCartCount() }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <div class="header-spacer"></div>

    <!-- Hero Banner -->
    <section class="checkout-hero">
        <div class="checkout-hero-bg">
            <img src="https://lotussnacks.com/wp-content/uploads/2023/05/footer-img001-1.jpg" alt="Checkout">
        </div>
        <div class="checkout-hero-overlay"></div>
        <div class="checkout-hero-content">
            <h1 class="checkout-hero-title">Checkout</h1>
        </div>
    </section>

    <!-- Checkout Section -->
    <section class="checkout-section">
        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="checkout-container">
                <!-- Checkout Form -->
                <div class="checkout-form-section">
                    <h2 class="checkout-form-title">{{ __('web.checkout_shipping') }}</h2>

                    <div class="form-group">
                        <label class="form-label required" for="customer_name">{{ __('web.checkout_name') }}</label>
                        <input type="text" id="customer_name" name="customer_name" class="form-input" required value="{{ old('customer_name') }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required" for="customer_email">Email</label>
                            <input type="email" id="customer_email" name="customer_email" class="form-input" required value="{{ old('customer_email') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label required" for="customer_phone">Phone</label>
                            <input type="text" id="customer_phone" name="customer_phone" class="form-input" required value="{{ old('customer_phone') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="province_id">Province</label>
                        <select id="province_id" name="province_id" class="form-select" required>
                            <option value="">Select Province</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                    {{ $province->name_en ?? $province->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="city">{{ __('web.checkout_city') }}</label>
                        <input type="text" id="city" name="city" class="form-input" required value="{{ old('city') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="address">Address</label>
                        <textarea id="address" name="address" class="form-textarea" required>{{ old('address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="notes">{{ __('web.checkout_notes_optional') }}</label>
                        <textarea id="notes" name="notes" class="form-textarea">{{ old('notes') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Shipping Method</label>
                        <div class="shipping-methods" id="shippingMethods">
                            <p style="color: #777; margin-bottom: 15px;">Please select a province first</p>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="checkout-summary">
                    <h2 class="checkout-summary-title">{{ __('web.checkout_order_summary') }}</h2>

                    <div class="checkout-items">
                        @foreach($cartItems as $item)
                            <div class="checkout-item">
                                <div class="checkout-item-image">
                                    @if($item['product']->images->first())
                                        <img src="{{ asset('storage/' . $item['product']->images->first()->image) }}" alt="{{ $item['product']->name }}">
                                    @else
                                        <svg width="60" height="60" fill="#999" viewBox="0 0 24 24">
                                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="checkout-item-info">
                                    <div class="checkout-item-name">{{ $item['product']->name }}</div>
                                    <div class="checkout-item-quantity">Qty: {{ $item['quantity'] }}</div>
                                </div>
                                <div class="checkout-item-price">{{ number_format($item['subtotal'], 2) }} EGP</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="checkout-summary-row">
                        <span class="checkout-summary-label">Subtotal</span>
                        <span class="checkout-summary-value" id="checkoutSubtotal">{{ number_format($subtotal, 2) }} EGP</span>
                    </div>
                    <div class="checkout-summary-row">
                        <span class="checkout-summary-label">Shipping</span>
                        <span class="checkout-summary-value" id="checkoutShipping">{{ number_format($shippingCost, 2) }} EGP</span>
                    </div>
                    <div class="checkout-summary-row total">
                        <span class="checkout-summary-label">Total</span>
                        <span class="checkout-summary-value total" id="checkoutTotal">{{ number_format($total, 2) }} EGP</span>
                    </div>

                    <button type="submit" class="place-order-btn" id="placeOrderBtn">
                        <span>{{ __('web.checkout_place_order') }}</span>
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province_id');
            const shippingMethodsDiv = document.getElementById('shippingMethods');
            const shippingMethods = @json($shippingMethods);
            const subtotal = {{ $subtotal }};
            let selectedShippingMethodId = null;

            // Debug: Log shipping methods data
            console.log('Shipping methods loaded:', shippingMethods);

            // Load shipping methods when province is selected
            provinceSelect.addEventListener('change', function() {
                const provinceId = parseInt(this.value);
                
                if (!provinceId || isNaN(provinceId)) {
                    shippingMethodsDiv.innerHTML = '<p style="color: #777; margin-bottom: 15px;">Please select a province first</p>';
                    return;
                }

                // Filter shipping methods that are available for this province
                const availableMethods = shippingMethods.filter(method => {
                    if (!method.is_active) return false;
                    // Check if method is available for this province or has no province restrictions
                    // If provinces array is empty or null, method is available for all provinces
                    if (!method.provinces || method.provinces.length === 0) {
                        return true;
                    }
                    // Check if this province is in the method's provinces list
                    return method.provinces.some(p => parseInt(p.id) === provinceId);
                });

                if (availableMethods.length === 0) {
                    shippingMethodsDiv.innerHTML = '<p style="color: #dc3545;">No shipping methods available for this province</p>';
                    return;
                }

                // Render shipping methods
                let html = '';
                availableMethods.forEach((method, index) => {
                    const isFirst = index === 0;
                    // Get cost for this province, or use default cost
                    let cost = parseFloat(method.cost);
                    if (method.provinces && method.provinces.length > 0) {
                        const provincePivot = method.provinces.find(p => parseInt(p.id) === provinceId);
                        if (provincePivot && provincePivot.pivot && provincePivot.pivot.cost) {
                            cost = parseFloat(provincePivot.pivot.cost);
                        }
                    }
                    const freeShipping = method.free_shipping_threshold && subtotal >= parseFloat(method.free_shipping_threshold);
                    const finalCost = freeShipping ? 0 : cost;

                    html += `
                        <label class="shipping-method-option ${isFirst ? 'selected' : ''}" data-method-id="${method.id}" data-cost="${finalCost}">
                            <input type="radio" name="shipping_method_id" value="${method.id}" ${isFirst ? 'checked' : ''} required>
                            <div class="shipping-method-info">
                                <div class="shipping-method-name">${method.name_en || method.name}</div>
                                <div class="shipping-method-description">${method.description || ''} ${method.estimated_days ? `(${method.estimated_days} days)` : ''}</div>
                            </div>
                            <div class="shipping-method-cost">
                                ${freeShipping ? 'FREE' : finalCost.toFixed(2) + ' EGP'}
                            </div>
                        </label>
                    `;
                });

                shippingMethodsDiv.innerHTML = html;

                // Set first method as selected
                if (availableMethods.length > 0) {
                    selectedShippingMethodId = availableMethods[0].id;
                    updateShippingCost(availableMethods[0].id, provinceId);
                }

                // Handle shipping method selection
                document.querySelectorAll('input[name="shipping_method_id"]').forEach(radio => {
                    radio.addEventListener('change', function() {
                        document.querySelectorAll('.shipping-method-option').forEach(opt => {
                            opt.classList.remove('selected');
                        });
                        this.closest('.shipping-method-option').classList.add('selected');
                        selectedShippingMethodId = this.value;
                        updateShippingCost(this.value, provinceId);
                    });
                });
            });

            // Update shipping cost
            function updateShippingCost(methodId, provinceId) {
                fetch('{{ route("checkout.calculate-shipping") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        province_id: provinceId,
                        shipping_method_id: methodId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('checkoutShipping').textContent = data.shipping_cost + ' EGP';
                        document.getElementById('checkoutTotal').textContent = data.total + ' EGP';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            // Form submission
            document.getElementById('checkoutForm').addEventListener('submit', function(e) {
                const btn = document.getElementById('placeOrderBtn');
                btn.disabled = true;
                btn.innerHTML = '<span>Processing...</span>';
            });
        });
    </script>
    <script>
        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuClose = document.getElementById('mobileMenuClose');
            const body = document.body;

            function openMobileMenu() {
                if (mobileMenuToggle) mobileMenuToggle.classList.add('active');
                if (mobileMenu) mobileMenu.classList.add('active');
                if (body) body.style.overflow = 'hidden';
            }

            function closeMobileMenu() {
                if (mobileMenuToggle) mobileMenuToggle.classList.remove('active');
                if (mobileMenu) mobileMenu.classList.remove('active');
                if (body) body.style.overflow = '';
            }

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openMobileMenu();
                });
            }

            if (mobileMenuClose) {
                mobileMenuClose.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeMobileMenu();
                });
            }

            if (mobileMenu) {
                mobileMenu.addEventListener('click', function(e) {
                    if (e.target === mobileMenu) {
                        closeMobileMenu();
                    }
                });

                const mobileMenuLinks = mobileMenu.querySelectorAll('.mobile-menu-link');
                mobileMenuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        setTimeout(closeMobileMenu, 300);
                    });
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileMenu && mobileMenu.classList.contains('active')) {
                    closeMobileMenu();
                }
            });
        });
    </script>
</body>
</html>
