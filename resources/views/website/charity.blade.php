@extends('website.layout')

@section('title', 'پویش نیکی - کاخ‌سازان داروگ')
@section('description', 'پویش نیکی کاخ‌سازان داروگ - مشارکت در امور خیریه و کمک به جامعه')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-green-600 to-green-800 text-white py-20 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">پویش نیکی داروگ</h1>
        <p class="text-xl text-green-100">مشارکت در امور خیریه و کمک به جامعه</p>
    </div>
</section>

<!-- Mission Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold darvag-text mb-6">ماموریت ما در پویش نیکی</h2>
            <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                شرکت کاخ‌سازان داروگ با اعتقاد به مسئولیت اجتماعی خود، در قالب پویش نیکی، 
                در امور خیریه و کمک به جامعه مشارکت می‌کند. ما معتقدیم که موفقیت واقعی 
                زمانی حاصل می‌شود که بتوانیم به جامعه و همنوعان خود کمک کنیم.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-4">کمک به نیازمندان</h3>
                <p class="text-gray-600">ارائه کمک‌های مالی و غیرمالی به خانواده‌های نیازمند و محروم</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-graduation-cap text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-4">حمایت از آموزش</h3>
                <p class="text-gray-600">پشتیبانی از تحصیل کودکان و نوجوانان در مناطق محروم</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-home text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-4">ساخت مسکن</h3>
                <p class="text-gray-600">ساخت و بازسازی مسکن برای خانواده‌های بی‌سرپناه</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold darvag-text mb-4">آمار پویش نیکی داروگ</h2>
            <p class="text-xl text-gray-600">دستاوردهای ما در زمینه امور خیریه</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center bg-white rounded-lg p-8 shadow-lg">
                <div class="text-4xl font-bold text-green-600 mb-2">500+</div>
                <div class="text-gray-600">خانواده تحت پوشش</div>
            </div>
            
            <div class="text-center bg-white rounded-lg p-8 shadow-lg">
                <div class="text-4xl font-bold text-green-600 mb-2">50+</div>
                <div class="text-gray-600">پروژه خیریه</div>
            </div>
            
            <div class="text-center bg-white rounded-lg p-8 shadow-lg">
                <div class="text-4xl font-bold text-green-600 mb-2">100+</div>
                <div class="text-gray-600">دانش‌آموز بورسیه</div>
            </div>
            
            <div class="text-center bg-white rounded-lg p-8 shadow-lg">
                <div class="text-4xl font-bold text-green-600 mb-2">25+</div>
                <div class="text-gray-600">مسکن ساخته شده</div>
            </div>
        </div>
    </div>
</section>

<!-- Current Projects Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold darvag-text mb-4">پروژه‌های جاری</h2>
            <p class="text-xl text-gray-600">پروژه‌های خیریه در حال اجرا</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="bg-green-100 h-48 flex items-center justify-center">
                    <i class="fas fa-school text-green-600 text-4xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full mr-2">در حال اجرا</span>
                        <span class="text-sm text-gray-500">75% تکمیل شده</span>
                    </div>
                    <h3 class="text-xl font-semibold darvag-text mb-3">ساخت مدرسه در منطقه خانگیران</h3>
                    <p class="text-gray-600 mb-4">ساخت مدرسه ابتدایی برای کودکان منطقه خانگیران با ظرفیت 200 دانش‌آموز</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>بودجه: 2 میلیارد تومان</span>
                        <span>جمع‌آوری شده: 1.5 میلیارد</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="bg-blue-100 h-48 flex items-center justify-center">
                    <i class="fas fa-home text-blue-600 text-4xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full mr-2">در حال اجرا</span>
                        <span class="text-sm text-gray-500">60% تکمیل شده</span>
                    </div>
                    <h3 class="text-xl font-semibold darvag-text mb-3">ساخت مسکن برای خانواده‌های نیازمند</h3>
                    <p class="text-gray-600 mb-4">ساخت 10 واحد مسکونی برای خانواده‌های بی‌سرپناه در شهرستان سرخس</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>بودجه: 3 میلیارد تومان</span>
                        <span>جمع‌آوری شده: 1.8 میلیارد</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="bg-purple-100 h-48 flex items-center justify-center">
                    <i class="fas fa-medkit text-purple-600 text-4xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <span class="bg-purple-500 text-white text-xs px-3 py-1 rounded-full mr-2">در حال اجرا</span>
                        <span class="text-sm text-gray-500">40% تکمیل شده</span>
                    </div>
                    <h3 class="text-xl font-semibold darvag-text mb-3">تجهیز مرکز درمانی</h3>
                    <p class="text-gray-600 mb-4">تجهیز مرکز درمانی روستایی با امکانات پزشکی مدرن</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: 40%"></div>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>بودجه: 1.5 میلیارد تومان</span>
                        <span>جمع‌آوری شده: 600 میلیون</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Stories Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold darvag-text mb-4">داستان‌های موفقیت</h2>
            <p class="text-xl text-gray-600">تأثیر پویش نیکی بر زندگی افراد</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-start">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0">
                        <i class="fas fa-user-graduate text-green-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold darvag-text mb-2">احمد محمدی</h3>
                        <p class="text-gray-600 mb-4">دانش‌آموز بورسیه شده</p>
                        <p class="text-gray-600">
                            "با کمک پویش نیکی داروگ توانستم تحصیلاتم را ادامه دهم و الان دانشجوی رشته مهندسی هستم. 
                            این کمک نه تنها آینده من را تغییر داد، بلکه خانواده‌ام را نیز امیدوار کرد."
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-start">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0">
                        <i class="fas fa-home text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold darvag-text mb-2">خانواده احمدی</h3>
                        <p class="text-gray-600 mb-4">صاحب مسکن شده</p>
                        <p class="text-gray-600">
                            "بعد از سال‌ها زندگی در خانه اجاره‌ای، بالاخره صاحب خانه شدیم. 
                            پویش نیکی داروگ نه تنها خانه‌ای برای ما ساخت، بلکه امید و آرامش را به زندگی‌مان بازگرداند."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How to Help Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold darvag-text mb-4">چگونه می‌توانید کمک کنید؟</h2>
            <p class="text-xl text-gray-600">راه‌های مختلف مشارکت در پویش نیکی</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-donate text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-4">کمک مالی</h3>
                <p class="text-gray-600 mb-6">هر مبلغی که می‌توانید کمک کنید، در بهبود زندگی افراد مؤثر است</p>
                <a href="#" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    کمک مالی
                </a>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-hands-helping text-blue-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-4">کمک داوطلبانه</h3>
                <p class="text-gray-600 mb-6">با مشارکت در فعالیت‌های داوطلبانه به ما کمک کنید</p>
                <a href="#" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    ثبت نام داوطلب
                </a>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-share-alt text-purple-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-4">اشتراک‌گذاری</h3>
                <p class="text-gray-600 mb-6">پویش نیکی را با دوستان و آشنایان خود به اشتراک بگذارید</p>
                <a href="#" class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    اشتراک‌گذاری
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold darvag-text mb-4">برای مشارکت در پویش نیکی</h2>
        <p class="text-xl text-gray-600 mb-8">با ما تماس بگیرید و در امور خیریه مشارکت کنید</p>
        
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-semibold darvag-text mb-4">اطلاعات تماس</h3>
                    <div class="space-y-3 text-right">
                        <p><i class="fas fa-phone ml-2 text-green-600"></i> 09350801600</p>
                        <p><i class="fas fa-envelope ml-2 text-green-600"></i> charity@darvagco.ir</p>
                        <p><i class="fas fa-map-marker-alt ml-2 text-green-600"></i> خراسان رضوی - شهرستان سرخس</p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-xl font-semibold darvag-text mb-4">حساب بانکی</h3>
                    <div class="space-y-3 text-right">
                        <p><i class="fas fa-university ml-2 text-green-600"></i> بانک ملی</p>
                        <p><i class="fas fa-credit-card ml-2 text-green-600"></i> 1234567890123456</p>
                        <p><i class="fas fa-user ml-2 text-green-600"></i> کاخ‌سازان داروگ</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <a href="{{ route('contact') }}" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors ml-4">
                    <i class="fas fa-envelope ml-2"></i>
                    تماس با ما
                </a>
                <a href="tel:09350801600" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    <i class="fas fa-phone ml-2"></i>
                    تماس تلفنی
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
