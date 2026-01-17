<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers - Loutes Store</title>
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
                        <a href="{{ route('home') }}" class="nav-link">Home</a>
                        <a href="{{ route('about') }}" class="nav-link">About Us</a>
                        <a href="{{ route('products') }}" class="nav-link">Our Products</a>
                        <a href="{{ route('careers') }}" class="nav-link">Careers</a>
                        <a href="{{ route('contact') }}" class="nav-link">Contact Us</a>
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

    <!-- Spacer -->
    <div class="header-spacer"></div>

    <!-- Hero -->
    <section class="careers-header">
        <div class="careers-header-bg">
            <img src="https://lotussnacks.com/wp-content/uploads/2023/05/paget-title-img002.jpg" alt="Careers">
        </div>
        <div class="careers-header-overlay"></div>
        <div class="careers-header-content">
            <h1 class="careers-header-title">Join Our Team</h1>
            <p class="careers-header-subtitle">Be part of Lotus Snacks family and help us create joyful moments for our customers.</p>
        </div>
    </section>

    <!-- Careers Content -->
    <section class="careers-section">
        <div class="careers-text-block">
            <h2>Why Work With Lotus?</h2>
            <p>
                At Lotus, we believe that our people are the heart of our success. We bring together talented individuals who are passionate about quality, innovation, and creating unique snacking experiences for our customers.
            </p>
            <p>
                We offer a dynamic and supportive environment where you can grow your career, develop new skills, and contribute to meaningful projects across production, quality, marketing, sales, logistics, and more.
            </p>
            <ul>
                <li>Modern and safe work environment.</li>
                <li>Continuous training and development opportunities.</li>
                <li>Competitive packages and growth plans.</li>
                <li>Strong team spirit and collaborative culture.</li>
            </ul>
        </div>
        <div class="careers-side-card">
            <h3>Send Us Your CV</h3>
            <form class="careers-form">
                <div class="careers-form-row">
                    <div class="careers-form-group">
                        <label class="careers-form-label">Name <span>*</span></label>
                        <input type="text" class="careers-input" placeholder="Your full name">
                    </div>
                    <div class="careers-form-group">
                        <label class="careers-form-label">Job Title <span>*</span></label>
                        <input type="text" class="careers-input" placeholder="Position you are applying for">
                    </div>
                </div>

                <div class="careers-form-row">
                    <div class="careers-form-group">
                        <label class="careers-form-label">Address</label>
                        <input type="text" class="careers-input" placeholder="Street address">
                    </div>
                    <div class="careers-form-group">
                        <label class="careers-form-label">City</label>
                        <input type="text" class="careers-input" placeholder="City">
                    </div>
                </div>

                <div class="careers-form-row">
                    <div class="careers-form-group">
                        <label class="careers-form-label">Country <span>*</span></label>
                        <input type="text" class="careers-input" placeholder="Country">
                    </div>
                    <div class="careers-form-group">
                        <label class="careers-form-label">Phone <span>*</span></label>
                        <input type="text" class="careers-input" placeholder="Phone number">
                    </div>
                </div>

                <div class="careers-form-row">
                    <div class="careers-form-group">
                        <label class="careers-form-label">Email <span>*</span></label>
                        <input type="email" class="careers-input" placeholder="email@example.com">
                    </div>
                    <div class="careers-form-group">
                        <label class="careers-form-label">Upload Your CV <span>*</span></label>
                        <input type="file" class="careers-input">
                        <div class="careers-file-note">Max. file size: 5 MB.</div>
                    </div>
                </div>

                <div class="careers-form-group">
                    <label class="careers-form-label">How did you hear about us? <span>*</span></label>
                    <select class="careers-select">
                        <option value="">Select</option>
                        <option>Website</option>
                        <option>Social Media</option>
                        <option>Friend / Colleague</option>
                        <option>Job Portal</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="careers-form-group">
                    <label class="careers-form-label">Comments and Questions: <span>*</span></label>
                    <textarea class="careers-textarea" placeholder="Write any additional information or questions here"></textarea>
                </div>

                <button type="button" class="careers-submit-btn">Send</button>
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

