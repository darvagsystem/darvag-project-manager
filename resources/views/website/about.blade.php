@extends('website.layout')

@section('title', 'درباره ما - شرکت کاخ‌سازان داروگ')
@section('description', 'درباره شرکت کاخ‌سازان داروگ - بیش از 20 سال تجربه در صنعت پیمانکاری و ساخت‌وساز')

@section('content')
<!-- Page Header -->
<section class="bg-gray-900 text-white py-20 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">درباره ما</h1>
        <p class="text-xl text-gray-300">تاریخچه و ماموریت شرکت کاخ‌سازان داروگ</p>
    </div>
</section>

<!-- Company Story -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">داستان ما</h2>
                <p class="text-lg text-gray-600 mb-6">
                    شرکت کاخ‌سازان داروگ در سال 1380 با هدف ارائه خدمات با کیفیت در زمینه پیمانکاری و ساخت‌وساز تأسیس شد. 
                    از همان ابتدا، تمرکز ما بر روی کیفیت، نوآوری و رضایت مشتریان بوده است.
                </p>
                <p class="text-lg text-gray-600 mb-6">
                    طی بیش از دو دهه فعالیت، موفق به تکمیل بیش از 150 پروژه بزرگ و کوچک شده‌ایم که شامل 
                    مجتمع‌های مسکونی، کارخانه‌ها، بیمارستان‌ها، مدارس و سایر پروژه‌های عمرانی می‌باشد.
                </p>
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-award text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">تعهد به کیفیت</h3>
                        <p class="text-gray-600">استفاده از بهترین مواد و تکنولوژی‌های روز</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg h-96 flex items-center justify-center">
                <i class="fas fa-building text-white text-6xl"></i>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                    <i class="fas fa-bullseye text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">ماموریت ما</h3>
                <p class="text-gray-600">
                    ارائه خدمات پیمانکاری و ساخت‌وساز با بالاترین کیفیت و استانداردهای بین‌المللی، 
                    با هدف ایجاد ارزش برای مشتریان و جامعه.
                </p>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                    <i class="fas fa-eye text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">چشم‌انداز ما</h3>
                <p class="text-gray-600">
                    تبدیل شدن به پیشروترین شرکت پیمانکاری در منطقه با تکیه بر نوآوری، 
                    کیفیت و تعهد به توسعه پایدار.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">ارزش‌های ما</h2>
            <p class="text-xl text-gray-600">اصول و ارزش‌هایی که در تمام فعالیت‌های ما رعایت می‌شود</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-blue-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">اعتماد و شفافیت</h3>
                <p class="text-gray-600">در تمام مراحل پروژه، شفافیت کامل و اعتماد متقابل را حفظ می‌کنیم</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-leaf text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">پایداری محیط زیست</h3>
                <p class="text-gray-600">تعهد به استفاده از روش‌های سازگار با محیط زیست در تمام پروژه‌ها</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lightbulb text-purple-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">نوآوری و خلاقیت</h3>
                <p class="text-gray-600">استفاده از جدیدترین تکنولوژی‌ها و روش‌های نوین در ساخت‌وساز</p>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">تیم ما</h2>
            <p class="text-xl text-gray-600">مجموعه‌ای از بهترین متخصصان و مهندسان</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-user text-gray-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">مهندس احمد محمدی</h3>
                <p class="text-blue-600 mb-2">مدیرعامل</p>
                <p class="text-gray-600">20 سال تجربه در مدیریت پروژه‌های بزرگ</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-user text-gray-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">مهندس فاطمه احمدی</h3>
                <p class="text-blue-600 mb-2">مدیر فنی</p>
                <p class="text-gray-600">متخصص در طراحی و اجرای پروژه‌های پیچیده</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-user text-gray-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">مهندس علی رضایی</h3>
                <p class="text-blue-600 mb-2">مدیر اجرایی</p>
                <p class="text-gray-600">15 سال تجربه در اجرای پروژه‌های عمرانی</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-blue-600 text-white">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-4">آماده همکاری با ما هستید؟</h2>
        <p class="text-xl mb-8">با تیم متخصص ما تماس بگیرید و از مشاوره رایگان بهره‌مند شوید</p>
        <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
            <i class="fas fa-phone mr-2"></i>
            تماس با ما
        </a>
    </div>
</section>
@endsection
