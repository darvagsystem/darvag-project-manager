@extends('website.layout')

@section('title', 'تماس با ما - شرکت کاخ‌سازان داروگ')
@section('description', 'تماس با شرکت کاخ‌سازان داروگ - اطلاعات تماس و فرم ارتباط با ما')

@section('content')
<!-- Page Header -->
<section class="bg-gray-900 text-white py-20 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">تماس با ما</h1>
        <p class="text-xl text-gray-300">آماده پاسخگویی به سوالات و درخواست‌های شما هستیم</p>
    </div>
</section>

<!-- Contact Info & Form -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-8">اطلاعات تماس</h2>
                
                <div class="space-y-6">
                    <!-- Address -->
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center ml-4 flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">آدرس دفتر مرکزی</h3>
                            <p class="text-gray-600">
                                تهران، خیابان ولیعصر، پلاک 123<br>
                                طبقه 4، واحد 12
                            </p>
                        </div>
                    </div>
                    
                    <!-- Phone -->
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center ml-4 flex-shrink-0">
                            <i class="fas fa-phone text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">تلفن تماس</h3>
                            <p class="text-gray-600">
                                <a href="tel:+982112345678" class="hover:text-blue-600">021-12345678</a><br>
                                <a href="tel:+989123456789" class="hover:text-blue-600">0912-345-6789</a>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center ml-4 flex-shrink-0">
                            <i class="fas fa-envelope text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">ایمیل</h3>
                            <p class="text-gray-600">
                                <a href="mailto:info@darvag.com" class="hover:text-blue-600">info@darvag.com</a><br>
                                <a href="mailto:support@darvag.com" class="hover:text-blue-600">support@darvag.com</a>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Working Hours -->
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center ml-4 flex-shrink-0">
                            <i class="fas fa-clock text-orange-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">ساعات کاری</h3>
                            <p class="text-gray-600">
                                شنبه تا چهارشنبه: 8:00 - 17:00<br>
                                پنج‌شنبه: 8:00 - 13:00<br>
                                جمعه: تعطیل
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">شبکه‌های اجتماعی</h3>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="#" class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink-600 text-white rounded-lg flex items-center justify-center hover:bg-pink-700 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-700 text-white rounded-lg flex items-center justify-center hover:bg-blue-800 transition-colors">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 text-white rounded-lg flex items-center justify-center hover:bg-gray-900 transition-colors">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-8">ارسال پیام</h2>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('contact.submit') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">نام و نام خانوادگی</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">شماره تماس</label>
                            <input type="tel" id="phone" name="phone" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">ایمیل</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">موضوع</label>
                        <select id="subject" name="subject" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">انتخاب کنید</option>
                            <option value="consultation">مشاوره پروژه</option>
                            <option value="quotation">درخواست پیش‌فاکتور</option>
                            <option value="support">پشتیبانی</option>
                            <option value="complaint">شکایت</option>
                            <option value="other">سایر</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">پیام</label>
                        <textarea id="message" name="message" rows="5" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="پیام خود را اینجا بنویسید..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        <i class="fas fa-paper-plane ml-2"></i>
                        ارسال پیام
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">موقعیت ما</h2>
            <p class="text-xl text-gray-600">دفتر مرکزی ما در مرکز تهران واقع شده است</p>
        </div>
        
        <!-- Map Placeholder -->
        <div class="bg-gray-300 rounded-lg h-96 flex items-center justify-center">
            <div class="text-center">
                <i class="fas fa-map-marked-alt text-gray-500 text-6xl mb-4"></i>
                <p class="text-gray-600 text-lg">نقشه گوگل در اینجا نمایش داده می‌شود</p>
                <p class="text-gray-500">تهران، خیابان ولیعصر، پلاک 123</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">سوالات متداول</h2>
            <p class="text-xl text-gray-600">پاسخ سوالات رایج مشتریان</p>
        </div>
        
        <div class="space-y-6">
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">چگونه می‌توانم از خدمات شما استفاده کنم؟</h3>
                <p class="text-gray-600">
                    برای استفاده از خدمات ما، می‌توانید از طریق فرم تماس با ما درخواست خود را ارسال کنید 
                    یا با شماره‌های تماس ما تماس بگیرید. تیم ما در اسرع وقت با شما تماس خواهد گرفت.
                </p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">آیا مشاوره رایگان ارائه می‌دهید؟</h3>
                <p class="text-gray-600">
                    بله، ما مشاوره رایگان برای تمام پروژه‌ها ارائه می‌دهیم. 
                    مهندسان متخصص ما آماده بررسی پروژه شما و ارائه راهنمایی هستند.
                </p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">مدت زمان تکمیل پروژه چقدر است؟</h3>
                <p class="text-gray-600">
                    مدت زمان تکمیل پروژه بستگی به نوع و اندازه پروژه دارد. 
                    معمولاً پروژه‌های کوچک 3-6 ماه و پروژه‌های بزرگ 1-3 سال طول می‌کشد.
                </p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">آیا گارانتی ارائه می‌دهید؟</h3>
                <p class="text-gray-600">
                    بله، ما برای تمام پروژه‌های خود گارانتی کیفیت و خدمات پس از تحویل ارائه می‌دهیم. 
                    مدت گارانتی بستگی به نوع پروژه دارد.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-blue-600 text-white">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-4">آماده شروع پروژه خود هستید؟</h2>
        <p class="text-xl mb-8">با تیم متخصص ما تماس بگیرید و از مشاوره رایگان بهره‌مند شوید</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:+982112345678" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                <i class="fas fa-phone mr-2"></i>
                تماس تلفنی
            </a>
            <a href="mailto:info@darvag.com" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                <i class="fas fa-envelope mr-2"></i>
                ارسال ایمیل
            </a>
        </div>
    </div>
</section>
@endsection
