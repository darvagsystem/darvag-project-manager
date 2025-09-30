@extends('website.layout')

@section('title', 'خدمات - شرکت کاخ‌سازان داروگ')
@section('description', 'خدمات پیمانکاری و ساخت‌وساز شرکت کاخ‌سازان داروگ')

@section('content')
<!-- Page Header -->
<section class="bg-gray-900 text-white py-20 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">خدمات ما</h1>
        <p class="text-xl text-gray-300">طیف وسیعی از خدمات پیمانکاری و ساخت‌وساز</p>
    </div>
</section>

<!-- Main Services -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service 1 -->
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                    <i class="fas fa-home text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">ساخت مسکونی</h3>
                <p class="text-gray-600 mb-6">
                    ساخت انواع ساختمان‌های مسکونی از آپارتمان‌های کوچک تا مجتمع‌های بزرگ با بالاترین کیفیت
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        آپارتمان‌های مسکونی
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        مجتمع‌های مسکونی
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        ویلاهای شخصی
                    </li>
                </ul>
            </div>

            <!-- Service 2 -->
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                    <i class="fas fa-industry text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">ساخت صنعتی</h3>
                <p class="text-gray-600 mb-6">
                    احداث کارخانه‌ها، انبارها و واحدهای صنعتی با رعایت استانداردهای ایمنی و محیط زیست
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        کارخانه‌های تولیدی
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        انبارهای مرکزی
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        واحدهای صنعتی
                    </li>
                </ul>
            </div>

            <!-- Service 3 -->
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                    <i class="fas fa-hospital text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">ساخت درمانی</h3>
                <p class="text-gray-600 mb-6">
                    ساخت بیمارستان‌ها، کلینیک‌ها و مراکز درمانی با تجهیزات مدرن و استانداردهای پزشکی
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        بیمارستان‌های عمومی
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        کلینیک‌های تخصصی
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        مراکز درمانی
                    </li>
                </ul>
            </div>

            <!-- Service 4 -->
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-orange-100 rounded-lg flex items-center justify-center mb-6">
                    <i class="fas fa-school text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">ساخت آموزشی</h3>
                <p class="text-gray-600 mb-6">
                    ساخت مدارس، دانشگاه‌ها و مراکز آموزشی با امکانات مدرن و فضای مناسب
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        مدارس ابتدایی و متوسطه
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        دانشگاه‌ها و مراکز علمی
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        مراکز آموزشی تخصصی
                    </li>
                </ul>
            </div>

            <!-- Service 5 -->
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-teal-100 rounded-lg flex items-center justify-center mb-6">
                    <i class="fas fa-building text-teal-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">ساخت تجاری</h3>
                <p class="text-gray-600 mb-6">
                    ساخت مراکز تجاری، برج‌ها و مجتمع‌های اداری با طراحی مدرن و کاربردی
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        برج‌های تجاری
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        مراکز خرید
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        مجتمع‌های اداری
                    </li>
                </ul>
            </div>

            <!-- Service 6 -->
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                    <i class="fas fa-tools text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">نوسازی و بازسازی</h3>
                <p class="text-gray-600 mb-6">
                    نوسازی و بازسازی ساختمان‌های قدیمی با حفظ معماری و بهبود عملکرد
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        بازسازی کامل
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        نوسازی جزئی
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-2"></i>
                        بهینه‌سازی انرژی
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Process -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">فرآیند کار ما</h2>
            <p class="text-xl text-gray-600">مراحل انجام پروژه از ابتدا تا انتها</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">1</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">مشاوره و طراحی</h3>
                <p class="text-gray-600">بررسی نیازها و طراحی اولیه پروژه</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">2</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">برآورد و قرارداد</h3>
                <p class="text-gray-600">محاسبه هزینه‌ها و امضای قرارداد</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">3</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">اجرا و نظارت</h3>
                <p class="text-gray-600">اجرای پروژه با نظارت مستمر</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-orange-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">4</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">تحویل و پشتیبانی</h3>
                <p class="text-gray-600">تحویل پروژه و ارائه پشتیبانی</p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">چرا داروگ را انتخاب کنید؟</h2>
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0">
                            <i class="fas fa-check text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">کیفیت برتر</h3>
                            <p class="text-gray-600">استفاده از بهترین مواد و تکنولوژی‌های روز دنیا</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">تحویل به موقع</h3>
                            <p class="text-gray-600">تعهد به تحویل پروژه‌ها در زمان مقرر</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0">
                            <i class="fas fa-check text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">تیم متخصص</h3>
                            <p class="text-gray-600">مجموعه‌ای از بهترین مهندسان و کارشناسان</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0">
                            <i class="fas fa-check text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">پشتیبانی کامل</h3>
                            <p class="text-gray-600">ارائه پشتیبانی و خدمات پس از تحویل</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg h-96 flex items-center justify-center">
                <i class="fas fa-cogs text-white text-6xl"></i>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-blue-600 text-white">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-4">آماده شروع پروژه خود هستید؟</h2>
        <p class="text-xl mb-8">با تیم متخصص ما تماس بگیرید و از مشاوره رایگان بهره‌مند شوید</p>
        <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
            <i class="fas fa-phone mr-2"></i>
            تماس با ما
        </a>
    </div>
</section>
@endsection
