@extends('website.layout')

@section('title', 'شرکت کاخ‌سازان داروگ - خانه')
@section('description', 'شرکت کاخ‌سازان داروگ - ارائه خدمات پیمانکاری و ساخت‌وساز با کیفیت و استانداردهای بین‌المللی')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient text-white py-20 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                شرکت کاخ‌سازان داروگ
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">
                پیشرو در صنعت پیمانکاری و ساخت‌وساز
            </p>
            <p class="text-lg mb-10 text-blue-200 max-w-3xl mx-auto">
                با بیش از 20 سال تجربه و تخصص در زمینه ساخت‌وساز، آماده ارائه خدمات با کیفیت و استانداردهای بین‌المللی هستیم
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('projects') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-building mr-2"></i>
                    مشاهده پروژه‌ها
                </a>
                <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                    <i class="fas fa-phone mr-2"></i>
                    تماس با ما
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">چرا داروگ را انتخاب کنید؟</h2>
            <p class="text-xl text-gray-600">مزایای رقابتی ما در صنعت ساخت‌وساز</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center card-hover p-6 rounded-lg">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-award text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">کیفیت برتر</h3>
                <p class="text-gray-600">استفاده از بهترین مواد و تکنولوژی‌های روز دنیا در تمامی پروژه‌ها</p>
            </div>
            
            <div class="text-center card-hover p-6 rounded-lg">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">تحویل به موقع</h3>
                <p class="text-gray-600">تعهد به تحویل پروژه‌ها در زمان مقرر با حفظ کیفیت</p>
            </div>
            
            <div class="text-center card-hover p-6 rounded-lg">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">تیم متخصص</h3>
                <p class="text-gray-600">مجموعه‌ای از بهترین مهندسان و کارشناسان با تجربه</p>
            </div>
        </div>
    </div>
</section>

<!-- Recent Projects Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">پروژه‌های اخیر</h2>
            <p class="text-xl text-gray-600">نمونه‌ای از کارهای انجام شده توسط تیم ما</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                    <i class="fas fa-building text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">مجتمع مسکونی پارک</h3>
                    <p class="text-gray-600 mb-4">ساخت مجتمع مسکونی 50 واحدی در منطقه شمال تهران</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">1402</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">جزئیات بیشتر</a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center">
                    <i class="fas fa-industry text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">کارخانه تولیدی</h3>
                    <p class="text-gray-600 mb-4">احداث کارخانه تولیدی 5000 متری در شهرک صنعتی</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">1401</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">جزئیات بیشتر</a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-r from-purple-400 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-hospital text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">بیمارستان تخصصی</h3>
                    <p class="text-gray-600 mb-4">ساخت بیمارستان 200 تختخوابی با تجهیزات مدرن</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">1400</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">جزئیات بیشتر</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('projects') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                مشاهده همه پروژه‌ها
            </a>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">خدمات ما</h2>
            <p class="text-xl text-gray-600">طیف وسیعی از خدمات پیمانکاری و ساخت‌وساز</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center p-6 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-home text-blue-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">ساخت مسکونی</h3>
                <p class="text-sm text-gray-600">ساخت انواع ساختمان‌های مسکونی</p>
            </div>
            
            <div class="text-center p-6 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-industry text-green-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">ساخت صنعتی</h3>
                <p class="text-sm text-gray-600">احداث کارخانه و واحدهای صنعتی</p>
            </div>
            
            <div class="text-center p-6 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hospital text-purple-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">ساخت درمانی</h3>
                <p class="text-sm text-gray-600">ساخت بیمارستان و مراکز درمانی</p>
            </div>
            
            <div class="text-center p-6 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-school text-orange-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">ساخت آموزشی</h3>
                <p class="text-sm text-gray-600">ساخت مدرسه و مراکز آموزشی</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-blue-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold mb-2">150+</div>
                <div class="text-blue-200">پروژه تکمیل شده</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">20+</div>
                <div class="text-blue-200">سال تجربه</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">50+</div>
                <div class="text-blue-200">مهندس متخصص</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">100%</div>
                <div class="text-blue-200">رضایت مشتریان</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">آماده شروع پروژه بعدی خود هستید؟</h2>
        <p class="text-xl text-gray-600 mb-8">
            با تیم متخصص ما تماس بگیرید و از مشاوره رایگان بهره‌مند شوید
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                <i class="fas fa-phone mr-2"></i>
                تماس با ما
            </a>
            <a href="{{ route('projects') }}" class="border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition-colors">
                <i class="fas fa-building mr-2"></i>
                مشاهده پروژه‌ها
            </a>
        </div>
    </div>
</section>
@endsection
