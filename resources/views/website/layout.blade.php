<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'کاخ‌سازان داروگ - داستان ساخت و ساز')</title>
    <meta name="description" content="@yield('description', 'کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی')">
    <meta name="keywords" content="پیمانکاری, ساخت و ساز, داروگ, سلر سازی, محوطه سازی, جاده سازی, پیمانکار, پروژه عمرانی">
    <meta name="author" content="کاخ‌سازان داروگ">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'کاخ‌سازان داروگ - داستان ساخت و ساز')">
    <meta property="og:description" content="@yield('description', 'کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی')">
    <meta property="og:image" content="{{ asset('assets/images/files/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="کاخ‌سازان داروگ">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'کاخ‌سازان داروگ - داستان ساخت و ساز')">
    <meta name="twitter:description" content="@yield('description', 'کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی')">
    <meta name="twitter:image" content="{{ asset('assets/images/files/logo.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/files/logo.png') }}">

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.rtl.min.css') }}">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Modern Navbar CSS -->
    <style>
        /* Modern Navbar CSS */
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap');

        /* Variables */
        :root {
            --dnav-primary-color: #0077ff;
            --dnav-primary-dark: #0055cc;
            --dnav-primary-light: rgba(0, 119, 255, 0.12);
            --dnav-accent-color: #0077ff;
            --dnav-accent-dark: #0055cc;
            --dnav-accent-light: rgba(0, 119, 255, 0.08);
            --dnav-text-dark: #2c2c2c;
            --dnav-text-light: #666666;
            --dnav-bg-light: #f8f9fa;
            --dnav-bg-gradient: linear-gradient(135deg, rgba(0, 119, 255, 0.05), rgba(0, 119, 255, 0.02));
            --dnav-transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Main Navbar Styles */
        .dnav-container {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.95));
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: 0 4px 32px rgba(0, 119, 255, 0.08), 0 2px 16px rgba(0, 0, 0, 0.06);
            z-index: 1000;
            transition: var(--dnav-transition);
            font-family: 'Vazirmatn', system-ui, -apple-system, sans-serif;
            direction: rtl;
            border-bottom: 1px solid rgba(0, 119, 255, 0.1);
        }

        .dnav-top-line {
            height: 3px;
            background: linear-gradient(90deg, var(--dnav-primary-color), #00a0ff);
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 119, 255, 0.2);
        }

        .dnav-top-line::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: dnav-shine 4s infinite;
        }

        @keyframes dnav-shine {
            to {
                left: 100%;
            }
        }

        .dnav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            height: 76px;
        }

        /* Logo */
        .dnav-logo {
            position: relative;
            transition: var(--dnav-transition);
            display: flex;
            align-items: center;
        }

        .dnav-logo::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(to left, var(--dnav-primary-color), var(--dnav-accent-color));
            transition: var(--dnav-transition);
            opacity: 0;
        }

        .dnav-logo:hover::after {
            width: 100%;
            opacity: 1;
        }

        .dnav-logo img {
            height: 42px;
            display: block;
            transition: var(--dnav-transition);
        }

        .dnav-logo:hover img {
            transform: translateY(-2px);
        }

        /* Navigation Links */
        .dnav-links {
            display: flex;
            list-style: none;
            gap: 8px;
            margin: 0;
            padding: 0;
        }

        .dnav-links li a {
            display: flex;
            align-items: center;
            color: var(--dnav-text-dark);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 500;
            transition: var(--dnav-transition);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .dnav-links li a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, var(--dnav-primary-light), transparent);
            transform: translateX(-100%);
            transition: var(--dnav-transition);
            z-index: -1;
        }

        .dnav-links li a:hover::before {
            transform: translateX(0);
        }

        .dnav-links li a img {
            margin-left: 8px;
            width: 18px;
            height: 18px;
            opacity: 0.7;
            transition: var(--dnav-transition);
        }

        .dnav-links li a:hover {
            color: var(--dnav-primary-color);
            transform: translateY(-2px);
        }

        .dnav-links li a:hover img {
            opacity: 1;
            transform: scale(1.1);
        }

        .dnav-links li a.active {
            background: var(--dnav-primary-light);
            color: var(--dnav-primary-color);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 119, 255, 0.15);
            border: 1px solid rgba(0, 119, 255, 0.2);
        }

        .dnav-links li a.active img {
            opacity: 1;
        }

        .dnav-special {
            color: #ff6b00 !important;
            position: relative;
        }

        .dnav-special::before {
            background: linear-gradient(120deg, transparent, rgba(255, 107, 0, 0.1), transparent) !important;
        }

        .dnav-special:hover {
            color: #ff6b00 !important;
        }

        .dnav-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: linear-gradient(135deg, #ff6b00, #e05a00);
            color: white;
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 3px 8px rgba(255, 107, 0, 0.3);
            animation: dnav-pulse 2s infinite;
        }

        @keyframes dnav-pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Phone Button */
        .dnav-phone-button {
            display: flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--dnav-primary-color), #00a0ff, var(--dnav-primary-dark));
            color: white;
            padding: 10px 22px 10px 10px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-right: 20px;
            transition: var(--dnav-transition);
            box-shadow: 0 6px 20px rgba(0, 119, 255, 0.25), 0 2px 8px rgba(0, 119, 255, 0.15);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dnav-phone-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: var(--dnav-transition);
        }

        .dnav-phone-button:hover::before {
            left: 100%;
            transition: 0.5s;
        }

        .dnav-phone-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.15));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--dnav-transition);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .dnav-phone-button:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 25px rgba(0, 119, 255, 0.35), 0 4px 12px rgba(0, 119, 255, 0.25);
        }

        .dnav-phone-button:hover .dnav-phone-icon {
            transform: rotate(15deg);
        }

        /* Mobile Menu Button */
        .dnav-menu-button {
            display: none;
            width: 46px;
            height: 46px;
            background: linear-gradient(135deg, var(--dnav-bg-light), rgba(0, 119, 255, 0.05));
            border-radius: 14px;
            border: 1px solid rgba(0, 119, 255, 0.1);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 5px;
            transition: var(--dnav-transition);
            box-shadow: 0 4px 15px rgba(0, 119, 255, 0.08), 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .dnav-menu-button:hover {
            background: linear-gradient(135deg, var(--dnav-primary-light), rgba(0, 119, 255, 0.1));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 119, 255, 0.15), 0 3px 10px rgba(0, 119, 255, 0.08);
        }

        .dnav-menu-button span {
            display: block;
            width: 22px;
            height: 3px;
            background: linear-gradient(90deg, var(--dnav-primary-color), #00a0ff);
            transition: var(--dnav-transition);
            border-radius: 2px;
        }

        .dnav-menu-button.active {
            background: linear-gradient(135deg, var(--dnav-primary-light), rgba(0, 119, 255, 0.15));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 119, 255, 0.2), 0 3px 10px rgba(0, 119, 255, 0.12);
        }

        .dnav-menu-button.active span {
            background: linear-gradient(90deg, var(--dnav-primary-color), #00a0ff);
        }

        .dnav-menu-button.active span:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        .dnav-menu-button.active span:nth-child(2) {
            opacity: 0;
            transform: translateX(-10px);
        }

        .dnav-menu-button.active span:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        /* Mobile Menu */
        .dnav-mobile-menu {
            position: fixed;
            top: 80px;
            right: 20px;
            left: 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.95));
            padding: 25px;
            box-shadow: 0 20px 50px rgba(0, 119, 255, 0.12), 0 10px 30px rgba(0, 0, 0, 0.08);
            transform: translateY(-10px);
            opacity: 0;
            visibility: hidden;
            transition: var(--dnav-transition);
            z-index: 999;
            border-radius: 20px;
            max-height: calc(100vh - 100px);
            overflow-y: auto;
            font-family: 'Vazirmatn', system-ui, -apple-system, sans-serif;
            direction: rtl;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 119, 255, 0.1);
        }

        .dnav-mobile-menu.active {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .dnav-mobile-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dnav-mobile-links li {
            margin-bottom: 10px;
        }

        .dnav-mobile-links li a {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            color: var(--dnav-text-dark);
            text-decoration: none;
            border-radius: 12px;
            font-size: 16px;
            transition: var(--dnav-transition);
            font-weight: 500;
        }

        .dnav-mobile-links li a img {
            margin-left: 12px;
            width: 22px;
            height: 22px;
            transition: var(--dnav-transition);
        }

        .dnav-mobile-links li a.active {
            background: var(--dnav-primary-light);
            color: var(--dnav-primary-color);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 119, 255, 0.15);
            border: 1px solid rgba(0, 119, 255, 0.2);
        }

        .dnav-mobile-links li a:hover {
            background-color: var(--dnav-bg-light);
            transform: translateX(-5px);
        }

        .dnav-mobile-links li a:hover img {
            transform: scale(1.1);
        }

        .dnav-mobile-special {
            color: #ff6b00 !important;
        }

        .dnav-mobile-badge {
            background-color: #ff6b00;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 8px;
            margin-right: 5px;
        }

        .dnav-mobile-phone {
            margin-top: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: linear-gradient(135deg, var(--dnav-primary-color), #00a0ff, var(--dnav-primary-dark));
            color: white;
            padding: 18px 20px;
            border-radius: 16px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: var(--dnav-transition);
            box-shadow: 0 6px 20px rgba(0, 119, 255, 0.25), 0 2px 8px rgba(0, 119, 255, 0.15);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dnav-mobile-phone::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .dnav-mobile-phone:hover::before {
            left: 100%;
        }

        .dnav-mobile-phone:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 25px rgba(0, 119, 255, 0.35), 0 4px 12px rgba(0, 119, 255, 0.25);
        }

        /* Scroll Effect */
        .dnav-container.scrolled {
            height: 70px;
            box-shadow: 0 8px 35px rgba(0, 119, 255, 0.12), 0 4px 20px rgba(0, 0, 0, 0.08);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.98));
        }

        .dnav-container.scrolled .dnav-content {
            height: 66px;
        }

        .dnav-container.scrolled .dnav-logo img {
            height: 38px;
        }

        /* Responsive Styles */
        @media (max-width: 1050px) {
            .dnav-links li a {
                padding: 8px 12px;
                font-size: 14px;
            }

            .dnav-phone-button {
                padding: 6px 15px 6px 6px;
                margin-right: 10px;
                font-size: 13px;
            }

            .dnav-phone-icon {
                width: 32px;
                height: 32px;
            }
        }

        @media (max-width: 900px) {
            .dnav-links li a img {
                margin-left: 5px;
            }

            .dnav-phone-text {
                display: none;
            }

            .dnav-phone-button {
                padding: 8px;
                border-radius: 50%;
                margin-right: 8px;
            }
        }

        @media (max-width: 850px) {
            .dnav-links,
            .dnav-phone-button {
                display: none;
            }

            .dnav-menu-button {
                display: flex;
            }

            .dnav-container.scrolled {
                height: auto;
            }
        }

        @media (max-width: 480px) {
            .dnav-content {
                padding: 0 15px;
            }

            .dnav-mobile-menu {
                right: 10px;
                left: 10px;
                padding: 15px;
            }
        }
    </style>

    <!-- Footer CSS -->
    <style>
        .mf-container {
            background-color: #f0f2f5;
            padding-top: 30px;
            position: relative;
            overflow: hidden;
        }

        .mf-gradient-line {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #ff6b00, #0077ff, #ff6b00);
        }

        .mf-decorative-circle {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            opacity: 0.1;
        }

        .mf-orange-glow {
            background: radial-gradient(circle, #ff6b00, transparent);
            top: 20px;
            right: 10%;
        }

        .mf-blue-glow {
            background: radial-gradient(circle, #0077ff, transparent);
            bottom: 20px;
            left: 10%;
        }

        .mf-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .mf-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }

        .mf-about {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .mf-logo img {
            max-width: 150px;
            height: auto;
        }

        .mf-heading {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .mf-orange-accent {
            color: #ff6b00;
        }

        .mf-blue-accent {
            color: #0077ff;
        }

        .mf-underline {
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #ff6b00, #0077ff);
        }

        .mf-description {
            color: #666;
            line-height: 1.6;
            text-align: justify;
        }

        .mf-social-links {
            display: flex;
            gap: 10px;
        }

        .mf-social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff6b00, #ff8c00);
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        .mf-social-btn:hover {
            transform: translateY(-2px);
        }

        .mf-links-list, .mf-contact-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mf-link-item, .mf-contact-item {
            margin-bottom: 10px;
        }

        .mf-link, .mf-contact-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .mf-link:hover, .mf-contact-link:hover {
            color: #ff6b00;
        }

        .mf-link-dot {
            width: 6px;
            height: 6px;
            background: #ff6b00;
            border-radius: 50%;
        }

        .mf-contact-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #0077ff, #00a0ff);
            border-radius: 50%;
        }

        .mf-contact-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: #666;
        }

        .mf-qr-container {
            text-align: center;
        }

        .mf-qr-text {
            color: #666;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .mf-qr-code img {
            max-width: 120px;
            height: auto;
        }

        .mf-copyright {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-top: 1px solid #ddd;
            margin-top: 20px;
        }

        .mf-copyright-text {
            color: #666;
            margin: 0;
        }

        .mf-legal-links {
            display: flex;
            gap: 20px;
        }

        .mf-legal-link {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .mf-legal-link:hover {
            color: #ff6b00;
        }

        @media (max-width: 768px) {
            .mf-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .mf-copyright {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .mf-legal-links {
                justify-content: center;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Modern Navbar HTML Structure -->
    <nav class="dnav-container">
        <div class="dnav-top-line"></div>
        <div class="dnav-content">
            <a href="{{ route('home') }}" class="dnav-logo">
                <img src="https://darvag-1.s3.ir-thr-at1.arvanstorage.ir/settings/logo_67b7a8bcf09cf_594984.png" alt="داروگ">
            </a>

            <!-- Desktop Menu -->
            <ul class="dnav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <img src="https://api.iconify.design/solar:home-bold-duotone.svg?color=%230077ff" alt="خانه">
                    خانه
                </a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
                    <img src="https://api.iconify.design/solar:info-circle-bold-duotone.svg" alt="درباره ما">
                    درباره ما
                </a></li>
                <li><a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">
                    <img src="https://api.iconify.design/solar:widget-bold-duotone.svg" alt="خدمات">
                    خدمات
                </a></li>
                <li><a href="{{ route('projects') }}" class="{{ request()->routeIs('projects') ? 'active' : '' }}">
                    <img src="https://api.iconify.design/solar:case-minimalistic-bold-duotone.svg" alt="پروژه‌ها">
                    پروژه‌های ما
                </a></li>
                <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') ? 'active' : '' }}">
                    <img src="https://api.iconify.design/solar:document-bold-duotone.svg" alt="وبلاگ">
                    وبلاگ
                </a></li>
                <li><a href="{{ route('charity') }}" class="dnav-special {{ request()->routeIs('charity') ? 'active' : '' }}">
                    <img src="https://api.iconify.design/solar:heart-bold-duotone.svg?color=%23ff6b00" alt="پویش نیکی">
                    پویش نیکی
                    <span class="dnav-badge">جدید</span>
                </a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                    <img src="https://api.iconify.design/solar:chat-round-dots-bold-duotone.svg" alt="تماس با ما">
                    تماس با ما
                </a></li>
            </ul>

            <!-- Phone Button -->
            <a href="tel:09350801600" class="dnav-phone-button">
                <div class="dnav-phone-icon">
                    <img src="https://api.iconify.design/solar:phone-calling-rounded-bold.svg?color=white" width="18" height="18" alt="تلفن">
                </div>
                <span class="dnav-phone-text">۰۹۳۵۰۸۰۱۶۰۰</span>
            </a>

            <!-- Mobile Menu Button -->
            <button class="dnav-menu-button" id="dnav-toggle-button">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu (Outside the navbar) -->
    <div class="dnav-mobile-menu">
        <ul class="dnav-mobile-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <img src="https://api.iconify.design/solar:home-bold-duotone.svg?color=%230077ff" alt="خانه">
                خانه
            </a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
                <img src="https://api.iconify.design/solar:info-circle-bold-duotone.svg" alt="درباره ما">
                درباره ما
            </a></li>
            <li><a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">
                <img src="https://api.iconify.design/solar:widget-bold-duotone.svg" alt="خدمات">
                خدمات
            </a></li>
            <li><a href="{{ route('projects') }}" class="{{ request()->routeIs('projects') ? 'active' : '' }}">
                <img src="https://api.iconify.design/solar:case-minimalistic-bold-duotone.svg" alt="پروژه‌ها">
                پروژه‌های ما
            </a></li>
            <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') ? 'active' : '' }}">
                <img src="https://api.iconify.design/solar:document-bold-duotone.svg" alt="وبلاگ">
                وبلاگ
            </a></li>
            <li><a href="{{ route('charity') }}" class="dnav-mobile-special {{ request()->routeIs('charity') ? 'active' : '' }}">
                <img src="https://api.iconify.design/solar:heart-bold-duotone.svg?color=%23ff6b00" alt="پویش نیکی">
                پویش نیکی <span class="dnav-mobile-badge">جدید</span>
            </a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                <img src="https://api.iconify.design/solar:chat-round-dots-bold-duotone.svg" alt="تماس با ما">
                تماس با ما
            </a></li>
        </ul>

        <a href="tel:09350801600" class="dnav-mobile-phone animate__animated animate__fadeInUp">
            <img src="https://api.iconify.design/solar:phone-calling-rounded-bold.svg?color=white" width="20" height="20" alt="تلفن">
            تماس: ۰۹۳۵۰۸۰۱۶۰۰
        </a>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mf-container" style="background-color: #f0f2f5; padding-top: 30px;">
        <!-- دکوراتیو المنت‌ها -->
        <div class="mf-gradient-line"></div>
        <div class="mf-decorative-circle mf-orange-glow" style="transform: translate(117.14px, 58.57px);"></div>
        <div class="mf-decorative-circle mf-blue-glow" style="transform: translate(-117.14px, -58.57px);"></div>

        <div class="mf-content">
            <div class="mf-grid">
                <!-- درباره شرکت -->
                <div class="mf-about">
                    <div class="mf-logo">
                        <img src="https://darvag-1.s3.ir-thr-at1.arvanstorage.ir/settings/logo_67b7a8bcf09cf_594984.png" alt="داروگ">
                    </div>

                    <h3 class="mf-heading mf-orange-accent">
                        گروه صنعتی داروگ
                        <span class="mf-underline"></span>
                    </h3>

                    <p class="mf-description">
                        کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی، با بهره‌گیری از تجهیزات پیشرفته و تیم متخصص، پروژه‌های بزرگ و پیچیده را با کیفیت و سرعت بالا اجرا می‌کند.
                    </p>

                    <!-- دکمه‌های شبکه‌های اجتماعی -->
                    <div class="mf-social-links">
                        <a href="#" class="mf-social-btn">
                            <img src="https://api.iconify.design/mdi:instagram.svg?color=white" width="20" height="20" alt="اینستاگرام">
                        </a>
                        <a href="#" class="mf-social-btn">
                            <img src="https://api.iconify.design/mdi:linkedin.svg?color=white" width="20" height="20" alt="لینکدین">
                        </a>
                        <a href="#" class="mf-social-btn">
                            <img src="https://api.iconify.design/mdi:telegram.svg?color=white" width="20" height="20" alt="تلگرام">
                        </a>
                    </div>
                </div>

                <!-- لینک‌های سریع -->
                <div class="mf-quick-links">
                    <h3 class="mf-heading mf-blue-accent">
                        لینک‌های سریع
                        <span class="mf-underline"></span>
                    </h3>

                    <ul class="mf-links-list">
                        <li class="mf-link-item">
                            <a href="{{ route('about') }}" class="mf-link">
                                <span class="mf-link-dot"></span>
                                درباره ما
                            </a>
                        </li>
                        <li class="mf-link-item">
                            <a href="{{ route('services') }}" class="mf-link">
                                <span class="mf-link-dot"></span>
                                خدمات
                            </a>
                        </li>
                        <li class="mf-link-item">
                            <a href="{{ route('projects') }}" class="mf-link">
                                <span class="mf-link-dot"></span>
                                پروژه‌ها
                            </a>
                        </li>
                        <li class="mf-link-item">
                            <a href="{{ route('contact') }}" class="mf-link">
                                <span class="mf-link-dot"></span>
                                تماس با ما
                            </a>
                        </li>
                        <li class="mf-link-item">
                            <a href="https://sajar.mporg.ir/" class="mf-link">
                                <span class="mf-link-dot"></span>
                                رتبه بندی شرکت ها
                            </a>
                        </li>
                        <li class="mf-link-item">
                            <a href="http://cdb.mporg.ir/" class="mf-link">
                                <span class="mf-link-dot"></span>
                                سامانه جامع قرارداد ها
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- اطلاعات تماس -->
                <div class="mf-contact-info">
                    <h3 class="mf-heading mf-orange-accent">
                        اطلاعات تماس
                        <span class="mf-underline"></span>
                    </h3>

                    <ul class="mf-contact-list">
                        <li class="mf-contact-item">
                            <a href="tel:09350801600" class="mf-contact-link">
                                <div class="mf-contact-icon">
                                    <img src="https://api.iconify.design/solar:phone-bold.svg?color=white" width="18" height="18" alt="تلفن">
                                </div>
                                <span>09350801600</span>
                            </a>
                        </li>
                        <li class="mf-contact-item">
                            <a href="mailto:info@darvagco.ir" class="mf-contact-link">
                                <div class="mf-contact-icon">
                                    <img src="https://api.iconify.design/solar:letter-bold.svg?color=white" width="18" height="18" alt="ایمیل">
                                </div>
                                <span>info@darvagco.ir</span>
                            </a>
                        </li>
                        <li class="mf-contact-item">
                            <div class="mf-contact-wrapper">
                                <div class="mf-contact-icon">
                                    <img src="https://api.iconify.design/solar:map-point-bold.svg?color=white" width="18" height="18" alt="آدرس">
                                </div>
                                <span>خراسان رضوی - شهرستان سرخس - دهستان خانگیران - امام رضا (ع) 14 پلاک 102</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- کد QR -->
                <div class="mf-qr-section">
                    <h3 class="mf-heading mf-blue-accent">
                        دسترسی سریع
                        <span class="mf-underline"></span>
                    </h3>

                    <div class="mf-qr-container">
                        <p class="mf-qr-text">
                            اسکن کنید و به وب‌سایت ما دسترسی داشته باشید
                        </p>
                        <div class="mf-qr-code">
                            <img src="https://darvag-1.s3.ir-thr-at1.arvanstorage.ir/settings/qr_code_67b8447c7a1bc_341419.png" alt="کد QR">
                        </div>
                    </div>
                </div>
            </div>

            <!-- بخش کپی‌رایت -->
            <div class="mf-copyright">
                <p class="mf-copyright-text">
                    © ۱۴۰۴ تمامی حقوق برای شرکت کاخ‌سازان داروگ محفوظ است.
                </p>
                <div class="mf-legal-links">
                    <a href="https://darvagco.ir/privacy-policy" class="mf-legal-link">حریم خصوصی</a>
                    <a href="https://darvagco.ir/terms-of-use" class="mf-legal-link">شرایط استفاده</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/lordicon.js') }}"></script>

    <!-- Modern Navbar JavaScript -->
    <script>
        /**
         * Darvag Modern Navbar JavaScript
         * Controls navbar functionality and animations
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const navbarContainer = document.querySelector('.dnav-container');
            const menuButton = document.getElementById('dnav-toggle-button');
            const mobileMenu = document.querySelector('.dnav-mobile-menu');
            const desktopLinks = document.querySelectorAll('.dnav-links a');
            const mobileLinks = document.querySelectorAll('.dnav-mobile-links a');

            // Toggle Mobile Menu
            function toggleMenu() {
                menuButton.classList.toggle('active');
                mobileMenu.classList.toggle('active');
            }

            // Setup menu button click handler
            if (menuButton) {
                menuButton.addEventListener('click', toggleMenu);
            }

            // Active Link Based on Current URL
            function setActiveLinks() {
                const currentLocation = window.location.href;

                function setActive(links) {
                    links.forEach(link => {
                        if (link.href === currentLocation) {
                            link.classList.add('active');
                        } else if (link.classList.contains('active') && link.href !== currentLocation) {
                            link.classList.remove('active');
                        }
                    });
                }

                setActive(desktopLinks);
                setActive(mobileLinks);
            }

            // Run once on page load
            setActiveLinks();

            // Scroll Effect
            function handleScroll() {
                if (window.scrollY > 50) {
                    navbarContainer.classList.add('scrolled');
                } else {
                    navbarContainer.classList.remove('scrolled');
                }
            }

            // Add scroll event listener
            window.addEventListener('scroll', handleScroll);

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (mobileMenu &&
                    mobileMenu.classList.contains('active') &&
                    !mobileMenu.contains(event.target) &&
                    !menuButton.contains(event.target)) {
                    mobileMenu.classList.remove('active');
                    menuButton.classList.remove('active');
                }
            });

            // Optional: Close mobile menu when clicking on a mobile link
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.remove('active');
                    menuButton.classList.remove('active');
                });
            });

            // Optional: Add smooth scrolling for hash links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(event) {
                    const targetId = this.getAttribute('href');
                    if (targetId !== '#') {
                        event.preventDefault();

                        const targetElement = document.querySelector(targetId);
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });

                            // Optional: Close mobile menu after clicking
                            if (mobileMenu && mobileMenu.classList.contains('active')) {
                                mobileMenu.classList.remove('active');
                                menuButton.classList.remove('active');
                            }
                        }
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
