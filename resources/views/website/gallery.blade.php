@extends('website.layout')

@section('title', 'گالری - شرکت کاخ‌سازان داروگ')
@section('description', 'گالری تصاویر پروژه‌های انجام شده توسط شرکت کاخ‌سازان داروگ')

@section('content')
<!-- Page Header -->
<section class="bg-gray-900 text-white py-20 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">گالری تصاویر</h1>
        <p class="text-xl text-gray-300">نمونه‌ای از پروژه‌های انجام شده توسط تیم ما</p>
    </div>
</section>

<!-- Gallery Filter -->
<section class="py-8 bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-4">
            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium">همه</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300">مسکونی</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300">صنعتی</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300">درمانی</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300">آموزشی</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300">تجاری</button>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Gallery Item 1 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                    <i class="fas fa-building text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">مجتمع مسکونی پارک</h3>
                    <p class="text-sm text-gray-600">ساخت مسکونی</p>
                </div>
            </div>

            <!-- Gallery Item 2 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center">
                    <i class="fas fa-industry text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">کارخانه تولیدی</h3>
                    <p class="text-sm text-gray-600">ساخت صنعتی</p>
                </div>
            </div>

            <!-- Gallery Item 3 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-purple-400 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-hospital text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">بیمارستان تخصصی</h3>
                    <p class="text-sm text-gray-600">ساخت درمانی</p>
                </div>
            </div>

            <!-- Gallery Item 4 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-orange-400 to-orange-600 flex items-center justify-center">
                    <i class="fas fa-school text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">مدرسه هوشمند</h3>
                    <p class="text-sm text-gray-600">ساخت آموزشی</p>
                </div>
            </div>

            <!-- Gallery Item 5 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-teal-400 to-teal-600 flex items-center justify-center">
                    <i class="fas fa-building text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">برج تجاری</h3>
                    <p class="text-sm text-gray-600">ساخت تجاری</p>
                </div>
            </div>

            <!-- Gallery Item 6 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-red-400 to-red-600 flex items-center justify-center">
                    <i class="fas fa-warehouse text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">انبار مرکزی</h3>
                    <p class="text-sm text-gray-600">ساخت صنعتی</p>
                </div>
            </div>

            <!-- Gallery Item 7 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-indigo-400 to-indigo-600 flex items-center justify-center">
                    <i class="fas fa-building text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">مجتمع اداری</h3>
                    <p class="text-sm text-gray-600">ساخت تجاری</p>
                </div>
            </div>

            <!-- Gallery Item 8 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-pink-400 to-pink-600 flex items-center justify-center">
                    <i class="fas fa-home text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">ویلای شخصی</h3>
                    <p class="text-sm text-gray-600">ساخت مسکونی</p>
                </div>
            </div>

            <!-- Gallery Item 9 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-yellow-400 to-yellow-600 flex items-center justify-center">
                    <i class="fas fa-university text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">دانشگاه</h3>
                    <p class="text-sm text-gray-600">ساخت آموزشی</p>
                </div>
            </div>

            <!-- Gallery Item 10 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-cyan-400 to-cyan-600 flex items-center justify-center">
                    <i class="fas fa-clinic-medical text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">کلینیک تخصصی</h3>
                    <p class="text-sm text-gray-600">ساخت درمانی</p>
                </div>
            </div>

            <!-- Gallery Item 11 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-lime-400 to-lime-600 flex items-center justify-center">
                    <i class="fas fa-industry text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">واحد صنعتی</h3>
                    <p class="text-sm text-gray-600">ساخت صنعتی</p>
                </div>
            </div>

            <!-- Gallery Item 12 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-rose-400 to-rose-600 flex items-center justify-center">
                    <i class="fas fa-building text-white text-4xl"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">مرکز خرید</h3>
                    <p class="text-sm text-gray-600">ساخت تجاری</p>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12">
            <button class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                مشاهده تصاویر بیشتر
            </button>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-blue-600 mb-2">150+</div>
                <div class="text-gray-600">پروژه تکمیل شده</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-green-600 mb-2">500+</div>
                <div class="text-gray-600">تصویر در گالری</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-purple-600 mb-2">20+</div>
                <div class="text-gray-600">سال تجربه</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-orange-600 mb-2">100%</div>
                <div class="text-gray-600">رضایت مشتریان</div>
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
