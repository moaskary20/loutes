<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} - Loutes Store</title>
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
            overflow-x: hidden;
            background: #f5f5f5;
        }

        /* Header (copied from products.blade.php) */
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
            background: rgba(206, 173, 66, 0.95);
            backdrop-filter: blur(10px);
            color: white;
            padding: 8px 15px;
            font-size: 14px;
        }

        .top-bar-content {
            max-width: 100%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 15px;
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
            background: #cead42;
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
            color: #cead42;
            padding-left: 25px;
        }

        .get-quote-btn {
            background: #cead42;
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
            background: #b89a35;
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
            color: #cead42;
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
            background: #cead42;
            transform: scaleX(0);
            transition: transform 0.3s;
        }

        .nav-link:hover {
            color: #cead42;
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
            color: #cead42;
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
            background: #cead42;
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
            color: #cead42;
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
        .product-hero {
            position: relative;
            width: 100%;
            height: 500px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 0;
            padding-top: 50px;
        }

        .product-hero-bg {
            position: absolute;
            top: 25px;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .product-hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(4px);
            transform: scale(1.1);
        }

        .product-hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(206, 173, 66, 0.4);
            z-index: 2;
        }

        .product-hero-content {
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

        .product-hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .product-hero-subtitle {
            font-size: 1.2rem;
            max-width: 600px;
            line-height: 1.7;
        }

        .product-hero-wave-canvas {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            z-index: 4;
            pointer-events: none;
        }

        /* Product Details Section */
        .product-details-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .product-details-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            background: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }

        /* Product Gallery */
        .product-gallery {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .product-main-image {
            width: 100%;
            height: 500px;
            background: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-main-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .product-thumbnails {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 10px 0;
        }

        .product-thumbnail {
            min-width: 80px;
            height: 80px;
            background: #f0f0f0;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s;
        }

        .product-thumbnail:hover,
        .product-thumbnail.active {
            border-color: #cead42;
        }

        .product-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Product Info */
        .product-info {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .product-name {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            line-height: 1.2;
        }

        .product-category {
            font-size: 1rem;
            color: #777;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
        }

        .product-rating-stars {
            color: #f39c12;
            font-size: 1.2rem;
        }

        .product-rating-text {
            color: #777;
        }

        .product-price-section {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .product-price {
            font-size: 2rem;
            font-weight: 700;
            color: #cead42;
        }

        .product-original-price {
            font-size: 1.3rem;
            color: #999;
            text-decoration: line-through;
        }

        .product-discount-badge {
            background: #dc3545;
            color: white;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .product-short-description {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.7;
            margin-top: 10px;
        }

        .product-stock {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            font-weight: 600;
        }

        .product-stock.in-stock {
            color: #28a745;
        }

        .product-stock.out-of-stock {
            color: #dc3545;
        }

        .product-quantity-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
        }

        .quantity-label {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
        }

        .quantity-input-group {
            display: flex;
            align-items: center;
            border: 2px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .quantity-btn {
            width: 40px;
            height: 45px;
            background: #f0f0f0;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover {
            background: #cead42;
            color: white;
        }

        .quantity-input {
            width: 60px;
            height: 45px;
            border: none;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            font-family: 'Tajawal', sans-serif;
        }

        .add-to-cart-btn {
            flex: 1;
            padding: 15px 30px;
            background: #cead42;
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Tajawal', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
        }

        .add-to-cart-btn:hover {
            background: #b89a35;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(206, 173, 66, 0.3);
        }

        .add-to-cart-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .add-to-cart-btn.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Product Description */
        .product-description-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px 60px;
        }

        .product-description {
            background: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }

        .product-description-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        .product-description-content {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.8;
        }

        /* Related Products */
        .related-products-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px 60px;
        }

        .related-products-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }

        .related-products-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .related-product-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s;
        }

        .related-product-card:hover {
            transform: translateY(-5px);
        }

        .related-product-image {
            width: 100%;
            height: 200px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .related-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .related-product-body {
            padding: 15px;
        }

        .related-product-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #333;
        }

        .related-product-title a {
            text-decoration: none;
            color: inherit;
        }

        .related-product-title a:hover {
            color: #cead42;
        }

        .related-product-price {
            font-size: 1rem;
            font-weight: 700;
            color: #cead42;
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
        }

        @media (max-width: 968px) {
            .nav-center {
                display: none;
            }

            .product-hero-title {
                font-size: 2.2rem;
            }

            .product-details-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .related-products-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .related-products-grid {
                grid-template-columns: 1fr;
            }

            .product-quantity-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .add-to-cart-btn {
                width: 100%;
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
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.423c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H11.5v3.923zm1.468-1.855c.24.29.461.603.654.94a7.024 7.024 0 0 0 1.756-1.085h-1.83c-.135.431-.362.862-.58 1.145z"/>
                            </svg>
                            <span>English</span>
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
                        <button class="get-quote-btn">Get A Quote</button>
                        <div class="search-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="nav-center">
                        <a href="{{ route('home') }}" class="nav-link">Home</a>
                        <a href="{{ route('about') }}" class="nav-link">About Us</a>
                        <a href="{{ route('products') }}" class="nav-link">Our Products</a>
                        <a href="{{ route('careers') }}" class="nav-link">Careers</a>
                        <a href="{{ route('contact') }}" class="nav-link">Contact Us</a>
                    </div>
                    <div class="nav-right">
                        <a href="{{ route('cart.index') }}" class="cart-icon-wrapper" title="Shopping Cart">
                            <div class="cart-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <span class="cart-badge" id="cartBadge">{{ \App\Helpers\CartHelper::getCartCount() > 0 ? \App\Helpers\CartHelper::getCartCount() : '' }}</span>
                        </a>
                        <div class="logo">
                            <div class="logo-icon">L</div>
                            <div class="logo-text">
                                <span class="logo-text-ar">اللوتس</span>
                                <span class="logo-text-en">LOTUS</span>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-content">
            <div class="mobile-menu-header">
                <div class="mobile-menu-logo">
                    <div class="logo-icon" style="width: 40px; height: 40px; font-size: 20px;">L</div>
                    <div class="logo-text">
                        <span class="logo-text-ar" style="font-size: 18px;">اللوتس</span>
                        <span class="logo-text-en" style="font-size: 12px;">LOTUS</span>
                    </div>
                </div>
                <button class="mobile-menu-close" id="mobileMenuClose" aria-label="Close menu">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="mobile-menu-links">
                <a href="{{ route('home') }}" class="mobile-menu-link">Home</a>
                <a href="{{ route('about') }}" class="mobile-menu-link">About Us</a>
                <a href="{{ route('products') }}" class="mobile-menu-link">Our Products</a>
                <a href="{{ route('careers') }}" class="mobile-menu-link">Careers</a>
                <a href="{{ route('contact') }}" class="mobile-menu-link">Contact Us</a>
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
    <section class="product-hero">
        <div class="product-hero-bg">
            <img src="https://lotussnacks.com/wp-content/uploads/2023/05/footer-img001-1.jpg" alt="{{ $product->name }}">
        </div>
        <div class="product-hero-overlay"></div>
        <div class="product-hero-content">
            <h1 class="product-hero-title">{{ $product->name }}</h1>
            <p class="product-hero-subtitle">Product Details</p>
        </div>
        <canvas id="productHeroWaveCanvas" class="product-hero-wave-canvas"></canvas>
    </section>

    <!-- Product Details -->
    <section class="product-details-section">
        <div class="product-details-container">
            <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="product-main-image" id="productMainImage">
                    @if($product->images->first())
                        <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->name }}" id="mainProductImage">
                    @else
                        <svg width="200" height="200" fill="#999" viewBox="0 0 24 24">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @endif
                </div>
                @if($product->images->count() > 1)
                    <div class="product-thumbnails">
                        @foreach($product->images as $image)
                            <div class="product-thumbnail {{ $loop->first ? 'active' : '' }}" data-image="{{ asset('storage/' . $image->image) }}">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <h1 class="product-name">{{ $product->name }}</h1>
                
                @if($product->category)
                    <div class="product-category">{{ $product->category->name_en ?? $product->category->name }}</div>
                @endif

                @php
                    $avgRating = $product->reviews->avg('rating');
                    $reviewsCount = $product->reviews->count();
                @endphp

                @if($avgRating)
                    <div class="product-rating">
                        <span class="product-rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($avgRating)) ★ @else ☆ @endif
                            @endfor
                        </span>
                        <span class="product-rating-text">({{ number_format($avgRating, 1) }}) - {{ $reviewsCount }} {{ $reviewsCount === 1 ? 'review' : 'reviews' }}</span>
                    </div>
                @else
                    <div class="product-rating">
                        <span class="product-rating-text">No reviews yet</span>
                    </div>
                @endif

                <div class="product-price-section">
                    <span class="product-price">{{ number_format($product->price, 2) }} SAR</span>
                    @if($product->original_price && $product->original_price > $product->price)
                        <span class="product-original-price">{{ number_format($product->original_price, 2) }} SAR</span>
                        @php
                            $discountPercent = round((($product->original_price - $product->price) / $product->original_price) * 100);
                        @endphp
                        <span class="product-discount-badge">-{{ $discountPercent }}%</span>
                    @endif
                </div>

                @if($product->short_description)
                    <div class="product-short-description">{{ $product->short_description }}</div>
                @endif

                <div class="product-stock {{ $product->stock_quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                    @if($product->stock_quantity > 0)
                        ✓ In Stock ({{ $product->stock_quantity }} available)
                    @else
                        ✗ Out of Stock
                    @endif
                </div>

                <div class="product-quantity-controls">
                    <span class="quantity-label">Quantity:</span>
                    <div class="quantity-input-group">
                        <button class="quantity-btn" id="decreaseQty">-</button>
                        <input type="number" id="productQuantity" class="quantity-input" value="1" min="1" max="{{ $product->stock_quantity ?? 999 }}">
                        <button class="quantity-btn" id="increaseQty">+</button>
                    </div>
                    <button class="add-to-cart-btn" id="addToCartBtn" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                        <span>🛒</span>
                        <span>Add to Cart</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Description -->
    @if($product->description)
        <section class="product-description-section">
            <div class="product-description">
                <h2 class="product-description-title">Product Description</h2>
                <div class="product-description-content">
                    {!! $product->description !!}
                </div>
            </div>
        </section>
    @endif

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <section class="related-products-section">
            <h2 class="related-products-title">Related Products</h2>
            <div class="related-products-grid">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="related-product-card">
                        <a href="{{ route('product.show', $relatedProduct) }}">
                            <div class="related-product-image">
                                @if($relatedProduct->images->first())
                                    <img src="{{ asset('storage/' . $relatedProduct->images->first()->image) }}" alt="{{ $relatedProduct->name }}">
                                @else
                                    <svg width="60" height="60" fill="#999" viewBox="0 0 24 24">
                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="related-product-body">
                                <h3 class="related-product-title">
                                    <a href="{{ route('product.show', $relatedProduct) }}">{{ $relatedProduct->name }}</a>
                                </h3>
                                <div class="related-product-price">{{ number_format($relatedProduct->price, 2) }} SAR</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <script>
        // Wave animation for hero section
        function drawProductHeroWave() {
            const canvas = document.getElementById('productHeroWaveCanvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            function resizeCanvas() {
                canvas.width = canvas.offsetWidth;
                canvas.height = 150;
            }

            resizeCanvas();

            let time = 0;

            function animate() {
                const width = canvas.width;
                const height = canvas.height;

                ctx.clearRect(0, 0, width, height);

                // موجة أولى
                ctx.beginPath();
                ctx.moveTo(0, 0);

                for (let x = 0; x <= width; x += 1) {
                    const y = 50 + Math.sin((x * 0.01) + (time * 0.02)) * 30 +
                              Math.sin((x * 0.015) + (time * 0.03)) * 20;
                    ctx.lineTo(x, y);
                }

                ctx.lineTo(width, height);
                ctx.lineTo(0, height);
                ctx.closePath();
                ctx.fillStyle = '#f5f5f5';
                ctx.fill();

                // موجة ثانية
                ctx.beginPath();
                ctx.moveTo(0, 0);

                for (let x = 0; x <= width; x += 1) {
                    const y = 80 + Math.sin((x * 0.012) + (time * 0.025)) * 25 +
                              Math.cos((x * 0.018) + (time * 0.035)) * 15;
                    ctx.lineTo(x, y);
                }

                ctx.lineTo(width, height);
                ctx.lineTo(0, height);
                ctx.closePath();
                ctx.fillStyle = 'rgba(245, 245, 245, 0.8)';
                ctx.fill();

                time += 0.5;
                requestAnimationFrame(animate);
            }

            animate();
            window.addEventListener('resize', resizeCanvas);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', drawProductHeroWave);
        } else {
            drawProductHeroWave();
        }

        // Product image gallery
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnails = document.querySelectorAll('.product-thumbnail');
            const mainImage = document.getElementById('mainProductImage');

            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    // Remove active class from all thumbnails
                    thumbnails.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked thumbnail
                    this.classList.add('active');
                    // Update main image
                    if (mainImage) {
                        mainImage.src = this.getAttribute('data-image');
                    }
                });
            });

            // Quantity controls
            const decreaseBtn = document.getElementById('decreaseQty');
            const increaseBtn = document.getElementById('increaseQty');
            const quantityInput = document.getElementById('productQuantity');
            const maxQuantity = parseInt(quantityInput.getAttribute('max')) || 999;

            decreaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value) || 1;
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            increaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value) || 1;
                if (currentValue < maxQuantity) {
                    quantityInput.value = currentValue + 1;
                }
            });

            quantityInput.addEventListener('change', function() {
                let value = parseInt(this.value) || 1;
                if (value < 1) this.value = 1;
                if (value > maxQuantity) this.value = maxQuantity;
            });

            // Add to cart functionality
            const addToCartBtn = document.getElementById('addToCartBtn');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    const quantity = parseInt(quantityInput.value) || 1;

                    // Disable button and show loading
                    this.classList.add('loading');
                    this.disabled = true;
                    const originalText = this.querySelector('span:last-child').textContent;
                    this.querySelector('span:last-child').textContent = 'Adding...';

                    // Send AJAX request
                    fetch(`/cart/add/${productId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            this.querySelector('span:last-child').textContent = 'Added!';
                            this.style.background = '#28a745';

                            // Update cart count if cart icon exists
                            updateCartCount(data.cart_count);

                            // Show toast notification
                            showToast(`${productName} added to cart!`, 'success');

                            // Redirect to cart page after 1 second
                            setTimeout(() => {
                                window.location.href = '{{ route("cart.index") }}';
                            }, 1000);
                        } else {
                            showToast(data.message || 'Failed to add product to cart', 'error');
                            this.classList.remove('loading');
                            this.disabled = false;
                            this.querySelector('span:last-child').textContent = originalText;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred. Please try again.', 'error');
                        this.classList.remove('loading');
                        this.disabled = false;
                        this.querySelector('span:last-child').textContent = originalText;
                    });
                });
            }
        });

        // Update cart count in header
        function updateCartCount(count) {
            const cartBadge = document.querySelector('.cart-badge');
            if (cartBadge) {
                cartBadge.textContent = count;
                cartBadge.style.display = count > 0 ? 'block' : 'none';
            }
        }

        // Toast notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                background: ${type === 'success' ? '#28a745' : '#dc3545'};
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10000;
                animation: slideIn 0.3s ease;
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
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
