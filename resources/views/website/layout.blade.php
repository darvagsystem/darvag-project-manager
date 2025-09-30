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
    <div class="footer mt-128">
        <div class="container">
            <div class="row">
                <!-- ستون اول -->
                <div class="col-md-3">
                    <h5>گروه صنعتی داروگ</h5>
                    <p>
                        شرکت داروگ در طی سالیان متمادی همگام با توسعه صنعت ساختمان و تحولات
                        جهانی آن، سیاست کلان خود را بر پایه توسعه روش‌های نوین ساخت و ساز،
                        پیش ساختگی سازی صنعتی و استفاده از مصالح و فناوری‌های نو قرار داده
                        است.
                    </p>
                </div>
                <!-- ستون دوم -->
                <div class="col-md-3">
                    <h5>لینک های سریع</h5>
                    <a href="{{ route('about') }}">درباره ما</a>
                    <a href="{{ route('services') }}">خدمات</a>
                    <a href="{{ route('projects') }}">پروژه‌ها</a>
                    <a href="{{ route('contact') }}">تماس با ما</a>
                </div>
                <!-- ستون سوم -->
                <div class="col-md-3">
                    <h5>اطلاعات تماس</h5>
                    <a href="tel:09350801600">تلفن: 09350801600</a>
                    <a href="mailto:info@darvagco.ir">info@darvagco.ir :ایمیل</a>
                    <p>
                        خراسان رضوی - شهرستان سرخس - دهستان خانگیران
                    </p>
                </div>
                <!-- ستون چهارم -->
                <div class="col-md-3 qr-sec">
                    <h5>اسکن کنید</h5>
                    <div class="logo">
                        <img
                            src="{{ asset('assets/images/files/logo.png') }}"
                            class="w-50 footer-logo"
                            alt="Logo"
                        />
                    </div>
                    <div class="footer-divider w-50"></div>
                    <div class="qr-code mt-1">
                        <img
                            src="{{ asset('assets/images/files/qr.png') }}"
                            class="w-25"
                            alt="QR Code"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <!-- متن سمت راست -->
                <div class="col-md-6 text-right">
                    <p>کلیه حقوق این وبسایت متعلق به گروه صنعتی داروگ می‌باشد</p>
                </div>
                <!-- آیکون‌های شبکه‌های اجتماعی سمت چپ -->
                <div class="col-md-6 text-left">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/lordicon.js') }}"></script>

    @stack('scripts')
</body>
</html>
