<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Loutes Store</title>
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
            background-color:rgb(255, 255, 255);
        }

        /* Header */
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

        /* Top Bar */
        .top-bar {
            background: rgba(206, 173, 66, 0.95);
            backdrop-filter: blur(10px);
            color: white;
            padding: 10px 20px;
        }

        .top-bar-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .language-selector {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            cursor: pointer;
        }

        .welcome-text {
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Main Navigation */
        .main-nav {
            background: white;
            padding: 15px 20px;
        }

        .main-nav-content {
            max-width: 1400px;
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
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .get-quote-btn:hover {
            background: #b89a35;
        }

        .search-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f5f5f5;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-icon:hover {
            background: #e5e5e5;
        }

        .nav-center {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-link {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            transition: color 0.3s;
            position: relative;
        }

        .nav-link:hover {
            color: #cead42;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: #cead42;
            left: 0;
            bottom: -5px;
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
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
            width: 40px;
            height: 40px;
            background: #cead42;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
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
            margin-bottom: 3px;
        }

        .logo-text-en {
            font-size: 14px;
            color: #333;
            letter-spacing: 3px;
            font-weight: 600;
        }

        /* مساحة فارغة أسفل الـ Header */
        .header-spacer {
            height: 0;
            width: 100%;
            display: block;
        }

        /* Header Banner */
        .about-header {
            position: relative;
            width: 100%;
            height: 500px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 0px;
            padding-top: 50px;
        }

        .about-header-bg {
            position: absolute;
            top: 25px;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .about-header-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(4px);
            transform: scale(1.1);
        }

        .about-header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(206, 173, 66, 0.4);
            z-index: 2;
        }

        .about-header-content {
            position: relative;
            z-index: 3;
            text-align: center;
            color: white;
        }

        .about-header-title {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .about-breadcrumb {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .about-breadcrumb a {
            color: white;
            text-decoration: none;
        }

        .about-breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Wave Canvas */
        .about-wave-canvas {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            z-index: 4;
            pointer-events: none;
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

            .about-header-title {
                font-size: 2.5rem;
            }
        }

        /* About Content Section */
        .about-content-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px;
            text-align: center;
            background: white;
        }

        .about-badge {
            display: inline-block;
            background: #666;
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .about-main-heading {
            font-size: 3.5rem;
            font-weight: 700;
            color: #cead42;
            margin-bottom: 40px;
            line-height: 1.2;
        }

        .about-text-content {
            max-width: 900px;
            margin: 0 auto;
        }

        .about-paragraph {
            font-size: 1.1rem;
            color: #333;
            line-height: 1.8;
            margin-bottom: 25px;
            text-align: center;
        }

        .about-paragraph:last-child {
            margin-bottom: 0;
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
            .about-main-heading {
                font-size: 2.5rem;
            }

            .about-paragraph {
                font-size: 1rem;
            }
        }

        /* About Story Section */
        .about-story-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-story-content {
            background: white;
            padding: 40px;
        }

        .about-story-heading {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
            line-height: 1.4;
        }

        .about-story-text {
            font-size: 1.1rem;
            color: #333;
            line-height: 1.8;
        }

        .about-product-ad {
            position: relative;
            background: linear-gradient(135deg, #d4a574 0%, #c9a06b 100%);
            border-radius: 15px;
            padding: 60px 40px;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .about-product-ad::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0,100 Q50,50 100,100 T200,100' stroke='%23b8956a' stroke-width='2' fill='none' opacity='0.3'/%3E%3Cpath d='M0,150 Q50,100 100,150 T200,150' stroke='%23b8956a' stroke-width='2' fill='none' opacity='0.3'/%3E%3C/svg%3E") repeat;
            opacity: 0.2;
        }

        .about-product-container {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .about-product-image {
            max-width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: contain;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,0.3));
        }

        .about-product-text {
            position: absolute;
            right: -20px;
            top: 50%;
            transform: translateY(-50%) rotate(-90deg);
            font-size: 1.5rem;
            font-weight: 900;
            color: white;
            white-space: nowrap;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            letter-spacing: 2px;
        }

        .about-product-decorative {
            position: absolute;
            z-index: 1;
        }

        .about-product-sphere {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            position: absolute;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.2));
        }

        .about-product-sphere.silver {
            background: linear-gradient(135deg, #e8e8e8 0%, #c0c0c0 100%);
            left: 10%;
            top: 20%;
        }

        .about-product-sphere.gold {
            background: linear-gradient(135deg, #ffd700 0%, #ffb347 100%);
            right: 15%;
            bottom: 25%;
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
            .about-story-section {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .about-story-heading {
                font-size: 1.5rem;
            }

            .about-product-ad {
                min-height: 400px;
            }

            .about-product-text {
                display: none;
            }
        }

        /* CTA Section */
        .cta-section {
            position: relative;
            width: 100%;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .cta-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .cta-bg-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(3px);
            transform: scale(1.1);
        }

        .cta-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 2;
        }

        .cta-content {
            position: relative;
            z-index: 3;
            max-width: 1400px;
            width: 100%;
            padding: 40px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .cta-text-wrapper {
            flex: 1;
            color: white;
        }

        .cta-main-text {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .cta-sub-text {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .cta-button-wrapper {
            flex-shrink: 0;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 18px 35px;
            background: linear-gradient(135deg, #E8C95B 0%, #F5D87A 100%);
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 8px;
            transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            background: linear-gradient(135deg, #F5D87A 0%, #E8C95B 100%);
        }

        .cta-button svg {
            width: 20px;
            height: 20px;
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
            .cta-content {
                flex-direction: column;
                text-align: center;
                padding: 40px 20px;
            }

            .cta-main-text {
                font-size: 2rem;
            }

            .cta-sub-text {
                font-size: 1rem;
            }

            .cta-button {
                padding: 15px 30px;
                font-size: 1rem;
            }
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid #e5e5e5;
            padding: 40px 20px 20px;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 30px;
            border-bottom: 1px solid #e5e5e5;
            margin-bottom: 30px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .footer-logo img {
            max-height: 50px;
            max-width: 150px;
            object-fit: contain;
            display: block;
        }

        .footer-logo-icon {
            width: 50px;
            height: 50px;
            color: #cead42;
        }

        .footer-logo-text {
            display: flex;
            flex-direction: column;
        }

        .footer-logo-ar {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            line-height: 1;
            margin-bottom: 3px;
        }

        .footer-logo-en {
            font-size: 14px;
            color: #333;
            letter-spacing: 3px;
            font-weight: 600;
        }

        .footer-nav {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .footer-nav-link {
            color: #333;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        .footer-nav-link:hover {
            color: #cead42;
        }

        .footer-nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: #cead42;
            left: 0;
            bottom: -5px;
            transition: width 0.3s;
        }

        .footer-nav-link:hover::after {
            width: 100%;
        }

        .footer-social {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .footer-social-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: transform 0.3s, background 0.3s;
        }

        .footer-social-facebook {
            background: #cead42;
            color: white;
        }

        .footer-social-facebook svg {
            width: 24px;
            height: 24px;
        }

        .footer-social-instagram {
            background: transparent;
            color: #cead42;
            border: 2px solid #cead42;
        }

        .footer-social-instagram svg {
            width: 24px;
            height: 24px;
        }

        .footer-social-icon:hover {
            transform: scale(1.1);
        }

        .footer-social-facebook:hover {
            background: #b89a38;
        }

        .footer-social-instagram:hover {
            background: #cead42;
            color: white;
        }

        .footer-copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e5e5e5;
        }

        .footer-copyright p {
            color: #666;
            font-size: 14px;
            margin: 0;
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
            .footer-content {
                flex-direction: column;
                gap: 30px;
                text-align: center;
            }

            .footer-nav {
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }

            .footer-logo {
                justify-content: center;
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

    <!-- Spacer للـ Header الثابت -->
    <div class="header-spacer"></div>

    <!-- Header Banner -->
    <section class="about-header">
        <div class="about-header-bg">
            <img src="https://lotussnacks.com/wp-content/uploads/2023/05/paget-title-img002.jpg" alt="Background">
        </div>
        <div class="about-header-overlay"></div>
        <div class="about-header-content">
            <h1 class="about-header-title">About Us</h1>
            <div class="about-breadcrumb">
                <a href="{{ route('home') }}">Home</a> > About Us
            </div>
        </div>
        <canvas id="aboutWaveCanvas" class="about-wave-canvas"></canvas>
    </section>

    <!-- About Content Section -->
    <section class="about-content-section">
        <div class="about-badge">Established in 1993</div>
        <h2 class="about-main-heading">Lotus For Food Industries</h2>
        <div class="about-text-content">
            <p class="about-paragraph">
                We are a specialized manufacturing company dedicated to delivering high-quality products that offer an exceptional experience to our customers.
<br>
Our foundation is built on a clear vision centered around innovation, commitment, and operating with world-class standards at every stage of production.
<br>
We believe that success begins with the details. That’s why we carefully select premium raw materials, apply strict quality control systems, and continuously invest in advanced production technologies.
<br>
With a skilled and passionate team, our company has earned a strong reputation in the market and gained the trust of customers by providing products that combine quality, refined taste, and reliability.
<br>
Today, we continue our journey of regional expansion and market growth while staying true to our core values that guide us in delivering excellence and creating moments of joy.
            </p>

        </div>
    </section>

    <!-- About Story Section -->
    <section class="about-story-section">
        <!-- Text Content -->
        <div class="about-story-content">
            <h2 class="about-story-heading">
            Our Story
                    </h2>
            <p class="about-story-text">

               Our journey began with a simple passion that grew into a dream—one that evolved into a project aiming to become a distinguished name in the world of manufacturing.
            <br>
The company was founded on the desire to offer a unique experience that reflects craftsmanship, authenticity, and a deep commitment to quality.
<br>
Over time, our ideas matured, our capabilities expanded, and we built a strong identity based on innovation, quality, and teamwork.
<br>
Like any successful journey, we faced challenges in the early days—but determination shaped who we are today. Every step strengthened our expertise, refined our processes, and elevated the standard of what we deliver.
Today, the story continues with new chapters driven by passion, quality, and a genuine desire to create value and serve our customers with excellence            </p>
        </div>

        <!-- Product Ad -->
        <div class="about-product-ad">
            <div class="about-product-sphere silver"></div>
            <div class="about-product-sphere gold"></div>
            <div class="about-product-container">
                <img src="https://via.placeholder.com/400x500/8B4513/FFFFFF?text=DaVinci+Premium+Selection" alt="DaVinci Premium Selection" class="about-product-image">
            </div>
            <div class="about-product-text">PREMIUM QUALITY REAL CHOCOLATE</div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-background">
            <img src="https://lotussnacks.com/wp-content/uploads/2023/05/footer-img001-1.jpg" alt="Background" class="cta-bg-image">
            <div class="cta-overlay"></div>
        </div>
        <div class="cta-content">
            <div class="cta-text-wrapper">
                <h2 class="cta-main-text">Let's start working together now</h2>
                <p class="cta-sub-text">For more information about the products offered by the company, do not hesitate to contact us.</p>
            </div>
            <div class="cta-button-wrapper">
                <a href="{{ route('contact') }}" class="cta-button">
                    Get A Quote
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <script>
        // رسم موجة متحركة في أسفل Header
        function drawAboutWave() {
            const canvas = document.getElementById('aboutWaveCanvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const width = canvas.width = canvas.offsetWidth;
            const height = canvas.height = 150;

            let time = 0;

            function animate() {
                ctx.clearRect(0, 0, width, height);

                // موجة أولى - موجهة لأسفل
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
                ctx.fillStyle = 'white';
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
                ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
                ctx.fill();

                time += 0.5;
                requestAnimationFrame(animate);
            }

            animate();

            window.addEventListener('resize', () => {
                canvas.width = canvas.offsetWidth;
            });
        }

        // بدء رسم الموجة عند تحميل الصفحة
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', drawAboutWave);
        } else {
            drawAboutWave();
        }
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

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-logo">
                    @php
                        $logoUrl = \App\Helpers\SiteHelper::getLogo();
                        $hasCustomLogo = \App\Helpers\SiteHelper::hasCustomLogo();
                    @endphp
                    @if($hasCustomLogo)
                        <a href="{{ route('home') }}" style="display: inline-block;">
                            <img src="{{ $logoUrl }}" alt="Logo">
                        </a>
                    @else
                        <div class="footer-logo-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <div class="footer-logo-text">
                            <div class="footer-logo-ar">اللوتس</div>
                            <div class="footer-logo-en">L O T U S</div>
                        </div>
                    @endif
                </div>
                <nav class="footer-nav">
                    <a href="{{ route('home') }}" class="footer-nav-link">Home</a>
                    <a href="{{ route('about') }}" class="footer-nav-link">About Us</a>
                    <a href="#" class="footer-nav-link">Our Products</a>
                    <a href="#" class="footer-nav-link">News</a>
                    <a href="{{ route('contact') }}" class="footer-nav-link">Contact Us</a>
                </nav>
            </div>
            <div class="footer-social">
                <a href="#" class="footer-social-icon footer-social-facebook" target="_blank" rel="noopener noreferrer">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.477 2 2 6.477 2 12c0 5.013 3.693 9.153 8.505 9.876v-6.988H8.031v-2.888h2.474v-2.2c0-2.444 1.456-3.794 3.683-3.794 1.067 0 2.183.191 2.183.191v2.4h-1.23c-1.211 0-1.588.751-1.588 1.523v1.83h2.691l-.43 2.888h-2.261v6.988C18.307 21.153 22 17.013 22 12c0-5.523-4.477-10-10-10z"/>
                    </svg>
                </a>
                <a href="#" class="footer-social-icon footer-social-instagram" target="_blank" rel="noopener noreferrer">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                    </svg>
                </a>
            </div>
            <div class="footer-copyright">
                <p>&copy; {{ date('Y') }} Loutes Store. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>
</body>
</html>
