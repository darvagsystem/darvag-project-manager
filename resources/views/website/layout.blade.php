<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'شرکت کاخ‌سازان داروگ')</title>
    <meta name="description" content="@yield('description', 'شرکت کاخ‌سازان داروگ - ارائه خدمات پیمانکاری و ساخت‌وساز')">

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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                        <span class="mr-3 text-xl font-bold text-gray-900">داروگ</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4 space-x-reverse">
                        <a href="{{ route('home') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">خانه</a>
                        <a href="{{ route('about') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">درباره ما</a>
                        <a href="{{ route('projects') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">پروژه‌ها</a>
                        <a href="{{ route('services') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">خدمات</a>
                        <a href="{{ route('news') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">اخبار</a>
                        <a href="{{ route('gallery') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">گالری</a>
                        <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">تماس</a>
                    </div>
                </div>

                <!-- Admin Login -->
                <div class="hidden md:block">
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        <i class="fas fa-user-shield mr-2"></i>
                        ورود مدیریت
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" id="mobile-menu-button">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white shadow-lg">
                <a href="{{ route('home') }}" class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">خانه</a>
                <a href="{{ route('about') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">درباره ما</a>
                <a href="{{ route('projects') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">پروژه‌ها</a>
                <a href="{{ route('services') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">خدمات</a>
                <a href="{{ route('news') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">اخبار</a>
                <a href="{{ route('gallery') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">گالری</a>
                <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">تماس</a>
                <a href="{{ route('login') }}" class="bg-blue-600 text-white block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-user-shield mr-2"></i>
                    ورود مدیریت
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
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                        <span class="mr-3 text-2xl font-bold">شرکت کاخ‌سازان داروگ</span>
                    </div>
                    <p class="text-gray-300 mb-4">
                        شرکت کاخ‌سازان داروگ با بیش از 20 سال تجربه در زمینه پیمانکاری و ساخت‌وساز،
                        آماده ارائه خدمات با کیفیت و استانداردهای بین‌المللی است.
                    </p>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-telegram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">دسترسی سریع</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition-colors">درباره ما</a></li>
                        <li><a href="{{ route('projects') }}" class="text-gray-300 hover:text-white transition-colors">پروژه‌ها</a></li>
                        <li><a href="{{ route('services') }}" class="text-gray-300 hover:text-white transition-colors">خدمات</a></li>
                        <li><a href="{{ route('news') }}" class="text-gray-300 hover:text-white transition-colors">اخبار</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">تماس با ما</h3>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-phone ml-2"></i> 021-12345678</p>
                        <p><i class="fas fa-envelope ml-2"></i> info@darvag.com</p>
                        <p><i class="fas fa-map-marker-alt ml-2"></i> تهران، خیابان ولیعصر</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} شرکت کاخ‌سازان داروگ. تمامی حقوق محفوظ است.</p>
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
