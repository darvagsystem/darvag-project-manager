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
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top py-0">
        <div class="container shadow-sm">
            <button
                class="navbar-toggler me-auto"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand ms-auto" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/files/logo.png') }}" width="110px" alt="داروگ" />
            </a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">خانه</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">درباره ما</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">خدمات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">تماس با ما</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('projects') ? 'active' : '' }}" href="{{ route('projects') }}">پروژه های ما</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('charity') ? 'active' : '' }}" href="{{ route('charity') }}">پویش نیکی</a>
                    </li>
                </ul>

                <div class="navbar-phone d-lg-only">
                    <a href="tel:09350801600" class="nav-phone">
                        <span>09350801600</span>
                        <i class="bi bi-telephone"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

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

    @stack('scripts')
</body>
</html>
