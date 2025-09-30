<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'کاخ‌سازان داروگ - داستان ساخت و ساز')</title>
    <meta name="description" content="@yield('description', 'کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی')">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Vazirmatn', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3b82f6 100%);
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .navbar-scroll {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .darvag-blue {
            background-color: #1e3a8a;
        }

        .darvag-light-blue {
            background-color: #3b82f6;
        }

        .darvag-text {
            color: #1e3a8a;
        }

        .darvag-text-light {
            color: #3b82f6;
        }

        .text-gradient {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white shadow-sm" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <div class="w-10 h-10 darvag-blue rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                        <span class="mr-3 text-xl font-bold darvag-text">داروگ</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4 space-x-reverse">
                        <a href="{{ route('home') }}" class="darvag-text hover:darvag-text-light px-3 py-2 rounded-md text-sm font-medium transition-colors">خانه</a>
                        <a href="{{ route('about') }}" class="text-gray-600 hover:darvag-text-light px-3 py-2 rounded-md text-sm font-medium transition-colors">درباره ما</a>
                        <a href="{{ route('services') }}" class="text-gray-600 hover:darvag-text-light px-3 py-2 rounded-md text-sm font-medium transition-colors">خدمات</a>
                        <a href="{{ route('projects') }}" class="text-gray-600 hover:darvag-text-light px-3 py-2 rounded-md text-sm font-medium transition-colors">پروژه‌های ما</a>
                        <a href="{{ route('news') }}" class="text-gray-600 hover:darvag-text-light px-3 py-2 rounded-md text-sm font-medium transition-colors">وبلاگ</a>
                        <a href="#" class="text-gray-600 hover:darvag-text-light px-3 py-2 rounded-md text-sm font-medium transition-colors">پویش نیکی <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full mr-1">جدید</span></a>
                        <a href="{{ route('contact') }}" class="text-gray-600 hover:darvag-text-light px-3 py-2 rounded-md text-sm font-medium transition-colors">تماس با ما</a>
                    </div>
                </div>

                <!-- Phone Number -->
                <div class="hidden md:block">
                    <a href="tel:09350801600" class="darvag-text font-semibold text-sm">
                        <i class="fas fa-phone ml-1"></i>
                        09350801600
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="darvag-blue inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" id="mobile-menu-button">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white shadow-lg">
                <a href="{{ route('home') }}" class="darvag-text block px-3 py-2 rounded-md text-base font-medium">خانه</a>
                <a href="{{ route('about') }}" class="text-gray-600 hover:darvag-text-light block px-3 py-2 rounded-md text-base font-medium">درباره ما</a>
                <a href="{{ route('services') }}" class="text-gray-600 hover:darvag-text-light block px-3 py-2 rounded-md text-base font-medium">خدمات</a>
                <a href="{{ route('projects') }}" class="text-gray-600 hover:darvag-text-light block px-3 py-2 rounded-md text-base font-medium">پروژه‌های ما</a>
                <a href="{{ route('news') }}" class="text-gray-600 hover:darvag-text-light block px-3 py-2 rounded-md text-base font-medium">وبلاگ</a>
                <a href="#" class="text-gray-600 hover:darvag-text-light block px-3 py-2 rounded-md text-base font-medium">پویش نیکی <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full mr-1">جدید</span></a>
                <a href="{{ route('contact') }}" class="text-gray-600 hover:darvag-text-light block px-3 py-2 rounded-md text-base font-medium">تماس با ما</a>
                <a href="tel:09350801600" class="darvag-text font-semibold block px-3 py-2 rounded-md text-base">
                    <i class="fas fa-phone ml-1"></i>
                    09350801600
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 darvag-light-blue rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                        <span class="mr-3 text-2xl font-bold">گروه صنعتی داروگ</span>
                    </div>
                    <p class="text-gray-300 mb-4">
                        کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی، با بهره‌گیری از تجهیزات پیشرفته و تیم متخصص، پروژه‌های بزرگ و پیچیده را با کیفیت و سرعت بالا اجرا می‌کند.
                    </p>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-telegram text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">لینک‌های سریع</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">رتبه بندی شرکت ها</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">سامانه جامع قرارداد ها</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition-colors">درباره ما</a></li>
                        <li><a href="{{ route('projects') }}" class="text-gray-300 hover:text-white transition-colors">پروژه‌ها</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">اطلاعات تماس</h3>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-phone ml-2"></i> 09350801600</p>
                        <p><i class="fas fa-envelope ml-2"></i> info@darvagco.ir</p>
                        <p><i class="fas fa-map-marker-alt ml-2"></i> خراسان رضوی - شهرستان سرخس - دهستان خانگیران</p>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-sm font-semibold mb-2">دسترسی سریع</h4>
                        <p class="text-xs text-gray-400">اسکن کنید و به وب‌سایت ما دسترسی داشته باشید</p>
                        <div class="w-16 h-16 bg-white rounded mt-2 flex items-center justify-center">
                            <i class="fas fa-qrcode text-gray-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; ۱۴۰۴ تمامی حقوق برای شرکت کاخ‌سازان داروگ محفوظ است.</p>
                <div class="mt-2 text-sm">
                    <a href="#" class="hover:text-white transition-colors ml-4">حریم خصوصی</a>
                    <a href="#" class="hover:text-white transition-colors">شرایط استفاده</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scroll', 'shadow-lg');
            } else {
                navbar.classList.remove('navbar-scroll', 'shadow-lg');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>