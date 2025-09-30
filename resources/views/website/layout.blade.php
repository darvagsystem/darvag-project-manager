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

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'کاخ‌سازان داروگ - داستان ساخت و ساز')">
    <meta property="og:description" content="@yield('description', 'کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی')">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="کاخ‌سازان داروگ">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'کاخ‌سازان داروگ - داستان ساخت و ساز')">
    <meta name="twitter:description" content="@yield('description', 'کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی')">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --accent-color: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: #fff;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 0.75rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header.scrolled {
            background: rgba(30, 58, 138, 0.95);
            backdrop-filter: blur(10px);
            padding: 0.5rem 0;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        /* Body padding for fixed header */
        body {
            padding-top: 80px;
        }

        .logo {
            font-size: 2rem;
            font-weight: 800;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo i {
            font-size: 2.5rem;
            color: var(--accent-color);
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
            margin: 0;
            padding: 0;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 0;
        }

        .nav-menu a:hover {
            color: var(--accent-color);
            transform: translateY(-2px);
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        .contact-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .contact-info a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .contact-info a:hover {
            color: var(--accent-color);
            transform: scale(1.05);
        }

        .badge-new {
            background: #ef4444;
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            margin-right: 0.5rem;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--primary-color);
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu.active {
            display: block;
        }

        .mobile-menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .mobile-menu a:last-child {
            border-bottom: none;
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
        }

        /* Footer Styles */
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer h5 {
            color: var(--accent-color);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .footer a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--accent-color);
        }

        .footer-bottom {
            border-top: 1px solid #374151;
            margin-top: 2rem;
            padding-top: 1rem;
            text-align: center;
            color: #9ca3af;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .contact-info {
                display: none;
            }

            .logo {
                font-size: 1.5rem;
            }

            .logo i {
                font-size: 2rem;
            }
        }

        /* Utility Classes */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
            color: white;
        }

        .btn-outline {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .section-padding {
            padding: 4rem 0;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-in-left {
            animation: slideInLeft 0.6s ease-out;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Additional Utility Classes */
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .box-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .box-shadow-lg {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .border-radius {
            border-radius: 0.5rem;
        }

        .border-radius-lg {
            border-radius: 1rem;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .bg-gradient-secondary {
            background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }

        /* Print Styles */
        @media print {
            .header, .footer, .btn, .mobile-menu {
                display: none !important;
            }

            body {
                padding-top: 0 !important;
            }

            .main-content {
                min-height: auto !important;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content d-flex justify-content-between align-items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo">
                    <i class="fas fa-building"></i>
                    <span>کاخ‌سازان داروگ</span>
                </a>

                <!-- Desktop Navigation -->
                <nav class="d-none d-lg-block">
                    <ul class="nav-menu">
                        <li><a href="{{ route('home') }}">خانه</a></li>
                        <li><a href="{{ route('about') }}">درباره ما</a></li>
                        <li><a href="{{ route('services') }}">خدمات</a></li>
                        <li><a href="{{ route('projects') }}">پروژه‌ها</a></li>
                        <li><a href="{{ route('blog') }}">وبلاگ</a></li>
                        <li><a href="{{ route('charity') }}">پویش نیکی <span class="badge-new">جدید</span></a></li>
                        <li><a href="{{ route('contact') }}">تماس با ما</a></li>
                    </ul>
                </nav>

                <!-- Contact Info -->
                <div class="contact-info d-none d-lg-flex">
                    <a href="tel:09350801600">
                        <i class="fas fa-phone"></i>
                        <span>09350801600</span>
                    </a>
                    <a href="mailto:info@darvagco.ir">
                        <i class="fas fa-envelope"></i>
                        <span>info@darvagco.ir</span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="mobile-menu-btn d-lg-none" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu d-lg-none" id="mobileMenu">
                <a href="{{ route('home') }}">خانه</a>
                <a href="{{ route('about') }}">درباره ما</a>
                <a href="{{ route('services') }}">خدمات</a>
                <a href="{{ route('projects') }}">پروژه‌ها</a>
                <a href="{{ route('blog') }}">وبلاگ</a>
                <a href="{{ route('charity') }}">پویش نیکی <span class="badge-new">جدید</span></a>
                <a href="{{ route('contact') }}">تماس با ما</a>
                <a href="tel:09350801600">
                    <i class="fas fa-phone"></i>
                    09350801600
                </a>
                <a href="mailto:info@darvagco.ir">
                    <i class="fas fa-envelope"></i>
                    info@darvagco.ir
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Company Info -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-building text-warning me-2" style="font-size: 2rem;"></i>
                        <h4 class="mb-0">گروه صنعتی داروگ</h4>
                    </div>
                    <p class="text-light mb-3">
                        کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی، با بهره‌گیری از تجهیزات پیشرفته و تیم متخصص، پروژه‌های بزرگ و پیچیده را با کیفیت و سرعت بالا اجرا می‌کند.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-linkedin fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-telegram fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-whatsapp fa-lg"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>لینک‌های سریع</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('about') }}">درباره ما</a></li>
                        <li class="mb-2"><a href="{{ route('services') }}">خدمات</a></li>
                        <li class="mb-2"><a href="{{ route('projects') }}">پروژه‌ها</a></li>
                        <li class="mb-2"><a href="{{ route('blog') }}">وبلاگ</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">تماس با ما</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>خدمات ما</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">سلر‌سازی</a></li>
                        <li class="mb-2"><a href="#">محوطه‌سازی</a></li>
                        <li class="mb-2"><a href="#">جاده‌سازی</a></li>
                        <li class="mb-2"><a href="#">تسهیل تأسیسات سرچاهی</a></li>
                        <li class="mb-2"><a href="#">پروژه‌های عمرانی</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>اطلاعات تماس</h5>
                    <div class="text-light">
                        <p class="mb-2">
                            <i class="fas fa-phone text-warning me-2"></i>
                            09350801600
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-envelope text-warning me-2"></i>
                            info@darvagco.ir
                        </p>
                        <p class="mb-3">
                            <i class="fas fa-map-marker-alt text-warning me-2"></i>
                            خراسان رضوی - شهرستان سرخس - دهستان خانگیران
                        </p>
                    </div>

                    <!-- QR Code -->
                    <div class="mt-3">
                        <h6 class="text-warning mb-2">دسترسی سریع</h6>
                        <div class="bg-white p-2 rounded d-inline-block">
                            <i class="fas fa-qrcode text-dark" style="font-size: 2rem;"></i>
                        </div>
                        <p class="small text-muted mt-1">اسکن کنید و به وب‌سایت ما دسترسی داشته باشید</p>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p class="mb-2">&copy; ۱۴۰۴ تمامی حقوق برای شرکت کاخ‌سازان داروگ محفوظ است.</p>
                <div class="small">
                    <a href="#" class="me-3">حریم خصوصی</a>
                    <a href="#">شرایط استفاده</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- Lordicon -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Custom JS -->
    <script>
        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('active');
                    const icon = this.querySelector('i');
                    if (mobileMenu.classList.contains('active')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
            }
        });
        
        // Header Scroll Effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            
            if (mobileMenu && mobileMenuBtn && 
                !mobileMenu.contains(event.target) && 
                !mobileMenuBtn.contains(event.target)) {
                mobileMenu.classList.remove('active');
                const icon = mobileMenuBtn.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
