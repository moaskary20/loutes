<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('web.careers_title') }}</title>
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
            background-color: #ffffff;
        }

        /* Header (copied from About/Contact for consistency) */
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

        /* Main Navigation */
        .main-nav {
            background: rgba(255, 255, 255, 0.95);
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

        .nav-link:hover::after {
            transform: scaleX(1);
        }

        .nav-link:hover {
            color: #044898;
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

        /* Spacer under fixed header */
        .header-spacer {
            height: 0;
            width: 100%;
            display: block;
        }

        /* Hero / Header Banner */
        .careers-header {
            position: relative;
            width: 100%;
            height: 450px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 0;
            padding-top: 50px;
        }

        .careers-header-bg {
            position: absolute;
            top: 25px;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .careers-header-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(4px);
            transform: scale(1.1);
        }

        .careers-header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(4, 72, 152, 0.4);
            z-index: 2;
        }

        .careers-header-content {
            position: relative;
            z-index: 3;
            text-align: center;
            color: white;
        }

        .careers-header-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .careers-header-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Careers Content */
        .careers-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 60px;
            align-items: flex-start;
        }

        .careers-text-block h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }

        .careers-text-block p {
            font-size: 1.05rem;
            color: #555;
            line-height: 1.9;
            margin-bottom: 18px;
        }

        .careers-text-block ul {
            list-style: none;
            padding-left: 0;
        }

        .careers-text-block li {
            font-size: 1.05rem;
            color: #555;
            line-height: 1.8;
            margin-bottom: 10px;
        }

        .careers-text-block li::before {
            content: '•';
            color: #044898;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: 0;
        }

        .careers-side-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 35px 30px;
        }

        .careers-side-card h3 {
            font-size: 1.6rem;
            margin-bottom: 20px;
            color: #333;
        }

        /* Careers Form */
        .careers-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .careers-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .careers-form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .careers-form-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #333;
        }

        .careers-form-label span {
            color: #e74c3c;
        }

        .careers-input,
        .careers-select,
        .careers-textarea {
            width: 100%;
            padding: 10px 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 0.9rem;
            font-family: 'Tajawal', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .careers-input:focus,
        .careers-select:focus,
        .careers-textarea:focus {
            outline: none;
            border-color: #044898;
            box-shadow: 0 0 0 2px rgba(206, 173, 66, 0.25);
        }

        .careers-textarea {
            min-height: 140px;
            resize: vertical;
        }

        .careers-file-note {
            font-size: 0.8rem;
            color: #777;
        }

        .careers-submit-btn {
            margin-top: 10px;
            padding: 10px 24px;
            border-radius: 6px;
            border: none;
            background: #044898;
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            align-self: flex-start;
            transition: background 0.3s, transform 0.2s, box-shadow 0.2s;
        }

        .careers-submit-btn:hover {
            background: #033a7a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.18);
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

            .careers-header-title {
                font-size: 2.4rem;
            }

            .careers-section {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="top-bar-content">
                    <div class="top-bar-left">
                        <div class="language-selector">
                            @include('partials.language-dropdown')
                        </div>
                    </div>
                    <div class="top-bar-center">
                        <span class="welcome-text">
                            {{ __('web.welcome_to_loutes_store') }}
                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Navigation -->
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
                        <a href="{{ route('language.switch', app()->getLocale() == 'ar' ? 'en' : 'ar') }}" class="language-link" style="margin-left: 15px;">
                            <span>{{ app()->getLocale() == 'ar' ? 'English' : 'العربية' }}</span>
                        </a>
                        <a href="{{ route('cart.index') }}" class="cart-icon-wrapper" title="{{ __('web.shopping_cart') }}">
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
                    {{ __('web.shopping_cart') }}
                    @if(\App\Helpers\CartHelper::getCartCount() > 0)
                        <span style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.85rem; margin-left: 10px;">
                            {{ \App\Helpers\CartHelper::getCartCount() }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <!-- Spacer -->
    <div class="header-spacer"></div>

    <!-- Hero -->
    <section class="careers-header">
        <div class="careers-header-bg">
            <img src="https://lotussnacks.com/wp-content/uploads/2023/05/paget-title-img002.jpg" alt="Careers">
        </div>
        <div class="careers-header-overlay"></div>
        <div class="careers-header-content">
            <h1 class="careers-header-title">{{ __('web.careers_heading') }}</h1>
            <p class="careers-header-subtitle">{{ __('web.careers_lotus_family') }}</p>
        </div>
    </section>

    <!-- Careers Content -->
    <section class="careers-section">
        <div class="careers-text-block">
            <h2>{{ __('web.careers_why_work') }}</h2>
            <p>
                {{ __('web.careers_why_work_desc_1') }}
            </p>
            <p>
                {{ __('web.careers_why_work_desc_2') }}
            </p>
            <ul>
                <li>{{ __('web.careers_benefit_1') }}</li>
                <li>{{ __('web.careers_benefit_2') }}</li>
                <li>{{ __('web.careers_benefit_3') }}</li>
                <li>{{ __('web.careers_benefit_4') }}</li>
            </ul>
        </div>
        <div class="careers-side-card">
            <h3>{{ __('web.careers_send_cv') }}</h3>
            <form class="careers-form">
                <div class="careers-form-row">
                    <div class="careers-form-group">
                        <label class="careers-form-label">{{ __('web.careers_name') }} <span>*</span></label>
                        <input type="text" class="careers-input" placeholder="{{ __('web.careers_full_name_placeholder') }}">
                    </div>
                    <div class="careers-form-group">
                        <label class="careers-form-label">{{ __('web.careers_job_title') }} <span>*</span></label>
                        <input type="text" class="careers-input" placeholder="{{ __('web.careers_position_placeholder') }}">
                    </div>
                </div>

                <div class="careers-form-row">
                    <div class="careers-form-group">
                        <label class="careers-form-label">{{ __('web.careers_address') }}</label>
                        <input type="text" class="careers-input" placeholder="{{ __('web.careers_street_address') }}">
                    </div>
                    <div class="careers-form-group">
                        <label class="careers-form-label">{{ __('web.careers_city') }}</label>
                        <input type="text" class="careers-input" placeholder="{{ __('web.careers_city') }}">
                    </div>
                </div>

                <div class="careers-form-row">
                    <div class="careers-form-group">
                        <label class="careers-form-label">{{ __('web.careers_country') }} <span>*</span></label>
                        <input type="text" class="careers-input" placeholder="{{ __('web.careers_country_placeholder') }}">
                    </div>
                    <div class="careers-form-group">
                        <label class="careers-form-label">{{ __('web.careers_phone') }} <span>*</span></label>
                        <input type="text" class="careers-input" placeholder="{{ __('web.careers_phone_placeholder') }}">
                    </div>
                </div>

                <div class="careers-form-row">
                    <div class="careers-form-group">
                        <label class="careers-form-label">{{ __('web.careers_email') }} <span>*</span></label>
                        <input type="email" class="careers-input" placeholder="{{ __('web.careers_email_placeholder') }}">
                    </div>
                    <div class="careers-form-group">
                        <label class="careers-form-label">{{ __('web.careers_upload_cv_label') }} <span>*</span></label>
                        <input type="file" class="careers-input">
                        <div class="careers-file-note">{{ __('web.careers_file_size') }}</div>
                    </div>
                </div>

                <div class="careers-form-group">
                    <label class="careers-form-label">{{ __('web.careers_hear_about') }} <span>*</span></label>
                    <select class="careers-select">
                        <option value="">{{ __('web.careers_hear_select') }}</option>
                        <option>{{ __('web.careers_hear_website') }}</option>
                        <option>{{ __('web.careers_hear_social') }}</option>
                        <option>{{ __('web.careers_hear_friend') }}</option>
                        <option>{{ __('web.careers_hear_portal') }}</option>
                        <option>{{ __('web.careers_hear_other') }}</option>
                    </select>
                </div>

                <div class="careers-form-group">
                    <label class="careers-form-label">{{ __('web.careers_comments') }} <span>*</span></label>
                    <textarea class="careers-textarea" placeholder="{{ __('web.careers_comments_placeholder') }}"></textarea>
                </div>

                <button type="button" class="careers-submit-btn">{{ __('web.careers_send') }}</button>
            </form>
        </div>
    </section>
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

