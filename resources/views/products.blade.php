<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Our Products - Loutes Store</title>
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

        /* Header (copied from other pages for consistency) */
        .header {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 95%;
            max-width: 1400px;
            z-index: 999;
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
            color: #cead42;
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

        /* Hero Banner - مشابه لصفحة Contact */
        .products-hero {
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

        .products-hero-bg {
            position: absolute;
            top: 25px;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .products-hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(4px);
            transform: scale(1.1);
        }

        .products-hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(206, 173, 66, 0.4);
            z-index: 2;
        }

        .products-hero-content {
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

        .products-hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .products-hero-subtitle {
            font-size: 1.2rem;
            max-width: 600px;
            line-height: 1.7;
        }

        .products-hero-wave-canvas {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            z-index: 4;
            pointer-events: none;
        }

        /* Layout */
        .products-page {
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 20px 80px;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 40px;
        }

        .products-filters {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            padding: 25px 20px;
        }

        .filter-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }

        .filter-group {
            margin-bottom: 25px;
        }

        .filter-group h4 {
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #555;
        }

        .filter-row {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
        }

        .filter-input {
            flex: 1;
            padding: 8px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 0.9rem;
            font-family: 'Tajawal', sans-serif;
        }

        .filter-checkbox-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            max-height: 200px;
            overflow-y: auto;
        }

        .filter-checkbox-label {
            font-size: 0.9rem;
            color: #555;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-rating-option {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
            font-size: 0.9rem;
            color: #555;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .filter-submit,
        .filter-reset {
            flex: 1;
            padding: 8px 12px;
            border-radius: 6px;
            border: none;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Tajawal', sans-serif;
        }

        .filter-submit {
            background: #cead42;
            color: white;
        }

        .filter-submit:hover {
            background: #033a7a;
        }

        .filter-reset {
            background: #f0f0f0;
            color: #555;
        }

        .products-main {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .products-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.95rem;
            color: #666;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
        }

        .product-card-image-link {
            display: block;
            text-decoration: none;
            cursor: pointer;
        }

        .product-card-image {
            width: 100%;
            height: 200px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-card-image {
            transform: scale(1.05);
        }

        .product-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-card-title-link {
            text-decoration: none;
            color: inherit;
        }

        .product-card-title-link:hover .product-card-title {
            color: #cead42;
        }

        .product-card-body {
            padding: 15px 16px 18px;
        }

        .product-card-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 4px;
            color: #333;
        }

        .product-card-category {
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 8px;
        }

        .product-card-price {
            font-size: 0.95rem;
            font-weight: 700;
            color: #cead42;
            margin-bottom: 8px;
        }

        .product-card-rating {
            font-size: 0.8rem;
            color: #f39c12;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .product-card-rating span {
            color: #777;
        }

        .product-card-add-to-cart {
            width: 100%;
            margin-top: 12px;
            padding: 10px 15px;
            background: #cead42;
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Tajawal', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .product-card-add-to-cart:hover {
            background: #033a7a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(206, 173, 66, 0.3);
        }

        .product-card-add-to-cart:active {
            transform: translateY(0);
        }

        .product-card-add-to-cart.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .add-to-cart-icon {
            font-size: 1.1rem;
        }

        .products-pagination {
            margin-top: 20px;
        }

        .products-pagination .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            list-style: none;
        }

        .products-pagination .pagination li a,
        .products-pagination .pagination li span {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 4px;
            background: #fff;
            border: 1px solid #ddd;
            font-size: 0.85rem;
            color: #555;
            text-decoration: none;
        }

        .products-pagination .pagination li.active span {
            background: #cead42;
            border-color: #cead42;
            color: white;
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

            .products-hero-title {
                font-size: 2.2rem;
            }

            .products-page {
                grid-template-columns: 1fr;
            }

            .products-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .products-grid {
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
    <section class="products-hero">
        <div class="products-hero-bg">
            <img src="https://lotussnacks.com/wp-content/uploads/2023/05/footer-img001-1.jpg" alt="Our Products">
        </div>
        <div class="products-hero-overlay"></div>
        <div class="products-hero-content">
            <h1 class="products-hero-title">Our Products</h1>
            <p class="products-hero-subtitle">Discover all our product ranges and categories, crafted with premium ingredients to deliver joyful moments for everyone.</p>
        </div>
        <canvas id="productsHeroWaveCanvas" class="products-hero-wave-canvas"></canvas>
    </section>

    <!-- Products Layout -->
    <section class="products-page">
        <!-- Filters -->
        <aside class="products-filters">
            <h3 class="filter-title">Filter Products</h3>
            <form method="GET">
                <!-- Price Filter -->
                <div class="filter-group">
                    <h4>Price</h4>
                    <div class="filter-row">
                        <input type="number" step="0.01" min="0" name="min_price" id="min_price" class="filter-input" placeholder="Min" value="{{ request('min_price') }}">
                        <input type="number" step="0.01" min="0" name="max_price" id="max_price" class="filter-input" placeholder="Max" value="{{ request('max_price') }}">
                    </div>
                </div>

                <!-- Categories Filter -->
                <div class="filter-group">
                    <h4>Categories</h4>
                    <div class="filter-checkbox-list">
                        @foreach($categories as $category)
                            <label class="filter-checkbox-label">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, (array) request('categories', [])) ? 'checked' : '' }}>
                                <span>{{ $category->name_en ?? $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Rating Filter -->
                <div class="filter-group">
                    <h4>Rating</h4>
                    @php $ratingValue = request('rating'); @endphp
                    @foreach([4,3,2,1] as $stars)
                        <label class="filter-rating-option">
                            <input type="radio" name="rating" value="{{ $stars }}" {{ (string)$ratingValue === (string)$stars ? 'checked' : '' }}>
                            <span>
                                @for($i = 0; $i < $stars; $i++) ★ @endfor
                                &amp; up
                            </span>
                        </label>
                    @endforeach
                    <label class="filter-rating-option">
                        <input type="radio" name="rating" value="" {{ $ratingValue === null || $ratingValue === '' ? 'checked' : '' }}>
                        <span>Any rating</span>
                    </label>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="filter-submit">Apply</button>
                    <a href="{{ route('products') }}" class="filter-reset">Reset</a>
                </div>
            </form>
        </aside>

        <!-- Products -->
        <div class="products-main">
            <div class="products-summary">
                <div>
                    Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </div>
            </div>

            <div class="products-grid">
                @forelse($products as $product)
                    <div class="product-card">
                        <a href="{{ route('product.show', $product) }}" class="product-card-image-link">
                            <div class="product-card-image">
                                @if($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->name }}">
                                @else
                                    <svg width="60" height="60" fill="#999" viewBox="0 0 24 24">
                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                @endif
                            </div>
                        </a>
                        <div class="product-card-body">
                            <a href="{{ route('product.show', $product) }}" class="product-card-title-link">
                                <h3 class="product-card-title">{{ $product->name }}</h3>
                            </a>
                            @if($product->category)
                                <div class="product-card-category">{{ $product->category->name_en ?? $product->category->name }}</div>
                            @endif
                            <div class="product-card-price">{{ number_format($product->price, 2) }} EGP</div>
                            @php
                                $avgRating = $product->reviews_avg_rating ?? $product->reviews->avg('rating');
                            @endphp
                            <div class="product-card-rating">
                                @if($avgRating)
                                    <span>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($avgRating)) ★ @else ☆ @endif
                                        @endfor
                                    </span>
                                    <span>({{ number_format($avgRating, 1) }})</span>
                                @else
                                    <span>No reviews yet</span>
                                @endif
                            </div>
                            <button class="product-card-add-to-cart" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">
                                <span class="add-to-cart-icon">🛒</span>
                                <span class="add-to-cart-text">Add to Cart</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <p>No products found for the selected filters.</p>
                @endforelse
            </div>

            <div class="products-pagination">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </section>

    <script>
        // رسم موجة أسفل هيدر منتجات باستخدام Canvas
        function drawProductsHeroWave() {
            const canvas = document.getElementById('productsHeroWaveCanvas');
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
            document.addEventListener('DOMContentLoaded', drawProductsHeroWave);
        } else {
            drawProductsHeroWave();
        }

        // Add to Cart functionality
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.product-card-add-to-cart');
            
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    const originalText = this.querySelector('.add-to-cart-text').textContent;
                    
                    // Disable button and show loading
                    this.classList.add('loading');
                    this.querySelector('.add-to-cart-text').textContent = 'Adding...';
                    
                    // Send AJAX request
                    fetch(`/cart/add/${productId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            quantity: 1
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            this.querySelector('.add-to-cart-text').textContent = 'Added!';
                            this.style.background = '#28a745';
                            
                            // Update cart count if cart icon exists
                            updateCartCount(data.cart_count);
                            
                            // Show toast notification
                            showToast(`${productName} added to cart!`, 'success');
                            
                            // Reset button after 2 seconds
                            setTimeout(() => {
                                this.classList.remove('loading');
                                this.querySelector('.add-to-cart-text').textContent = originalText;
                                this.style.background = '';
                            }, 2000);
                        } else {
                            showToast(data.message || 'Failed to add product to cart', 'error');
                            this.classList.remove('loading');
                            this.querySelector('.add-to-cart-text').textContent = originalText;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred. Please try again.', 'error');
                        this.classList.remove('loading');
                        this.querySelector('.add-to-cart-text').textContent = originalText;
                    });
                });
            });
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

        // Price filter validation
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');
        
        if (minPriceInput && maxPriceInput) {
            // Update max_price min attribute when min_price changes
            minPriceInput.addEventListener('input', function() {
                const minValue = parseFloat(this.value) || 0;
                maxPriceInput.setAttribute('min', minValue);
            });
            
            // Validate max_price on form submit
            const filterForm = minPriceInput.closest('form');
            if (filterForm) {
                filterForm.addEventListener('submit', function(e) {
                    const minValue = parseFloat(minPriceInput.value);
                    const maxValue = parseFloat(maxPriceInput.value);
                    
                    if (minValue && maxValue && maxValue < minValue) {
                        e.preventDefault();
                        showToast('Maximum price must be greater than or equal to minimum price.', 'error');
                        maxPriceInput.focus();
                        return false;
                    }
                });
            }
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

        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuClose = document.getElementById('mobileMenuClose');
            const body = document.body;

            function openMobileMenu() {
                console.log('Opening mobile menu');
                if (mobileMenuToggle) mobileMenuToggle.classList.add('active');
                if (mobileMenu) {
                    mobileMenu.classList.add('active');
                    console.log('Mobile menu classes:', mobileMenu.classList.toString());
                }
                if (body) body.style.overflow = 'hidden';
            }

            function closeMobileMenu() {
                console.log('Closing mobile menu');
                if (mobileMenuToggle) mobileMenuToggle.classList.remove('active');
                if (mobileMenu) mobileMenu.classList.remove('active');
                if (body) body.style.overflow = '';
            }

            if (mobileMenuToggle) {
                console.log('Mobile menu toggle found');
                mobileMenuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openMobileMenu();
                });
            } else {
                console.log('Mobile menu toggle NOT found');
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

                // Close menu when clicking on a link
                const mobileMenuLinks = mobileMenu.querySelectorAll('.mobile-menu-link');
                mobileMenuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        setTimeout(closeMobileMenu, 300);
                    });
                });
            }

            // Close menu on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileMenu && mobileMenu.classList.contains('active')) {
                    closeMobileMenu();
                }
            });
        });
    </script>
</body>
</html>
