@extends('website.layout')

@section('title', 'وبلاگ - کاخ‌سازان داروگ')
@section('description', 'آخرین اخبار و مقالات شرکت کاخ‌سازان داروگ در زمینه ساخت‌وساز و مهندسی')

@section('content')
<!-- Page Header -->
<section class="bg-gray-900 text-white py-20 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">وبلاگ داروگ</h1>
        <p class="text-xl text-gray-300">آخرین اخبار، مقالات و رویدادهای شرکت کاخ‌سازان داروگ</p>
    </div>
</section>

<!-- Blog Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Featured Post -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                    <div class="md:flex">
                        <div class="md:w-1/2">
                            <div class="bg-gray-200 h-64 md:h-full flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-image text-gray-500 text-4xl mb-2"></i>
                                    <p class="text-gray-600">تصویر مقاله</p>
                                </div>
                            </div>
                        </div>
                        <div class="md:w-1/2 p-8">
                            <div class="flex items-center mb-4">
                                <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full mr-2">مقاله ویژه</span>
                                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">جدید</span>
                            </div>
                            <h2 class="text-2xl font-bold darvag-text mb-4">نوآوری‌های جدید در صنعت ساخت‌وساز</h2>
                            <p class="text-gray-600 mb-4">بررسی آخرین تکنولوژی‌ها و روش‌های نوین در صنعت ساخت‌وساز و تأثیر آن‌ها بر کیفیت و سرعت اجرای پروژه‌ها</p>
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span><i class="fas fa-calendar ml-1"></i> 15 آذر 1403</span>
                                <span><i class="fas fa-eye ml-1"></i> 1,250 بازدید</span>
                                <span><i class="fas fa-comment ml-1"></i> 5 نظر</span>
                            </div>
                            <a href="#" class="darvag-blue text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition-colors">
                                مطالعه بیشتر
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Blog Posts Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                        <div class="bg-gray-200 h-48 flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 text-3xl"></i>
                        </div>
                        <div class="p-6">
                            <div class="text-sm text-gray-500 mb-2">دسته‌بندی: تکنولوژی</div>
                            <h3 class="text-xl font-semibold darvag-text mb-3">استفاده از هوش مصنوعی در مدیریت پروژه‌های عمرانی</h3>
                            <p class="text-gray-600 mb-4">نحوه بهره‌گیری از هوش مصنوعی برای بهبود مدیریت و کنترل پروژه‌های عمرانی</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>12 آذر 1403</span>
                                <span>3 دقیقه مطالعه</span>
                            </div>
                        </div>
                    </article>

                    <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                        <div class="bg-gray-200 h-48 flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 text-3xl"></i>
                        </div>
                        <div class="p-6">
                            <div class="text-sm text-gray-500 mb-2">دسته‌بندی: ایمنی</div>
                            <h3 class="text-xl font-semibold darvag-text mb-3">استانداردهای ایمنی در پروژه‌های صنعتی</h3>
                            <p class="text-gray-600 mb-4">راهنمای کامل استانداردهای ایمنی و بهداشت در پروژه‌های صنعتی و عمرانی</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>10 آذر 1403</span>
                                <span>5 دقیقه مطالعه</span>
                            </div>
                        </div>
                    </article>

                    <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                        <div class="bg-gray-200 h-48 flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 text-3xl"></i>
                        </div>
                        <div class="p-6">
                            <div class="text-sm text-gray-500 mb-2">دسته‌بندی: محیط زیست</div>
                            <h3 class="text-xl font-semibold darvag-text mb-3">ساخت‌وساز سبز و پایدار</h3>
                            <p class="text-gray-600 mb-4">روش‌های ساخت‌وساز دوستدار محیط زیست و استفاده از مصالح پایدار</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>8 آذر 1403</span>
                                <span>4 دقیقه مطالعه</span>
                            </div>
                        </div>
                    </article>

                    <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                        <div class="bg-gray-200 h-48 flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 text-3xl"></i>
                        </div>
                        <div class="p-6">
                            <div class="text-sm text-gray-500 mb-2">دسته‌بندی: مدیریت</div>
                            <h3 class="text-xl font-semibold darvag-text mb-3">مدیریت ریسک در پروژه‌های بزرگ</h3>
                            <p class="text-gray-600 mb-4">راهکارهای شناسایی و مدیریت ریسک در پروژه‌های بزرگ عمرانی و صنعتی</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>5 آذر 1403</span>
                                <span>6 دقیقه مطالعه</span>
                            </div>
                        </div>
                    </article>

                    <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                        <div class="bg-gray-200 h-48 flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 text-3xl"></i>
                        </div>
                        <div class="p-6">
                            <div class="text-sm text-gray-500 mb-2">دسته‌بندی: آموزش</div>
                            <h3 class="text-xl font-semibold darvag-text mb-3">آموزش نیروی انسانی در صنعت ساخت‌وساز</h3>
                            <p class="text-gray-600 mb-4">اهمیت آموزش و توسعه مهارت‌های نیروی انسانی در صنعت ساخت‌وساز</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>3 آذر 1403</span>
                                <span>4 دقیقه مطالعه</span>
                            </div>
                        </div>
                    </article>

                    <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                        <div class="bg-gray-200 h-48 flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 text-3xl"></i>
                        </div>
                        <div class="p-6">
                            <div class="text-sm text-gray-500 mb-2">دسته‌بندی: اخبار</div>
                            <h3 class="text-xl font-semibold darvag-text mb-3">افتتاح پروژه جدید داروگ در منطقه خانگیران</h3>
                            <p class="text-gray-600 mb-4">گزارش کامل از افتتاح پروژه جدید شرکت داروگ در منطقه خانگیران</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>1 آذر 1403</span>
                                <span>3 دقیقه مطالعه</span>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-12">
                    <nav class="flex space-x-2 space-x-reverse">
                        <a href="#" class="px-3 py-2 text-gray-500 hover:text-gray-700">قبلی</a>
                        <a href="#" class="px-3 py-2 bg-darvag-blue text-white rounded">1</a>
                        <a href="#" class="px-3 py-2 text-gray-500 hover:text-gray-700">2</a>
                        <a href="#" class="px-3 py-2 text-gray-500 hover:text-gray-700">3</a>
                        <a href="#" class="px-3 py-2 text-gray-500 hover:text-gray-700">بعدی</a>
                    </nav>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Search -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold darvag-text mb-4">جستجو در وبلاگ</h3>
                    <div class="relative">
                        <input type="text" placeholder="جستجو..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button class="absolute left-2 top-2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold darvag-text mb-4">دسته‌بندی‌ها</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:darvag-text-light transition-colors">تکنولوژی (8)</a></li>
                        <li><a href="#" class="text-gray-600 hover:darvag-text-light transition-colors">ایمنی (12)</a></li>
                        <li><a href="#" class="text-gray-600 hover:darvag-text-light transition-colors">محیط زیست (6)</a></li>
                        <li><a href="#" class="text-gray-600 hover:darvag-text-light transition-colors">مدیریت (10)</a></li>
                        <li><a href="#" class="text-gray-600 hover:darvag-text-light transition-colors">آموزش (5)</a></li>
                        <li><a href="#" class="text-gray-600 hover:darvag-text-light transition-colors">اخبار (15)</a></li>
                    </ul>
                </div>

                <!-- Recent Posts -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold darvag-text mb-4">آخرین مطالب</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center ml-3 flex-shrink-0">
                                <i class="fas fa-image text-gray-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm darvag-text mb-1">نوآوری‌های جدید در صنعت ساخت‌وساز</h4>
                                <p class="text-xs text-gray-500">15 آذر 1403</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center ml-3 flex-shrink-0">
                                <i class="fas fa-image text-gray-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm darvag-text mb-1">استفاده از هوش مصنوعی در مدیریت پروژه‌ها</h4>
                                <p class="text-xs text-gray-500">12 آذر 1403</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center ml-3 flex-shrink-0">
                                <i class="fas fa-image text-gray-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm darvag-text mb-1">استانداردهای ایمنی در پروژه‌های صنعتی</h4>
                                <p class="text-xs text-gray-500">10 آذر 1403</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tags -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold darvag-text mb-4">برچسب‌ها</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">ساخت‌وساز</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">مهندسی</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">ایمنی</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">تکنولوژی</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">محیط زیست</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">مدیریت</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">آموزش</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">اخبار</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
