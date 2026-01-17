<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loutes Store - الصفحة الرئيسية</title>
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
            margin: 0;
            padding: 0;
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

        /* مساحة فارغة أسفل الـ Header */
        .header-spacer {
            height: 0;
            width: 100%;
        }

        /* Top Bar */
        .top-bar {
            background: rgba(4, 72, 152, 0.95);
            backdrop-filter: blur(10px);
            color: white;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 8px 8px 0 0;
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

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 10px;
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
            cursor: pointer;
        }

        .social-icons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .social-icon {
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cead42;
            font-weight: bold;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .social-icon:hover {
            background: #f0f0f0;
            transform: scale(1.1);
        }

        /* Main Navigation */
        .main-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 20px !important;
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

        .nav-link:hover::after {
            transform: scaleX(1);
        }

        .nav-link:hover {
            color: #cead42;
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

        .slider-container {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 100vh;
            overflow: hidden;
            padding: 0;
            margin: 0;
        }

        .slider-wave-canvas {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            z-index: 2;
            pointer-events: none;
        }

        .slider-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide.active {
            opacity: 1;
            z-index: 1;
        }

        .slide:not(.active) .slide-content {
            opacity: 0;
            animation: none;
        }

        .slide:not(.active) .slide-content h2,
        .slide:not(.active) .slide-content p,
        .slide:not(.active) .slide-content a {
            opacity: 0;
            animation: none;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .slide-content {
            position: absolute;
            top: 200px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            text-align: center;
            color: white;
            padding: 2rem;
            background: transparent;
            border-radius: 10px;
            max-width: 600px;
        }

        .slide-content h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7), 0 0 20px rgba(0, 0, 0, 0.5);
            animation: fadeInLeft 1.2s ease-out 0.3s forwards;
            opacity: 0;
        }

        .slide-content p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.7), 0 0 15px rgba(0, 0, 0, 0.4);
            animation: fadeInRight 1.2s ease-out 0.5s forwards;
            opacity: 0;
        }

        .slide-content a {
            animation: fadeInUp 1s ease-out 0.7s forwards;
            opacity: 0;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-content a {
            display: inline-block;
            padding: 12px 30px;
            background: white;
            color: #cead42;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .slide-content a:hover {
            background: #f0f0f0;
            transform: scale(1.05);
        }

        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: rgba(255, 255, 255, 0.3);
            border: 2px dashed white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .slider-nav:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .slider-nav.prev {
            right: 20px;
        }

        .slider-nav.next {
            left: 20px;
        }

        .slider-nav svg {
            width: 30px;
            height: 30px;
            stroke: white;
            stroke-width: 2;
        }

        /* معاينة الصورة المصغرة */
        .nav-preview {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 220px;
            height: 160px;
            border-radius: 15px;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 9;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            border: 4px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-preview.show {
            opacity: 1;
            visibility: visible;
        }

        .nav-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .nav-preview.prev-preview {
            right: 100px;
        }

        .nav-preview.prev-preview.show {
            right: 90px;
        }

        .nav-preview.next-preview {
            left: 100px;
        }

        .nav-preview.next-preview.show {
            left: 90px;
        }

        .slider-dots {
            position: absolute;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            display: flex;
            gap: 10px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s;
        }

        .dot.active {
            background: white;
            width: 30px;
            border-radius: 6px;
        }

        /* الموجة المتحركة داخل الخلفية */
        .wave-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 200px;
            overflow: hidden;
            z-index: 1;
            pointer-events: none;
        }

        .wave-svg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
        }

        .wave-svg.primary {
            opacity: 0.7;
            animation: waveMove 8s ease-in-out infinite;
        }

        .wave-svg.secondary {
            opacity: 0.5;
            animation: waveMove 6s ease-in-out infinite reverse;
            animation-delay: -1s;
        }

        .wave-svg.primary path {
            fill: rgba(206, 173, 66, 0.5);
        }

        .wave-svg.secondary path {
            fill: rgba(245, 230, 168, 0.6);
        }

        @keyframes waveMove {
            0%, 100% {
                transform: translateX(0) translateY(0);
            }
            50% {
                transform: translateX(-3%) translateY(-15px);
            }
        }

        /* زر View Products */
        .view-products-button {
            position: absolute;
            bottom: 200px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            padding: 15px 40px;
            background: white;
            color: #cead42;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            display: inline-block;
        }

        .view-products-button:hover {
            background: #f0f0f0;
            transform: translateX(-50%) scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        /* قسم الفئات */
        .categories-section {
            background: #f5f5f5;
            padding: 60px 20px;
            position: relative;
            overflow: hidden;
        }

        .categories-container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        .categories-heading {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #cead42;
            margin-bottom: 40px;
        }

        .categories-grid-wrapper {
            position: relative;
            overflow: visible;
            padding: 0;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .category-item {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .category-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .category-image-wrapper {
            width: 100%;
            height: 450px;
            overflow: hidden;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .category-item:hover .category-image-wrapper img {
            transform: scale(1.1);
        }

        .category-name {
            padding: 20px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
        }

        @media (max-width: 968px) {
            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .categories-heading {
                font-size: 2rem;
            }

            .category-image-wrapper {
                height: 120px;
            }
        }

        /* قسم About Us */
        .about-section {
            background: #f5f5f5;
            padding: 80px 20px;
            text-align: center;
            margin-bottom: 130px;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .about-heading {
            font-size: 2.5rem;
            font-weight: 700;
            color:rgb(206, 173, 66);
            margin-bottom: 40px;
            line-height: 1.4;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }

        .about-content {
            display: flex;
            flex-direction: column;
            gap: 25px;
            color: #666;
            font-size: 1.1rem;
            line-height: 1.8;
            max-width: 1000px;
            margin: 0 auto;
            text-align: justify;
            text-align-last: center;
        }

        .about-paragraph {
            margin: 0;
        }

        /* قسم المنتجات */
        .products-section {
            position: relative;
            background: #044898;
            padding: 100px 20px 80px;
            overflow: hidden;
        }

        .products-section-wrapper {
            position: relative;
        }

        .products-section-wave-canvas {
            position: absolute;
            top: -150px;
            left: 0;
            width: 100%;
            height: 150px;
            z-index: 1;
            pointer-events: none;
        }

        .products-section-top-wave {
            position: absolute;
            top: -1px;
            left: 0;
            width: 100%;
            height: 120px;
            overflow: hidden;
            z-index: 1;
        }

        .products-section-top-wave svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
        }

        .products-section-top-wave path {
            fill: #f5f5f5 !important;
            stroke: none !important;
            stroke-width: 0 !important;
        }

        .products-section-top-wave-secondary path {
            fill: #f5f5f5 !important;
            stroke: none !important;
            stroke-width: 0 !important;
            opacity: 0.8;
        }

        .products-section-top-wave-secondary {
            position: absolute;
            top: -1px;
            left: 0;
            width: 100%;
            height: 120px;
            overflow: hidden;
            z-index: 1;
            opacity: 0.7;
        }

        .products-section-top-wave-secondary svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
            animation: waveMoveSecondary 8s ease-in-out infinite;
        }

        .products-section-top-wave svg {
            animation: waveMovePrimary 6s ease-in-out infinite;
        }

        @keyframes waveMovePrimary {
            0%, 100% {
                transform: translateX(0);
            }
            50% {
                transform: translateX(-2%);
            }
        }

        @keyframes waveMoveSecondary {
            0%, 100% {
                transform: translateX(0);
            }
            50% {
                transform: translateX(2%);
            }
        }

        .products-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
            z-index: 2;
        }


        .products-text-content {
            color: white;
        }

        .products-heading {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 30px;
            line-height: 1.2;
            color: white;
        }

        .products-description {
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 40px;
            opacity: 0.95;
        }

        .products-view-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 30px;
            background: transparent;
            color: white;
            border: 1px solid white;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s;
            cursor: pointer;
        }

        .products-view-btn:hover {
            background: white;
            color: #cead42;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .products-cards-wrapper {
            position: relative;
            overflow: hidden;
        }

        .products-cards-container {
            overflow: hidden;
            width: 100%;
        }

        .products-cards {
            display: flex;
            gap: 0;
            transition: transform 0.5s ease;
            width: 100%;
        }

        .products-cards-slide {
            min-width: 100%;
            flex-shrink: 0;
        }

        .products-cards-slide > div {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.3s;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .product-card-image {
            width: 100%;
            height: 250px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 3rem;
            overflow: hidden;
        }

        .product-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .product-card:hover .product-card-image img {
            transform: scale(1.05);
        }

        .product-card-body {
            padding: 20px;
            text-align: center;
        }

        .product-card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            line-height: 1.3;
        }

        .product-card-subtitle {
            font-size: 0.85rem;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .product-card-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #cead42;
            margin-top: 10px;
        }

        .product-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .products-carousel-dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }

        .product-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s;
        }

        .product-dot.active {
            background: white;
            width: 30px;
            border-radius: 6px;
        }

        /* قسم التصدير */
        .export-section {
            padding: 8px 20px;
            background: #f5f5f5;
        }

        .export-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            min-height: 30px;
        }

        .export-product-side {
            background: transparent;
            position: relative;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .export-product-side img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .export-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            z-index: 2;
        }

        .export-logo-icon {
            width: 50px;
            height: 50px;
            color: #cead42;
        }

        .export-logo-text {
            display: flex;
            flex-direction: column;
        }

        .export-logo-ar {
            font-size: 24px;
            font-weight: bold;
            color: #cead42;
            line-height: 1;
        }

        .export-logo-en {
            font-size: 14px;
            color: #333;
            letter-spacing: 2px;
            font-weight: 600;
        }

        .export-logo-spec {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }

        .export-brand {
            text-align: center;
            position: relative;
            z-index: 2;
            margin: 40px 0;
        }

        .export-brand-ar {
            font-size: 48px;
            font-weight: 700;
            color: #333;
            font-style: italic;
            line-height: 1;
            margin-bottom: 10px;
        }

        .export-brand-en {
            font-size: 36px;
            font-weight: 600;
            color: #666;
            font-style: italic;
        }

        .export-product-display {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
        }

        .export-product-container {
            position: relative;
            width: 300px;
            height: 300px;
        }

        .export-product-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .export-product-image::before {
            content: '';
            position: absolute;
            width: 280px;
            height: 280px;
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(0,0,0,0.1);
        }

        .export-product-label {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #9B59B6 0%, #3498DB 100%);
            padding: 15px 25px;
            border-radius: 10px;
            color: white;
            text-align: center;
            min-width: 200px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .export-label-brand {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .export-label-title {
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .export-label-title-ar {
            font-size: 12px;
            font-weight: 500;
        }

        .export-text-side {
            background: white;
            padding: 6px 25px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .export-watermark {
            position: absolute;
            opacity: 0.05;
            z-index: 1;
        }

        .export-watermark-airplane {
            top: 10%;
            right: 10%;
            width: 150px;
            height: 150px;
            color: #cead42;
        }

        .export-watermark-globe {
            bottom: 10%;
            left: 10%;
            width: 200px;
            height: 200px;
            color: #cead42;
        }

        .export-text-content {
            position: relative;
            z-index: 2;
        }

        .export-text-orange {
            color: #FF6B35;
            font-size: 18px;
            font-weight: 600;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .export-text-grey {
            color: #666;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        .export-text-grey:last-child {
            margin-bottom: 0;
        }

        /* قسم الفيديو (معكوس) */
        .video-section {
            padding: 8px 20px;
            background: #f5f5f5;
        }

        .video-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            min-height: 30px;
        }

        .video-text-side {
            background: white;
            padding: 6px 25px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .video-watermark {
            position: absolute;
            opacity: 0.05;
            z-index: 1;
        }

        .video-watermark-airplane {
            top: 10%;
            right: 10%;
            width: 150px;
            height: 150px;
            color: #cead42;
        }

        .video-watermark-globe {
            bottom: 10%;
            left: 10%;
            width: 200px;
            height: 200px;
            color: #cead42;
        }

        .video-text-content {
            position: relative;
            z-index: 2;
        }

        .video-text-orange {
            color: #FF6B35;
            font-size: 18px;
            font-weight: 600;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .video-text-grey {
            color: #666;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        .video-text-grey:last-child {
            margin-bottom: 0;
        }

        .video-display-side {
            background: transparent;
            position: relative;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .video-display-side img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .video-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            z-index: 2;
        }

        .video-logo-icon {
            width: 50px;
            height: 50px;
            color: #cead42;
        }

        .video-logo-text {
            display: flex;
            flex-direction: column;
        }

        .video-logo-ar {
            font-size: 24px;
            font-weight: bold;
            color: #cead42;
            line-height: 1;
        }

        .video-logo-en {
            font-size: 14px;
            color: #333;
            letter-spacing: 2px;
            font-weight: 600;
        }

        .video-logo-spec {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }

        .video-brand {
            text-align: center;
            position: relative;
            z-index: 2;
            margin: 40px 0;
        }

        .video-brand-ar {
            font-size: 48px;
            font-weight: 700;
            color: #333;
            font-style: italic;
            line-height: 1;
            margin-bottom: 10px;
        }

        .video-brand-en {
            font-size: 36px;
            font-weight: 600;
            color: #666;
            font-style: italic;
        }

        .video-player-container {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
        }

        .video-wrapper {
            position: relative;
            width: 100%;
            max-width: 500px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }

        .video-player {
            width: 100%;
            height: auto;
            display: block;
            background: #000;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .video-wrapper:hover .video-overlay {
            opacity: 1;
        }

        .video-play-button {
            width: 80px;
            height: 80px;
            background: rgba(206, 173, 66, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            pointer-events: all;
            transition: transform 0.3s, background 0.3s;
        }

        .video-play-button:hover {
            transform: scale(1.1);
            background: rgba(206, 173, 66, 1);
        }

        .video-play-button svg {
            width: 40px;
            height: 40px;
            margin-left: 5px;
        }

        @media (max-width: 968px) {
            .products-container {
                grid-template-columns: 1fr;
            }
            
            .export-container {
                grid-template-columns: 1fr;
            }
            
            .video-container {
                grid-template-columns: 1fr;
            }

            .products-heading {
                font-size: 2rem;
            }
        }

        /* قسم دعوة للعمل */
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
            background: linear-gradient(135deg, #044898 0%, #0666c4 100%);
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 8px;
            border: 2px solid rgba(4, 72, 152, 0.8);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            background: linear-gradient(135deg, #0666c4 0%, #044898 100%);
        }

        .cta-button svg {
            width: 20px;
            height: 20px;
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

            .welcome-text {
                display: none;
            }

            .slide img {
                padding-top: 210px;
            }

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
                <div class="top-bar-right">
                    <span>Follow us on</span>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/share/18ALRh5g9A/?mibextid=wwXIfr" target="_blank" rel="noopener noreferrer" class="social-icon" aria-label="Facebook">f</a>
                        <a href="https://www.instagram.com/lotussweetsegypt?igsh=MWUwaHAwbzJtcXI0Yw==" target="_blank" rel="noopener noreferrer" class="social-icon" aria-label="Instagram">📷</a>
                    </div>
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

    <div class="slider-container">
        <div class="slider-wrapper" id="sliderWrapper">
            @forelse($sliders as $index => $slider)
                <div class="slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}">
                    @if($slider->title || $slider->description)
                        <div class="slide-content">
                            @if($slider->title)
                                <h2>{{ $slider->title }}</h2>
                            @endif
                            @if($slider->description)
                                <p>{{ $slider->description }}</p>
                            @endif
                            @if($slider->link)
                                <a href="{{ $slider->link }}">عرض المزيد</a>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="slide active">
                    <div class="slide-content">
                        <h2>مرحباً بك في Loutes Store</h2>
                        <p>أضف صور السليدر من لوحة التحكم</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($siteSettings->view_products_link)
            <a href="{{ $siteSettings->view_products_link }}" class="view-products-button">
                View Products
            </a>
        @endif

        @if($sliders->count() > 1)
            <div class="slider-nav prev" onclick="changeSlide(-1)" onmouseenter="showPreview('prev')" onmouseleave="hidePreview('prev')">
                <svg fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
            <div class="nav-preview prev-preview" id="prevPreview">
                <img src="" alt="Previous" id="prevPreviewImg">
            </div>

            <div class="slider-nav next" onclick="changeSlide(1)" onmouseenter="showPreview('next')" onmouseleave="hidePreview('next')">
                <svg fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </div>
            <div class="nav-preview next-preview" id="nextPreview">
                <img src="" alt="Next" id="nextPreviewImg">
            </div>

            <div class="slider-dots">
                @foreach($sliders as $index => $slider)
                    <div class="dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></div>
                @endforeach
            </div>
        @endif

        <canvas id="sliderWaveCanvas" class="slider-wave-canvas"></canvas>
    </div>

    <!-- قسم الفئات -->
    @if($categories->count() > 0)
    <section class="categories-section">
        <div class="categories-container">
            <h2 class="categories-heading">Our Categories</h2>
            <div class="categories-grid-wrapper">
                <div class="categories-grid">
                    @foreach($categories as $category)
                        <a href="{{ route('products', ['categories' => [$category->id]]) }}" class="category-item">
                            <div class="category-image-wrapper">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name_en ?? $category->name }}">
                                @else
                                    <svg width="80" height="80" fill="#cead42" viewBox="0 0 24 24">
                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="category-name">
                                {{ $category->name_en ?? $category->name }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        const totalSlides = slides.length;
        const sliderImages = @json($sliders->pluck('image'));

        function showSlide(index) {
            // إزالة active من جميع الشرائح
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            // إضافة active للشريحة الحالية
            if (slides[index]) {
                slides[index].classList.add('active');
            }
            if (dots[index]) {
                dots[index].classList.add('active');
            }

            // تحديث معاينة الصور
            updatePreviews();
        }

        function changeSlide(direction) {
            currentSlide += direction;
            
            if (currentSlide >= totalSlides) {
                currentSlide = 0;
            } else if (currentSlide < 0) {
                currentSlide = totalSlides - 1;
            }
            
            showSlide(currentSlide);
        }

        function goToSlide(index) {
            currentSlide = index;
            showSlide(currentSlide);
        }

        function updatePreviews() {
            // معاينة الصورة السابقة (prev)
            const prevIndex = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1;
            const prevPreviewImg = document.getElementById('prevPreviewImg');
            if (prevPreviewImg && sliderImages[prevIndex]) {
                prevPreviewImg.src = '{{ asset("storage/") }}/' + sliderImages[prevIndex];
            }

            // معاينة الصورة التالية (next)
            const nextIndex = currentSlide === totalSlides - 1 ? 0 : currentSlide + 1;
            const nextPreviewImg = document.getElementById('nextPreviewImg');
            if (nextPreviewImg && sliderImages[nextIndex]) {
                nextPreviewImg.src = '{{ asset("storage/") }}/' + sliderImages[nextIndex];
            }
        }

        function showPreview(type) {
            const preview = document.getElementById(type + 'Preview');
            if (preview) {
                preview.classList.add('show');
            }
        }

        function hidePreview(type) {
            const preview = document.getElementById(type + 'Preview');
            if (preview) {
                preview.classList.remove('show');
            }
        }

        // تحديث المعاينة عند التحميل
        if (totalSlides > 0) {
            showSlide(0);
        }

        // التبديل التلقائي كل 5 ثواني
        if (totalSlides > 1) {
            setInterval(() => {
                changeSlide(1);
            }, 5000);
        }

        // سليدر المنتجات
        let currentProductSlide = 0;
        const productSlides = document.querySelectorAll('.products-cards-slide');
        const totalProductSlides = productSlides.length;
        const productsCards = document.getElementById('productsCards');
        const productsCarouselDots = document.getElementById('productsCarouselDots');

        // إنشاء النقاط ديناميكياً
        if (productsCarouselDots && totalProductSlides > 0) {
            for (let i = 0; i < totalProductSlides; i++) {
                const dot = document.createElement('div');
                dot.className = 'product-dot' + (i === 0 ? ' active' : '');
                dot.onclick = () => goToProductSlide(i);
                productsCarouselDots.appendChild(dot);
            }
        }

        function showProductSlide(index) {
            if (productsCards && totalProductSlides > 0) {
                const translateX = -(index * 100);
                productsCards.style.transform = `translateX(${translateX}%)`;

                // تحديث النقاط
                const dots = document.querySelectorAll('.product-dot');
                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === index);
                });
            }
        }

        function changeProductSlide(direction) {
            currentProductSlide += direction;
            if (currentProductSlide >= totalProductSlides) {
                currentProductSlide = 0;
            } else if (currentProductSlide < 0) {
                currentProductSlide = totalProductSlides - 1;
            }
            showProductSlide(currentProductSlide);
        }

        function goToProductSlide(index) {
            currentProductSlide = index;
            showProductSlide(currentProductSlide);
        }

        // التبديل التلقائي للمنتجات كل 4 ثواني
        if (totalProductSlides > 1) {
            setInterval(() => {
                changeProductSlide(1);
            }, 4000);
        }

        // رسم موجة متحركة في قسم المنتجات
        function drawProductsWave() {
            const canvas = document.getElementById('productsWaveCanvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const width = canvas.width = canvas.offsetWidth;
            const height = canvas.height = 150;

            let time = 0;

            function animate() {
                ctx.clearRect(0, 0, width, height);

                // موجة أولى - تبدأ من الأعلى
                ctx.beginPath();
                ctx.moveTo(0, 0);
                
                for (let x = 0; x <= width; x += 1) {
                    const y = 50 + Math.sin((x * 0.01) + (time * 0.02)) * 30 + 
                              Math.cos((x * 0.015) + (time * 0.015)) * 20;
                    ctx.lineTo(x, y);
                }
                
                ctx.lineTo(width, height);
                ctx.lineTo(0, height);
                ctx.lineTo(0, 0);
                ctx.closePath();
                ctx.fillStyle = '#044898';
                ctx.fill();

                // موجة ثانية (أخف) - تبدأ من الأعلى
                ctx.beginPath();
                ctx.moveTo(0, 0);
                
                for (let x = 0; x <= width; x += 1) {
                    const y = 40 + Math.sin((x * 0.012) + (time * 0.025)) * 25 + 
                              Math.cos((x * 0.018) + (time * 0.02)) * 15;
                    ctx.lineTo(x, y);
                }
                
                ctx.lineTo(width, height);
                ctx.lineTo(0, height);
                ctx.lineTo(0, 0);
                ctx.closePath();
                ctx.fillStyle = 'rgba(4, 72, 152, 0.7)';
                ctx.fill();

                time += 0.5;
                requestAnimationFrame(animate);
            }

            animate();

            // إعادة الرسم عند تغيير حجم النافذة
            window.addEventListener('resize', () => {
                canvas.width = canvas.offsetWidth;
            });
        }

        // بدء رسم الموجة عند تحميل الصفحة
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', drawProductsWave);
        } else {
            drawProductsWave();
        }

        // رسم موجة متحركة في أسفل السليدر
        function drawSliderWave() {
            const canvas = document.getElementById('sliderWaveCanvas');
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
                              Math.cos((x * 0.015) + (time * 0.015)) * 20;
                    ctx.lineTo(x, y);
                }
                
                ctx.lineTo(width, height);
                ctx.lineTo(0, height);
                ctx.lineTo(0, 0);
                ctx.closePath();
                ctx.fillStyle = '#f5f5f5';
                ctx.fill();

                // موجة ثانية (أخف) - موجهة لأسفل
                ctx.beginPath();
                ctx.moveTo(0, 0);
                
                for (let x = 0; x <= width; x += 1) {
                    const y = 40 + Math.sin((x * 0.012) + (time * 0.025)) * 25 + 
                              Math.cos((x * 0.018) + (time * 0.02)) * 15;
                    ctx.lineTo(x, y);
                }
                
                ctx.lineTo(width, height);
                ctx.lineTo(0, height);
                ctx.lineTo(0, 0);
                ctx.closePath();
                ctx.fillStyle = 'rgba(245, 245, 245, 0.7)';
                ctx.fill();

                time += 0.5;
                requestAnimationFrame(animate);
            }

            animate();

            // إعادة الرسم عند تغيير حجم النافذة
            window.addEventListener('resize', () => {
                canvas.width = canvas.offsetWidth;
            });
        }

        // بدء رسم موجة السليدر عند تحميل الصفحة
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', drawSliderWave);
        } else {
            drawSliderWave();
        }

        // تفعيل زر التشغيل في الفيديو
        const videoPlayButton = document.querySelector('.video-play-button');
        const videoPlayer = document.querySelector('.video-player');
        
        if (videoPlayButton && videoPlayer) {
            videoPlayButton.addEventListener('click', function() {
                if (videoPlayer.paused) {
                    videoPlayer.play();
                    videoPlayButton.style.display = 'none';
                } else {
                    videoPlayer.pause();
                    videoPlayButton.style.display = 'flex';
                }
            });

            videoPlayer.addEventListener('play', function() {
                videoPlayButton.style.display = 'none';
            });

            videoPlayer.addEventListener('pause', function() {
                videoPlayButton.style.display = 'flex';
            });
        }
    </script>

    <!-- قسم About Us -->
    <section class="about-section">
        <div class="about-container">
            <h2 class="about-heading">
                We believe that success begins with the details
            </h2>
            <div class="about-content">
                <p class="about-paragraph">
                That’s why we carefully select premium raw materials, apply strict quality control systems, and continuously invest in advanced production technologies.
                </p>
                <p class="about-paragraph">
                With a skilled and passionate team, our company has earned a strong reputation in the market and gained the trust of customers by providing products that combine quality, refined taste, and reliability.                </p>
                <p class="about-paragraph">
                Today, we continue our journey of regional expansion and market growth while staying true to our core values that guide us in delivering excellence and creating moments of joy.                </p>
            </div>
        </div>
    </section>

    <!-- قسم المنتجات -->
    <div class="products-section-wrapper">
        <canvas id="productsWaveCanvas" class="products-section-wave-canvas"></canvas>
        <section class="products-section">
        <div class="products-container">
            <!-- البطاقات على اليسار -->
            <div class="products-cards-wrapper">
                <div class="products-cards-container">
                    <div class="products-cards" id="productsCards">
                        @forelse($products->chunk(3) as $chunk)
                            <div class="products-cards-slide">
                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                                    @foreach($chunk as $product)
                                        <a href="{{ route('product.show', $product) }}" class="product-card-link">
                                            <div class="product-card">
                                                <div class="product-card-image">
                                                    @if($product->images->first())
                                                        <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->name }}">
                                                    @else
                                                        <svg width="60" height="60" fill="#999" viewBox="0 0 24 24">
                                                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="product-card-body">
                                                    <h3 class="product-card-title">{{ $product->name }}</h3>
                                                    @if($product->category)
                                                        <p class="product-card-subtitle">{{ strtoupper($product->category->name_en ?? $product->category->name) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="products-cards-slide">
                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                                    <div class="product-card">
                                        <div class="product-card-image">
                                            <svg width="60" height="60" fill="#999" viewBox="0 0 24 24">
                                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div class="product-card-body">
                                            <h3 class="product-card-title">Davinci Coated Almonds</h3>
                                            <p class="product-card-subtitle">DRAGEE</p>
                                        </div>
                                    </div>
                                    <div class="product-card">
                                        <div class="product-card-image">
                                            <svg width="60" height="60" fill="#999" viewBox="0 0 24 24">
                                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div class="product-card-body">
                                            <h3 class="product-card-title">Choco Besto Crisp</h3>
                                            <p class="product-card-subtitle" style="margin-top: 5px;">Carnaval</p>
                                            <p class="product-card-subtitle">DRAGEE</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="products-carousel-dots" id="productsCarouselDots">
                    <!-- سيتم إنشاؤها ديناميكياً -->
                </div>
            </div>
            <!-- النص على اليمين -->
            <div class="products-text-content">
                <h2 class="products-heading">200+ Many distinctive products with the best quality and great taste</h2>
                <p class="products-description">
                Crafting Joy, One Moment at a Time

Experience a world where quality, craftsmanship, and creativity come together.
We are committed to delivering products made with passion, refined through innovation, and trusted for their consistency.
Discover excellence in every detail.
</p>
                <a href="{{ $siteSettings->view_products_link ?? '#' }}" class="products-view-btn">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 5px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    View Products
                </a>
            </div>
        </div>
    </section>
    </div>

    <!-- قسم التصدير -->
    <section class="export-section">
        <div class="export-container">
            <!-- القسم الأيسر: الصورة فقط -->
            <div class="export-product-side">
                <img src="{{ asset('storage/sliders/banner1.png') }}" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <!-- القسم الأيمن: النص الوصفي -->
            <div class="export-text-side">
                <div class="export-watermark export-watermark-airplane">
                    <svg viewBox="0 0 100 100" fill="none" opacity="0.1">
                        <path d="M50 10 L70 30 L60 40 L50 35 L40 40 L30 30 Z M20 50 L30 60 L40 55 L50 60 L60 55 L70 60 L80 50 L70 40 L60 45 L50 40 L40 45 L30 40 Z" fill="currentColor"/>
                    </svg>
                </div>
                <div class="export-watermark export-watermark-globe">
                    <svg viewBox="0 0 100 100" fill="none" opacity="0.1">
                        <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="2"/>
                        <path d="M10 50 Q30 30 50 30 Q70 30 90 50" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path d="M10 50 Q30 70 50 70 Q70 70 90 50" stroke="currentColor" stroke-width="2" fill="none"/>
                        <line x1="50" y1="10" x2="50" y2="90" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <div class="export-text-content">
                    <p class="export-text-orange">
                    Food Safety Policy
                    </p>
                    <p class="export-text-grey">

                    We ensure safe and healthy products through:
<br>
Adopting international safety standards.

Closely monitoring daily operations and adhering to hygiene procedures.
<br>
Effectively managing the supply chain to ensure safety from source to customer.
<br>
Continuously training staff on the latest safety practices.
<br>
Periodically reviewing systems and policies to ensure compliance and continuous improvement.                    </p>

                </div>
            </div>
        </div>
    </section>

    <!-- قسم الفيديو (معكوس) -->
    <section class="video-section">
        <div class="video-container">
            <!-- القسم الأيسر: النص الوصفي -->
            <div class="video-text-side">
                <div class="video-watermark video-watermark-airplane">
                    <svg viewBox="0 0 100 100" fill="none" opacity="0.1">
                        <path d="M50 10 L70 30 L60 40 L50 35 L40 40 L30 30 Z M20 50 L30 60 L40 55 L50 60 L60 55 L70 60 L80 50 L70 40 L60 45 L50 40 L40 45 L30 40 Z" fill="currentColor"/>
                    </svg>
                </div>
                <div class="video-watermark video-watermark-globe">
                    <svg viewBox="0 0 100 100" fill="none" opacity="0.1">
                        <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="2"/>
                        <path d="M10 50 Q30 30 50 30 Q70 30 90 50" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path d="M10 50 Q30 70 50 70 Q70 70 90 50" stroke="currentColor" stroke-width="2" fill="none"/>
                        <line x1="50" y1="10" x2="50" y2="90" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <div class="video-text-content">
                    <p class="video-text-orange">
Our Objectives
                    </p>
                    <p class="video-text-grey">
                    1. Achieve high performance levels that ensure consistent and sustainable quality.
<br>

2. Develop an innovative and motivating work environment for employees.
<br>

3. Expand the company’s presence in local and regional markets.
<br>

4. Enhance operational efficiency and invest in modern technologies.
<br>

5. Build long-term trust-based relationships with clients and partners.
<br>

6. Improve customer experience through continuous development and effective engagement.
<br>

7. Implement the highest safety standards and comply with local and international regulations.                    </p>

                </div>
            </div>
            <!-- القسم الأيمن: الصورة فقط -->
            <div class="video-display-side">
                <img src="{{ asset('storage/sliders/banner2.png') }}" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- قسم دعوة للعمل -->
    <section class="cta-section">
        <div class="cta-background">
            <img src="{{ asset('storage/sliders/back.png') }}" alt="Background" class="cta-bg-image">
            <div class="cta-overlay"></div>
        </div>
        <div class="cta-content">
            <div class="cta-text-wrapper">
                <h2 class="cta-main-text">Let's start working together now</h2>
                <p class="cta-sub-text">For more information about the products offered by the company, do not hesitate to contact us.</p>
            </div>
            <div class="cta-button-wrapper">
                <a href="#" class="cta-button">
                    Get A Quote
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

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
                <a href="https://www.facebook.com/share/18ALRh5g9A/?mibextid=wwXIfr" class="footer-social-icon footer-social-facebook" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.477 2 2 6.477 2 12c0 5.013 3.693 9.153 8.505 9.876v-6.988H8.031v-2.888h2.474v-2.2c0-2.444 1.456-3.794 3.683-3.794 1.067 0 2.183.191 2.183.191v2.4h-1.23c-1.211 0-1.588.751-1.588 1.523v1.83h2.691l-.43 2.888h-2.261v6.988C18.307 21.153 22 17.013 22 12c0-5.523-4.477-10-10-10z"/>
                    </svg>
                </a>
                <a href="https://www.instagram.com/lotussweetsegypt?igsh=MWUwaHAwbzJtcXI0Yw==" class="footer-social-icon footer-social-instagram" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
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
