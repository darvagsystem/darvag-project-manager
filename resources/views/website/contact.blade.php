@extends('website.layout')

@section('title', 'تماس با ما - شرکت کاخ‌سازان داروگ')
@section('description', 'تماس با شرکت کاخ‌سازان داروگ - اطلاعات تماس و فرم ارتباط با ما')

@section('content')
<!-- Page Header -->
<section class="contact-header" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #8b5cf6 100%); padding: 120px 0 80px; margin-top: 80px; position: relative; overflow: hidden;">
    <!-- Animated background elements -->
    <div class="floating-elements">
        <div class="floating-circle" style="position: absolute; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; top: 10%; left: 10%; animation: float 6s ease-in-out infinite;"></div>
        <div class="floating-circle" style="position: absolute; width: 150px; height: 150px; background: rgba(255,255,255,0.08); border-radius: 50%; top: 60%; right: 15%; animation: float 8s ease-in-out infinite reverse;"></div>
        <div class="floating-circle" style="position: absolute; width: 100px; height: 100px; background: rgba(255,255,255,0.06); border-radius: 50%; top: 30%; right: 30%; animation: float 10s ease-in-out infinite;"></div>
    </div>

    <div class="container position-relative">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <div class="header-content" style="animation: slideInDown 1s ease-out;">
                    <h1 class="display-3 fw-bold text-white mb-4" style="font-family: 'Vazirmatn', sans-serif; text-shadow: 0 4px 8px rgba(0,0,0,0.3);">
                        تماس با ما
                        <span class="highlight-text" style="background: linear-gradient(45deg, #fbbf24, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">داروگ</span>
                    </h1>
                    <p class="lead text-white-50 mb-4" style="font-size: 1.25rem; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">آماده پاسخگویی به سوالات و درخواست‌های شما هستیم</p>
                    <div class="header-stats d-flex justify-content-center gap-4 flex-wrap">
                        <div class="stat-item text-center">
                            <div class="stat-number text-white fw-bold" style="font-size: 2rem; font-family: 'Vazirmatn', sans-serif;">20+</div>
                            <div class="stat-label text-white-50 small">سال تجربه</div>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-number text-white fw-bold" style="font-size: 2rem; font-family: 'Vazirmatn', sans-serif;">500+</div>
                            <div class="stat-label text-white-50 small">پروژه موفق</div>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-number text-white fw-bold" style="font-size: 2rem; font-family: 'Vazirmatn', sans-serif;">24/7</div>
                            <div class="stat-label text-white-50 small">پشتیبانی</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Decorative wave -->
    <div class="wave-bottom"></div>
</section>

<!-- Contact Info & Form -->
<section class="py-5" style="background: #f8fafc;">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Information -->
            <div class="col-lg-6">
                <div class="contact-info-card" style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); height: 100%;">
                    <h2 class="h2 fw-bold text-dark mb-4" style="font-family: 'Vazirmatn', sans-serif; color: #1e3a8a;">اطلاعات تماس</h2>

                    <div class="contact-items">
                        <!-- Address -->
                        <div class="contact-item d-flex align-items-start mb-4">
                            <div class="contact-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-map-marker-alt text-white fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-2" style="font-family: 'Vazirmatn', sans-serif;">آدرس دفتر مرکزی</h5>
                                <p class="text-muted mb-0">
                                    تهران، خیابان ولیعصر، پلاک 123<br>
                                    طبقه 4، واحد 12
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="contact-item d-flex align-items-start mb-4">
                            <div class="contact-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-phone text-white fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-2" style="font-family: 'Vazirmatn', sans-serif;">تلفن تماس</h5>
                                <p class="text-muted mb-0">
                                    <a href="tel:+982112345678" class="text-decoration-none" style="color: #3b82f6;">021-12345678</a><br>
                                    <a href="tel:+989123456789" class="text-decoration-none" style="color: #3b82f6;">0912-345-6789</a>
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="contact-item d-flex align-items-start mb-4">
                            <div class="contact-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-envelope text-white fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-2" style="font-family: 'Vazirmatn', sans-serif;">ایمیل</h5>
                                <p class="text-muted mb-0">
                                    <a href="mailto:info@darvag.com" class="text-decoration-none" style="color: #3b82f6;">info@darvag.com</a><br>
                                    <a href="mailto:support@darvag.com" class="text-decoration-none" style="color: #3b82f6;">support@darvag.com</a>
                                </p>
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="contact-item d-flex align-items-start mb-4">
                            <div class="contact-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-clock text-white fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-2" style="font-family: 'Vazirmatn', sans-serif;">ساعات کاری</h5>
                                <p class="text-muted mb-0">
                                    شنبه تا چهارشنبه: 8:00 - 17:00<br>
                                    پنج‌شنبه: 8:00 - 13:00<br>
                                    جمعه: تعطیل
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-4">
                        <h5 class="fw-bold text-dark mb-3" style="font-family: 'Vazirmatn', sans-serif;">شبکه‌های اجتماعی</h5>
                        <div class="d-flex gap-3">
                            <a href="#" class="social-link" style="width: 45px; height: 45px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s ease;">
                                <i class="fab fa-telegram text-white"></i>
                            </a>
                            <a href="#" class="social-link" style="width: 45px; height: 45px; background: linear-gradient(135deg, #ec4899, #be185d); border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s ease;">
                                <i class="fab fa-instagram text-white"></i>
                            </a>
                            <a href="#" class="social-link" style="width: 45px; height: 45px; background: linear-gradient(135deg, #0ea5e9, #0284c7); border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s ease;">
                                <i class="fab fa-linkedin text-white"></i>
                            </a>
                            <a href="#" class="social-link" style="width: 45px; height: 45px; background: linear-gradient(135deg, #374151, #111827); border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s ease;">
                                <i class="fab fa-github text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-6">
                <div class="contact-form-card" style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); height: 100%;">
                    <h2 class="h2 fw-bold text-dark mb-4" style="font-family: 'Vazirmatn', sans-serif; color: #1e3a8a;">ارسال پیام</h2>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" class="contact-form" id="contactForm">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        نام و نام خانوادگی <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" required
                                           class="form-control form-control-lg modern-input"
                                           placeholder="نام و نام خانوادگی خود را وارد کنید">
                                    <div class="invalid-feedback" id="nameError"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        شماره تماس <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" id="phone" name="phone" required
                                           class="form-control form-control-lg modern-input"
                                           placeholder="شماره تماس خود را وارد کنید">
                                    <div class="invalid-feedback" id="phoneError"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="email" class="form-label fw-bold text-dark mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                ایمیل <span class="text-danger">*</span>
                            </label>
                            <input type="email" id="email" name="email" required
                                   class="form-control form-control-lg modern-input"
                                   placeholder="آدرس ایمیل خود را وارد کنید">
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="subject" class="form-label fw-bold text-dark mb-2">
                                <i class="fas fa-tag text-primary me-2"></i>
                                موضوع <span class="text-danger">*</span>
                            </label>
                            <select id="subject" name="subject" required
                                    class="form-select form-select-lg modern-input">
                                <option value="">انتخاب کنید</option>
                                <option value="consultation">مشاوره پروژه</option>
                                <option value="quotation">درخواست پیش‌فاکتور</option>
                                <option value="support">پشتیبانی</option>
                                <option value="complaint">شکایت</option>
                                <option value="other">سایر</option>
                            </select>
                            <div class="invalid-feedback" id="subjectError"></div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="message" class="form-label fw-bold text-dark mb-2">
                                <i class="fas fa-comment text-primary me-2"></i>
                                پیام <span class="text-danger">*</span>
                            </label>
                            <textarea id="message" name="message" rows="5" required
                                      class="form-control modern-input"
                                      placeholder="پیام خود را اینجا بنویسید..."></textarea>
                            <div class="invalid-feedback" id="messageError"></div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100 position-relative modern-btn"
                                    id="submitBtn">
                                <span class="btn-text">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    ارسال پیام
                                </span>
                                <span class="btn-loading d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    در حال ارسال...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h2 fw-bold text-dark mb-3" style="font-family: 'Vazirmatn', sans-serif; color: #1e3a8a;">موقعیت ما</h2>
            <p class="lead text-muted">دفتر مرکزی ما در مرکز تهران واقع شده است</p>
        </div>

        <!-- Map Placeholder -->
        <div class="map-container" style="background: white; border-radius: 20px; height: 400px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden;">
            <div class="text-center p-5">
                <div class="map-icon mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                    <i class="fas fa-map-marked-alt text-white" style="font-size: 2rem;"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2" style="font-family: 'Vazirmatn', sans-serif;">نقشه گوگل</h4>
                <p class="text-muted mb-2">نقشه گوگل در اینجا نمایش داده می‌شود</p>
                <p class="text-muted small">تهران، خیابان ولیعصر، پلاک 123</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h2 fw-bold text-dark mb-3" style="font-family: 'Vazirmatn', sans-serif; color: #1e3a8a;">سوالات متداول</h2>
            <p class="lead text-muted">پاسخ سوالات رایج مشتریان</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="faq-item" style="background: #f8fafc; border-radius: 15px; padding: 25px; height: 100%; border: 1px solid #e2e8f0; transition: all 0.3s ease;">
                    <h5 class="fw-bold text-dark mb-3" style="font-family: 'Vazirmatn', sans-serif; color: #1e3a8a;">چگونه می‌توانم از خدمات شما استفاده کنم؟</h5>
                    <p class="text-muted mb-0">
                        برای استفاده از خدمات ما، می‌توانید از طریق فرم تماس با ما درخواست خود را ارسال کنید
                        یا با شماره‌های تماس ما تماس بگیرید. تیم ما در اسرع وقت با شما تماس خواهد گرفت.
                    </p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="faq-item" style="background: #f8fafc; border-radius: 15px; padding: 25px; height: 100%; border: 1px solid #e2e8f0; transition: all 0.3s ease;">
                    <h5 class="fw-bold text-dark mb-3" style="font-family: 'Vazirmatn', sans-serif; color: #1e3a8a;">آیا مشاوره رایگان ارائه می‌دهید؟</h5>
                    <p class="text-muted mb-0">
                        بله، ما مشاوره رایگان برای تمام پروژه‌ها ارائه می‌دهیم.
                        مهندسان متخصص ما آماده بررسی پروژه شما و ارائه راهنمایی هستند.
                    </p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="faq-item" style="background: #f8fafc; border-radius: 15px; padding: 25px; height: 100%; border: 1px solid #e2e8f0; transition: all 0.3s ease;">
                    <h5 class="fw-bold text-dark mb-3" style="font-family: 'Vazirmatn', sans-serif; color: #1e3a8a;">مدت زمان تکمیل پروژه چقدر است؟</h5>
                    <p class="text-muted mb-0">
                        مدت زمان تکمیل پروژه بستگی به نوع و اندازه پروژه دارد.
                        معمولاً پروژه‌های کوچک 3-6 ماه و پروژه‌های بزرگ 1-3 سال طول می‌کشد.
                    </p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="faq-item" style="background: #f8fafc; border-radius: 15px; padding: 25px; height: 100%; border: 1px solid #e2e8f0; transition: all 0.3s ease;">
                    <h5 class="fw-bold text-dark mb-3" style="font-family: 'Vazirmatn', sans-serif; color: #1e3a8a;">آیا گارانتی ارائه می‌دهید؟</h5>
                    <p class="text-muted mb-0">
                        بله، ما برای تمام پروژه‌های خود گارانتی کیفیت و خدمات پس از تحویل ارائه می‌دهیم.
                        مدت گارانتی بستگی به نوع پروژه دارد.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); position: relative; overflow: hidden;">
    <!-- Decorative elements -->
    <div class="cta-pattern"></div>

    <div class="container position-relative">
        <div class="text-center">
            <h2 class="h1 fw-bold text-white mb-4" style="font-family: 'Vazirmatn', sans-serif;">آماده شروع پروژه خود هستید؟</h2>
            <p class="lead text-white-50 mb-5">با تیم متخصص ما تماس بگیرید و از مشاوره رایگان بهره‌مند شوید</p>
            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                <a href="tel:+982112345678" class="btn btn-light btn-lg px-5 py-3"
                   style="border-radius: 15px; font-family: 'Vazirmatn', sans-serif; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(255,255,255,0.2);">
                    <i class="fas fa-phone me-2"></i>
                    تماس تلفنی
                </a>
                <a href="mailto:info@darvag.com" class="btn btn-outline-light btn-lg px-5 py-3"
                   style="border-radius: 15px; font-family: 'Vazirmatn', sans-serif; font-weight: 600; transition: all 0.3s ease; border-width: 2px;">
                    <i class="fas fa-envelope me-2"></i>
                    ارسال ایمیل
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Contact Page Custom Styles */
.contact-header {
    position: relative;
    overflow: hidden;
}

.wave-bottom {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 60px;
    background: linear-gradient(180deg, transparent 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.3) 100%);
}

.cta-pattern {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.1) 1px, transparent 1px),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.08) 1px, transparent 1px),
                radial-gradient(circle at 40% 60%, rgba(255,255,255,0.06) 1px, transparent 1px);
    background-size: 20px 20px, 30px 30px, 25px 25px;
}

.contact-info-card:hover,
.contact-form-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
    transition: all 0.3s ease;
}

.contact-item:hover .contact-icon {
    transform: scale(1.1);
    transition: all 0.3s ease;
}

.social-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.faq-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: #3b82f6 !important;
}

/* Removed old form styles - using modern-input class instead */

/* Floating animations */
@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.1;
    }
    50% {
        transform: translateY(-20px) rotate(5deg);
        opacity: 0.2;
    }
}

.floating-circle {
    transition: all 0.3s ease;
}

.floating-circle:hover {
    transform: scale(1.1);
    opacity: 0.3 !important;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Form validation and loading styles moved to modern form section */

/* Responsive adjustments */
@media (max-width: 768px) {
    .contact-header {
        padding: 80px 0 60px !important;
        margin-top: 70px !important;
    }

    .contact-info-card,
    .contact-form-card {
        padding: 25px !important;
    }

    .map-container {
        height: 300px !important;
    }

    .header-stats {
        gap: 2rem !important;
    }

    .stat-number {
        font-size: 1.5rem !important;
    }
}

/* Animation for page load */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.contact-info-card,
.contact-form-card,
.faq-item {
    animation: fadeInUp 0.6s ease-out;
}

.contact-form-card {
    animation-delay: 0.2s;
}

.faq-item:nth-child(1) { animation-delay: 0.1s; }
.faq-item:nth-child(2) { animation-delay: 0.2s; }
.faq-item:nth-child(3) { animation-delay: 0.3s; }
.faq-item:nth-child(4) { animation-delay: 0.4s; }

/* Modern Form Styles */
.modern-input {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 15px 20px;
    font-family: 'Vazirmatn', sans-serif;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #ffffff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.modern-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    background: #f8fafc;
    transform: translateY(-2px);
}

.modern-input:hover {
    border-color: #9ca3af;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.modern-btn {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    border: none;
    border-radius: 12px;
    padding: 15px 30px;
    font-family: 'Vazirmatn', sans-serif;
    font-weight: 600;
    font-size: 18px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    overflow: hidden;
    position: relative;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

.modern-btn:active {
    transform: translateY(0);
}

.form-group {
    position: relative;
    animation: slideInUp 0.6s ease-out;
}

.form-group:nth-child(1) { animation-delay: 0.1s; }
.form-group:nth-child(2) { animation-delay: 0.2s; }
.form-group:nth-child(3) { animation-delay: 0.3s; }
.form-group:nth-child(4) { animation-delay: 0.4s; }
.form-group:nth-child(5) { animation-delay: 0.5s; }

.form-group label {
    font-family: 'Vazirmatn', sans-serif;
    font-size: 16px;
    margin-bottom: 8px;
    display: block;
    transition: color 0.3s ease;
}

.form-group label:hover {
    color: #3b82f6;
}

.form-group .text-danger {
    color: #dc2626 !important;
    font-weight: 600;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Loading button animation */
.btn-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Form validation styles */
.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

.is-valid {
    border-color: #198754 !important;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25) !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');

    // Form validation
    function validateField(field, errorElementId) {
        const value = field.value.trim();
        const errorElement = document.getElementById(errorElementId);
        let isValid = true;
        let errorMessage = '';

        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'این فیلد الزامی است';
        } else if (field.type === 'email' && value && !isValidEmail(value)) {
            isValid = false;
            errorMessage = 'لطفاً یک ایمیل معتبر وارد کنید';
        } else if (field.type === 'tel' && value && !isValidPhone(value)) {
            isValid = false;
            errorMessage = 'لطفاً یک شماره تلفن معتبر وارد کنید';
        }

        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            errorElement.textContent = '';
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            errorElement.textContent = errorMessage;
        }

        return isValid;
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidPhone(phone) {
        const phoneRegex = /^[\d\s\-\+\(\)]+$/;
        return phoneRegex.test(phone) && phone.replace(/\D/g, '').length >= 10;
    }

    // Real-time validation
    const fields = ['name', 'phone', 'email', 'subject', 'message'];
    fields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field) {
            field.addEventListener('blur', () => {
                validateField(field, fieldName + 'Error');
            });

            field.addEventListener('input', () => {
                if (field.classList.contains('is-invalid')) {
                    validateField(field, fieldName + 'Error');
                }
            });
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate all fields
        let isFormValid = true;
        fields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field && !validateField(field, fieldName + 'Error')) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            // Scroll to first invalid field
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');

        // Submit form
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token')
            }
        })
        .then(response => {
            if (response.ok) {
                // Show success message
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success alert-dismissible fade show mb-4';
                successAlert.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>
                    پیام شما با موفقیت ارسال شد
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

                form.insertBefore(successAlert, form.firstChild);

                // Reset form
                form.reset();
                fields.forEach(fieldName => {
                    const field = document.getElementById(fieldName);
                    if (field) {
                        field.classList.remove('is-valid', 'is-invalid');
                    }
                });

                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                throw new Error('خطا در ارسال پیام');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('خطا در ارسال پیام. لطفاً دوباره تلاش کنید.');
        })
        .finally(() => {
            // Hide loading state
            submitBtn.disabled = false;
            btnText.classList.remove('d-none');
            btnLoading.classList.add('d-none');
        });
    });

    // Animate stats on scroll
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumbers = entry.target.querySelectorAll('.stat-number');
                statNumbers.forEach(stat => {
                    const finalNumber = stat.textContent;
                    const isNumeric = /^\d+/.test(finalNumber);

                    if (isNumeric) {
                        const targetNumber = parseInt(finalNumber);
                        let currentNumber = 0;
                        const increment = targetNumber / 50;

                        const timer = setInterval(() => {
                            currentNumber += increment;
                            if (currentNumber >= targetNumber) {
                                stat.textContent = finalNumber;
                                clearInterval(timer);
                            } else {
                                stat.textContent = Math.floor(currentNumber) + '+';
                            }
                        }, 30);
                    }
                });
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const statsSection = document.querySelector('.header-stats');
    if (statsSection) {
        observer.observe(statsSection);
    }
});
</script>
@endpush
