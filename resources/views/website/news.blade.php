@extends('website.layout')

@section('title', 'اخبار - شرکت کاخ‌سازان داروگ')
@section('description', 'آخرین اخبار و رویدادهای شرکت کاخ‌سازان داروگ')

@section('content')
<!-- Page Header -->
<section class="bg-gray-900 text-white py-20 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">اخبار و رویدادها</h1>
        <p class="text-xl text-gray-300">آخرین اخبار و رویدادهای شرکت کاخ‌سازان داروگ</p>
    </div>
</section>

<!-- News Grid -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- News 1 -->
            <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                    <i class="fas fa-newspaper text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="text-sm text-gray-500">15 مهر 1402</span>
                        <span class="text-sm text-blue-600 font-medium mr-4">اخبار شرکت</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">تکمیل پروژه مجتمع مسکونی پارک</h3>
                    <p class="text-gray-600 mb-4">
                        پروژه مجتمع مسکونی پارک با موفقیت تکمیل شد و به مشتریان تحویل داده شد. این پروژه شامل 50 واحد مسکونی...
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">ادامه مطلب</a>
                </div>
            </article>

            <!-- News 2 -->
            <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center">
                    <i class="fas fa-award text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="text-sm text-gray-500">10 مهر 1402</span>
                        <span class="text-sm text-green-600 font-medium mr-4">جوایز</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">دریافت جایزه کیفیت ساخت</h3>
                    <p class="text-gray-600 mb-4">
                        شرکت کاخ‌سازان داروگ موفق به دریافت جایزه کیفیت ساخت از انجمن مهندسان ساختمان شد...
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">ادامه مطلب</a>
                </div>
            </article>

            <!-- News 3 -->
            <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-r from-purple-400 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-handshake text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="text-sm text-gray-500">5 مهر 1402</span>
                        <span class="text-sm text-purple-600 font-medium mr-4">قرارداد</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">امضای قرارداد جدید با شهرداری</h3>
                    <p class="text-gray-600 mb-4">
                        قرارداد ساخت مرکز فرهنگی جدید با شهرداری تهران امضا شد. این پروژه شامل سالن‌های چند منظوره...
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">ادامه مطلب</a>
                </div>
            </article>

            <!-- News 4 -->
            <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-r from-orange-400 to-orange-600 flex items-center justify-center">
                    <i class="fas fa-users text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="text-sm text-gray-500">28 شهریور 1402</span>
                        <span class="text-sm text-orange-600 font-medium mr-4">رویداد</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">برگزاری کارگاه آموزشی</h3>
                    <p class="text-gray-600 mb-4">
                        کارگاه آموزشی "تکنولوژی‌های نوین در ساخت‌وساز" با حضور 50 مهندس برگزار شد...
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">ادامه مطلب</a>
                </div>
            </article>

            <!-- News 5 -->
            <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-r from-teal-400 to-teal-600 flex items-center justify-center">
                    <i class="fas fa-leaf text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="text-sm text-gray-500">20 شهریور 1402</span>
                        <span class="text-sm text-teal-600 font-medium mr-4">محیط زیست</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">تعهد به ساخت‌وساز سبز</h3>
                    <p class="text-gray-600 mb-4">
                        شرکت داروگ متعهد شد که در تمام پروژه‌های آینده از روش‌های سازگار با محیط زیست استفاده کند...
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">ادامه مطلب</a>
                </div>
            </article>

            <!-- News 6 -->
            <article class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-r from-red-400 to-red-600 flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="text-sm text-gray-500">15 شهریور 1402</span>
                        <span class="text-sm text-red-600 font-medium mr-4">آمار</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">رشد 30 درصدی درآمد</h3>
                    <p class="text-gray-600 mb-4">
                        درآمد شرکت در نیمه اول سال 1402 نسبت به سال گذشته 30 درصد رشد داشته است...
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">ادامه مطلب</a>
                </div>
            </article>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12">
            <button class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                مشاهده اخبار بیشتر
            </button>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">عضویت در خبرنامه</h2>
        <p class="text-xl text-gray-600 mb-8">
            برای دریافت آخرین اخبار و رویدادهای شرکت، در خبرنامه ما عضو شوید
        </p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
            <input type="email" placeholder="ایمیل خود را وارد کنید"
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                عضویت
            </button>
        </form>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-blue-600 text-white">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-4">آیا سوالی دارید؟</h2>
        <p class="text-xl mb-8">با تیم ما تماس بگیرید و پاسخ سوالات خود را دریافت کنید</p>
        <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
            <i class="fas fa-phone mr-2"></i>
            تماس با ما
        </a>
    </div>
</section>
@endsection
