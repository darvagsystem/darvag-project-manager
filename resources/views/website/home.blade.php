@extends('website.layout')

@section('title', 'کاخ‌سازان داروگ - داستان ساخت و ساز')
@section('description', 'کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient text-white py-20 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">داستان ساخت و ساز</h1>
            <h2 class="text-2xl md:text-3xl font-semibold mb-8">همراهی تخصصی از مشاوره تا اجرا!</h2>
            <p class="text-xl md:text-2xl mb-12 max-w-4xl mx-auto leading-relaxed">
                اجرای پروژه‌های صنعتی نیازمند تخصص و تجربه است. با بیش از دو دهه تجربه در زمینه اجرای پروژه‌های عمرانی و صنعتی، داروگ با استفاده از تجهیزات پیشرفته و متخصصان مجرب، پروژه‌های شما را با بالاترین کیفیت اجرا می‌کند.
            </p>
            <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center">
                <i class="fas fa-rocket ml-2"></i>
                شروع همکاری با داروگ
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 darvag-blue rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-2">گارانتی کیفیت اجرا</h3>
                <p class="text-gray-600">تضمین کیفیت در تمام مراحل اجرا</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 darvag-blue rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-2">تحویل به موقع پروژه</h3>
                <p class="text-gray-600">تعهد به زمان‌بندی دقیق پروژه‌ها</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 darvag-blue rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-tie text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-2">مشاوره تخصصی رایگان</h3>
                <p class="text-gray-600">مشاوره رایگان توسط متخصصان مجرب</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 darvag-blue rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trophy text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-2">بیش از ۸۵ پروژه موفق</h3>
                <p class="text-gray-600">سابقه درخشان در اجرای پروژه‌ها</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold darvag-text mb-4">خدمات ساخت و ساز داروگ</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg p-6 shadow-lg card-hover">
                <div class="w-12 h-12 darvag-light-blue rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-cogs text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-3">خدمات مهندسی</h3>
                <p class="text-gray-600">طراحی و مشاوره مهندسی برای پروژه‌های صنعتی و عمرانی</p>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-lg card-hover">
                <div class="w-12 h-12 darvag-light-blue rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-building text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-3">پروژه‌های عمرانی</h3>
                <p class="text-gray-600">اجرای پروژه‌های عمرانی با استانداردهای بین‌المللی</p>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-lg card-hover">
                <div class="w-12 h-12 darvag-light-blue rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-headset text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-3">پشتیبانی فنی</h3>
                <p class="text-gray-600">پشتیبانی فنی کامل پس از تحویل پروژه</p>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-lg card-hover">
                <div class="w-12 h-12 darvag-light-blue rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-industry text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-3">صنایع پیشرفته</h3>
                <p class="text-gray-600">تخصص در پروژه‌های صنعتی پیشرفته و پیچیده</p>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-lg card-hover">
                <div class="w-12 h-12 darvag-light-blue rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-hammer text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-3">ساخت و توسعه</h3>
                <p class="text-gray-600">ساخت و توسعه زیرساخت‌های صنعتی و عمرانی</p>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-lg card-hover">
                <div class="w-12 h-12 darvag-light-blue rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-lightbulb text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold darvag-text mb-3">مشاوره تخصصی</h3>
                <p class="text-gray-600">مشاوره تخصصی در تمام مراحل پروژه</p>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('services') }}" class="darvag-blue text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition-colors">
                مشاهده همه خدمات
            </a>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold darvag-text mb-6">درباره داروگ</h2>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی، با بهره‌گیری از تجهیزات پیشرفته و تیم متخصص، پروژه‌های بزرگ و پیچیده را با کیفیت و سرعت بالا اجرا می‌کند.
                </p>
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold darvag-text mb-2">20+</div>
                        <div class="text-gray-600">سال تجربه</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold darvag-text mb-2">85+</div>
                        <div class="text-gray-600">پروژه موفق</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold darvag-text mb-2">15+</div>
                        <div class="text-gray-600">استان تحت پوشش</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold darvag-text mb-2">100%</div>
                        <div class="text-gray-600">رضایت مشتری</div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-building text-gray-500 text-6xl mb-4"></i>
                    <p class="text-gray-600 text-lg">تصویر شرکت داروگ</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Projects Archive Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold darvag-text mb-4">آرشیو پروژه‌های داروگ</h2>
            <p class="text-xl text-gray-600">مجموعه پروژه‌های اجرا شده توسط شرکت مهندسی داروگ</p>
        </div>

        <!-- Project Filters -->
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <button class="darvag-blue text-white px-6 py-2 rounded-lg font-semibold">همه پروژه‌ها</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-colors">صنعتی</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-colors">ساختمانی</button>
            <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-colors">طراحی وب</button>
        </div>

        <!-- Featured Project -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="md:flex">
                <div class="md:w-1/2">
                    <div class="bg-gray-200 h-64 md:h-full flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-image text-gray-500 text-4xl mb-2"></i>
                            <p class="text-gray-600">تصویر پروژه</p>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 p-8">
                    <div class="flex items-center mb-4">
                        <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full mr-2">پروژه ویژه</span>
                        <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">ویژه</span>
                    </div>
                    <h3 class="text-2xl font-bold darvag-text mb-4">طراحی، ساخت و نصب حفاظ اطراف سلرهای منطقه خانگیران</h3>
                    <p class="text-gray-600 mb-4">طراحی ، ساخت و نصب حفاظ اطراف سلر های منطقه خانگیران</p>
                    <p class="text-sm text-gray-500 mb-4">KHangeran Gas Facility Safety Guards Installation Project</p>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span>تاریخ خرداد ۱۴۰۲</span>
                        <span>بازدید ۱,۲۵۰ بازدید</span>
                    </div>
                    <a href="#" class="darvag-blue text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition-colors">
                        مشاهده جزئیات
                    </a>
                </div>
            </div>
        </div>

        <!-- Other Projects -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="bg-gray-200 h-48 flex items-center justify-center">
                    <i class="fas fa-image text-gray-500 text-3xl"></i>
                </div>
                <div class="p-4">
                    <div class="text-sm text-gray-500 mb-2">دسته‌بندی ساخت ، نصب و رنگ آمیزی تابلوهای مشخصه چاهها و جاده های خانگیران</div>
                    <h4 class="font-semibold darvag-text mb-2">ساخت ، نصب و رنگ آمیزی تابلوهای مشخصه چاهها و جاده های خانگیران</h4>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>لایک ۱۱</span>
                        <span>نظر ۱</span>
                        <span>زمان مطالعه ۶ دقیقه</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="bg-gray-200 h-48 flex items-center justify-center">
                    <i class="fas fa-image text-gray-500 text-3xl"></i>
                </div>
                <div class="p-4">
                    <div class="text-sm text-gray-500 mb-2">دسته‌بندی طراحی سایت شرکتی</div>
                    <h4 class="font-semibold darvag-text mb-2">طراحی سایت شرکتی</h4>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>لایک ۱۱</span>
                        <span>نظر ۱</span>
                        <span>زمان مطالعه ۶ دقیقه</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                <div class="bg-gray-200 h-48 flex items-center justify-center">
                    <i class="fas fa-image text-gray-500 text-3xl"></i>
                </div>
                <div class="p-4">
                    <div class="text-sm text-gray-500 mb-2">دسته‌بندی توسعه عمرانی</div>
                    <h4 class="font-semibold darvag-text mb-2">توسعه عمرانی</h4>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>لایک ۱۱</span>
                        <span>نظر ۱</span>
                        <span>زمان مطالعه ۶ دقیقه</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('projects') }}" class="darvag-blue text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition-colors">
                مشاهده همه پروژه‌ها
            </a>
        </div>
    </div>
</section>

<!-- Experience Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold darvag-text mb-4">نگاهی به تجربه داروگ در سال‌های اخیر</h2>
            <p class="text-xl text-gray-600">مجموعه‌ای از فعالیت‌های داروگ در حوزه‌های مختلف صنعتی و مهندسی</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="text-center">
                <div class="text-4xl font-bold darvag-text mb-2">0</div>
                <div class="text-gray-600">عنوان یک</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold darvag-text mb-2">0</div>
                <div class="text-gray-600">عنوان دوم</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold darvag-text mb-2">0</div>
                <div class="text-gray-600">عنوان سه</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold darvag-text mb-2">0</div>
                <div class="text-gray-600">عنوان چهار</div>
            </div>
        </div>

        <div class="text-center">
            <a href="#" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors ml-4">
                کاتالوگ پروژه ها
            </a>
            <a href="#" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                کاتالوگ محصولات
            </a>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold darvag-text mb-4">همکاری با برندهای معتبر</h2>
            <p class="text-xl text-gray-600">افتخار همکاری با معتبرترین شرکت‌ها و سازمان‌های صنعتی کشور</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="bg-white rounded-lg p-6 text-center card-hover">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-building text-gray-500 text-2xl"></i>
                </div>
                <h3 class="font-semibold darvag-text mb-2">شرکت بهره برداری نفت و گاز شرق</h3>
                <p class="text-sm text-gray-600">توضیحات پیش‌فرض برای شرکت بهره برداری نفت و گاز شرق</p>
            </div>

            <div class="bg-white rounded-lg p-6 text-center card-hover">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-industry text-gray-500 text-2xl"></i>
                </div>
                <h3 class="font-semibold darvag-text mb-2">گروه مپنا</h3>
                <p class="text-sm text-gray-600">توضیحات پیش‌فرض برای گروه مپنا</p>
            </div>

            <div class="bg-white rounded-lg p-6 text-center card-hover">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-cogs text-gray-500 text-2xl"></i>
                </div>
                <h3 class="font-semibold darvag-text mb-2">شرکت کیسون</h3>
                <p class="text-sm text-gray-600">توضیحات پیش‌فرض برای شرکت کیسون</p>
            </div>

            <div class="bg-white rounded-lg p-6 text-center card-hover">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-gray-500 text-2xl"></i>
                </div>
                <h3 class="font-semibold darvag-text mb-2">سازمان تامین اجتماعی</h3>
                <p class="text-sm text-gray-600">توضیحات پیش‌فرض برای سازمان تامین اجتماعی</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 darvag-blue text-white">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">آماده شروع پروژه خود هستید؟</h2>
        <p class="text-xl mb-8">با تیم متخصص داروگ تماس بگیرید و از مشاوره رایگان بهره‌مند شوید</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:09350801600" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                <i class="fas fa-phone mr-2"></i>
                تماس تلفنی
            </a>
            <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                <i class="fas fa-envelope mr-2"></i>
                ارسال درخواست
            </a>
        </div>
    </div>
</section>
@endsection
