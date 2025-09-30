@extends('website.layout')

@section('title', 'پروژه‌ها - شرکت کاخ‌سازان داروگ')
@section('description', 'مشاهده پروژه‌های انجام شده توسط شرکت کاخ‌سازان داروگ')

@section('content')
<!-- Page Header -->
<section class="bg-gray-900 text-white py-20 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">پروژه‌های ما</h1>
        <p class="text-xl text-gray-300">نمونه‌ای از کارهای انجام شده توسط تیم متخصص ما</p>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filter Buttons -->
        <div class="flex flex-wrap justify-center gap-4 mb-12">
            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium">همه</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300">مسکونی</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300">صنعتی</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300">درمانی</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300">آموزشی</button>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Project 1 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                    <i class="fas fa-building text-white text-5xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">مجتمع مسکونی پارک</h3>
                    <p class="text-gray-600 mb-4">ساخت مجتمع مسکونی 50 واحدی در منطقه شمال تهران با امکانات مدرن و فضای سبز</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">1402</span>
                        <span class="text-sm text-blue-600 font-medium">مسکونی</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">5000 متر مربع</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">جزئیات بیشتر</a>
                    </div>
                </div>
            </div>

            <!-- Project 2 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center">
                    <i class="fas fa-industry text-white text-5xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">کارخانه تولیدی</h3>
                    <p class="text-gray-600 mb-4">احداث کارخانه تولیدی 5000 متری در شهرک صنعتی با تجهیزات مدرن</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">1401</span>
                        <span class="text-sm text-green-600 font-medium">صنعتی</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">5000 متر مربع</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">جزئیات بیشتر</a>
                    </div>
                </div>
            </div>

            <!-- Project 3 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-purple-400 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-hospital text-white text-5xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">بیمارستان تخصصی</h3>
                    <p class="text-gray-600 mb-4">ساخت بیمارستان 200 تختخوابی با تجهیزات مدرن و سیستم‌های پیشرفته</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">1400</span>
                        <span class="text-sm text-purple-600 font-medium">درمانی</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">8000 متر مربع</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">جزئیات بیشتر</a>
                    </div>
                </div>
            </div>

            <!-- Project 4 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-orange-400 to-orange-600 flex items-center justify-center">
                    <i class="fas fa-school text-white text-5xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">مدرسه هوشمند</h3>
                    <p class="text-gray-600 mb-4">ساخت مدرسه 12 کلاسه با سیستم‌های هوشمند و امکانات آموزشی مدرن</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">1399</span>
                        <span class="text-sm text-orange-600 font-medium">آموزشی</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">2000 متر مربع</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">جزئیات بیشتر</a>
                    </div>
                </div>
            </div>

            <!-- Project 5 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-teal-400 to-teal-600 flex items-center justify-center">
                    <i class="fas fa-building text-white text-5xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">برج تجاری</h3>
                    <p class="text-gray-600 mb-4">ساخت برج تجاری 20 طبقه در مرکز شهر با امکانات مدرن</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">1398</span>
                        <span class="text-sm text-teal-600 font-medium">تجاری</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">15000 متر مربع</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">جزئیات بیشتر</a>
                    </div>
                </div>
            </div>

            <!-- Project 6 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-64 bg-gradient-to-r from-red-400 to-red-600 flex items-center justify-center">
                    <i class="fas fa-warehouse text-white text-5xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">انبار مرکزی</h3>
                    <p class="text-gray-600 mb-4">احداث انبار مرکزی 10000 متری با سیستم‌های پیشرفته نگهداری</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">1397</span>
                        <span class="text-sm text-red-600 font-medium">صنعتی</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">10000 متر مربع</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">جزئیات بیشتر</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12">
            <button class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                مشاهده پروژه‌های بیشتر
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
                <div class="text-gray-600">مشتری راضی</div>
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
