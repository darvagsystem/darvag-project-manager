@extends('website.layout')

@section('title', 'کاخ‌سازان داروگ - داستان ساخت و ساز')
@section('description', 'کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-gradient-line"></div>
    <div class="hero-decorative-circle hero-orange-glow"></div>
    <div class="hero-decorative-circle hero-blue-glow"></div>

    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <span class="hero-title-main">گروه صنعتی داروگ</span>
                        <span class="hero-title-sub">پیشرو در صنعت عمران</span>
                    </h1>
                    <p class="hero-description">
                        کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی، با بهره‌گیری از تجهیزات پیشرفته و تیم متخصص، پروژه‌های بزرگ و پیچیده را با کیفیت و سرعت بالا اجرا می‌کند.
                    </p>
                    <div class="hero-buttons">
                        <a href="{{ route('contact') }}" class="btn btn-primary-custom">
                            <span>تماس با ما</span>
                            <i class="bi bi-telephone"></i>
                        </a>
                        <a href="{{ route('projects') }}" class="btn btn-outline-custom">
                            <span>مشاهده پروژه‌ها</span>
                            <i class="bi bi-arrow-left"></i>
                        </a>

                        @auth
                            <!-- User is logged in - Show admin panel link -->
                            <a href="{{ route('panel.dashboard') }}" class="btn btn-success-custom">
                                <span>پنل مدیریت</span>
                                <i class="bi bi-gear"></i>
                            </a>
                        @else
                            <!-- User is not logged in - Show login link -->
                            <a href="{{ route('login') }}" class="btn btn-warning-custom">
                                <span>ورود</span>
                                <i class="bi bi-box-arrow-in-right"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="{{ asset('assets/images/1.webp') }}" alt="داروگ" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

@auth
<!-- User Dashboard Section -->
<section class="user-dashboard-section py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="user-welcome-card" style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="user-info">
                                <h3 class="mb-2" style="color: #1e3a8a; font-family: 'Vazirmatn', sans-serif;">
                                    <i class="fas fa-user-circle me-2"></i>
                                    خوش آمدید، {{ Auth::user()->name ?? 'کاربر عزیز' }}!
                                </h3>
                                <p class="text-muted mb-3">به پنل مدیریت پروژه‌های داروگ خوش آمدید. از اینجا می‌توانید تمام فعالیت‌های خود را مدیریت کنید.</p>

                                <div class="quick-stats row g-3">
                                    <div class="col-sm-4">
                                        <div class="stat-item text-center">
                                            <div class="stat-number text-primary fw-bold">{{ \App\Models\Project::count() }}</div>
                                            <div class="stat-label text-muted small">پروژه‌ها</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="stat-item text-center">
                                            <div class="stat-number text-success fw-bold">{{ \App\Models\ContactMessage::new()->count() }}</div>
                                            <div class="stat-label text-muted small">پیام‌های جدید</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="stat-item text-center">
                                            <div class="stat-number text-warning fw-bold">{{ \App\Models\Employee::count() }}</div>
                                            <div class="stat-label text-muted small">پرسنل</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="quick-actions">
                                <h5 class="mb-3" style="color: #1e3a8a; font-family: 'Vazirmatn', sans-serif;">دسترسی سریع</h5>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('panel.dashboard') }}" class="btn btn-primary">
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        داشبورد
                                    </a>
                                    <a href="{{ route('panel.projects.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-project-diagram me-2"></i>
                                        مدیریت پروژه‌ها
                                    </a>
                                    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-success">
                                        <i class="fas fa-envelope me-2"></i>
                                        پیام‌های تماس
                                        @if(\App\Models\ContactMessage::new()->count() > 0)
                                            <span class="badge bg-danger ms-1">{{ \App\Models\ContactMessage::new()->count() }}</span>
                                        @endif
                                    </a>
                                    <a href="{{ route('panel.employees.index') }}" class="btn btn-outline-info">
                                        <i class="fas fa-users me-2"></i>
                                        مدیریت پرسنل
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endauth

<!-- About Section -->
<section class="about-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <span class="title-accent">درباره داروگ</span>
                <span class="title-underline"></span>
            </h2>
            <p class="section-description">
                کارخانه کاخ سازان داروگ در سال ۱۳۵۳ با هدف تولید محصولات ساختمانی تأسیس شده است و بیش از دو دهه است که داروگ با تمرکز بر طراحی، تدارک و تولید ساختمان‌های پیش ساخته، اجرای کمپ‌ و تجهیز کارگاه پروژه‌های بزرگ عمرانی فعالیت می‌کند.
            </p>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h4>ساخت و ساز</h4>
                    <p>طراحی و اجرای پروژه‌های عمرانی بزرگ</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <h4>تجهیزات پیشرفته</h4>
                    <p>استفاده از آخرین تکنولوژی‌های روز</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4>تیم متخصص</h4>
                    <p>کارشناسان مجرب و با تجربه</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h4>کیفیت بالا</h4>
                    <p>تضمین کیفیت و رضایت مشتری</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section class="projects-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <span class="title-accent">پروژه‌های شاخص</span>
                <span class="title-underline"></span>
            </h2>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="https://vima-ir.com/wp-content/uploads/2023/11/Banner-Shorijeh-camp-jpg.webp" alt="کمپ اقامتی پردیس آذر">
                        <div class="project-overlay">
                            <a href="#" class="btn btn-light">مشاهده جزئیات</a>
                        </div>
                    </div>
                    <div class="project-content">
                        <h4>کمپ اقامتی پردیس آذر</h4>
                        <p>طراحی، تأمین و ساخت تجهیزات کمپ پروژه شوریجه</p>
                        <div class="project-meta">
                            <span><i class="bi bi-geo-alt"></i> خراسان رضوی، سرخس</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="https://vima-ir.com/wp-content/uploads/2023/12/pic-no-201-copy-2048x852.webp" alt="پروژه پتروشیمی بوشهر">
                        <div class="project-overlay">
                            <a href="#" class="btn btn-light">مشاهده جزئیات</a>
                        </div>
                    </div>
                    <div class="project-content">
                        <h4>پروژه پتروشیمی بوشهر</h4>
                        <p>طراحی و اجرای کمپ اقامتی کارکنان</p>
                        <div class="project-meta">
                            <span><i class="bi bi-geo-alt"></i> عسلویه، بوشهر</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-image">
                        <img src="https://vima-ir.com/wp-content/uploads/2023/11/Tabnak-project-1-jpg.webp" alt="پروژه مسکونی تابناک">
                        <div class="project-overlay">
                            <a href="#" class="btn btn-light">مشاهده جزئیات</a>
                        </div>
                    </div>
                    <div class="project-content">
                        <h4>پروژه مسکونی تابناک</h4>
                        <p>تأمین و تجهیز واحدهای مسکونی</p>
                        <div class="project-meta">
                            <span><i class="bi bi-geo-alt"></i> تهران، ایران</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('projects') }}" class="btn btn-primary-custom">
                <span>مشاهده همه پروژه‌ها</span>
                <i class="bi bi-arrow-left"></i>
            </a>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <span class="title-accent">خدمات ما</span>
                <span class="title-underline"></span>
            </h2>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-house"></i>
                    </div>
                    <h4>ساخت و ساز</h4>
                    <p>طراحی و اجرای پروژه‌های عمرانی با کیفیت بالا</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-tools"></i>
                    </div>
                    <h4>محوطه‌سازی</h4>
                    <p>طراحی و اجرای محوطه‌های زیبا و کاربردی</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-road"></i>
                    </div>
                    <h4>جاده‌سازی</h4>
                    <p>ساخت و تعمیر جاده‌ها و راه‌های ارتباطی</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="stat-number">70+</div>
                    <div class="stat-label">پروژه انجام شده</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-number">25+</div>
                    <div class="stat-label">سال تجربه</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <div class="stat-number">100%</div>
                    <div class="stat-label">رضایت مشتری</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div class="stat-number">15+</div>
                    <div class="stat-label">شهر</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Projects Distribution Map Section -->
<section class="map-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <span class="title-accent">نقشه پراکندگی پروژه‌های داروگ</span>
                <span class="title-underline"></span>
            </h2>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="map-container">
                    <div class="map-wrapper">
                        <img src="https://darvag-1.s3.ir-thr-at1.arvanstorage.ir/settings/iran_map_67b8447c7a1bc_341419.png" alt="نقشه ایران" class="map-image">

                        <!-- Project markers -->
                        <div class="project-marker" style="top: 25%; left: 45%;" data-project="تهران">
                            <div class="marker-dot"></div>
                            <div class="marker-label">تهران</div>
                        </div>

                        <div class="project-marker" style="top: 30%; left: 40%;" data-project="اصفهان">
                            <div class="marker-dot"></div>
                            <div class="marker-label">اصفهان</div>
                        </div>

                        <div class="project-marker" style="top: 35%; left: 35%;" data-project="شیراز">
                            <div class="marker-dot"></div>
                            <div class="marker-label">شیراز</div>
                        </div>

                        <div class="project-marker" style="top: 40%; left: 50%;" data-project="مشهد">
                            <div class="marker-dot"></div>
                            <div class="marker-label">مشهد</div>
                        </div>

                        <div class="project-marker" style="top: 45%; left: 25%;" data-project="بوشهر">
                            <div class="marker-dot"></div>
                            <div class="marker-label">بوشهر</div>
                        </div>

                        <div class="project-marker" style="top: 50%; left: 30%;" data-project="اهواز">
                            <div class="marker-dot"></div>
                            <div class="marker-label">اهواز</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="map-stats">
                    <h4>آمار پروژه‌ها</h4>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">70+</div>
                            <div class="stat-label">پروژه انجام شده</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">25+</div>
                            <div class="stat-label">استان</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">15+</div>
                            <div class="stat-label">شهر</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">100%</div>
                            <div class="stat-label">رضایت مشتری</div>
                        </div>
                    </div>

                    <div class="project-list">
                        <h5>پروژه‌های شاخص</h5>
                        <ul>
                            <li>پروژه پتروشیمی بوشهر</li>
                            <li>کمپ اقامتی پردیس آذر</li>
                            <li>پروژه مسکونی تابناک</li>
                            <li>مرکز نوآوری هُما</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="contact-cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>آماده شروع پروژه بعدی خود هستید؟</h2>
            <p>با تیم متخصص ما تماس بگیرید و از مشاوره رایگان بهره‌مند شوید</p>
            <div class="cta-buttons">
                <a href="{{ route('contact') }}" class="btn btn-primary-custom">
                    <span>تماس با ما</span>
                    <i class="bi bi-telephone"></i>
                </a>
                <a href="tel:09350801600" class="btn btn-outline-custom">
                    <span>09350801600</span>
                    <i class="bi bi-phone"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
/* Global Styles */
:root {
    --primary-color: #ff6b00;
    --secondary-color: #0077ff;
    --accent-color: #ffd700;
    --text-dark: #333;
    --text-light: #666;
    --bg-light: #f0f2f5;
    --white: #ffffff;
    --shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #f0f2f5 0%, #e8ecf0 100%);
    padding: 100px 0;
    position: relative;
    overflow: hidden;
}

.hero-gradient-line {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #ff6b00, #0077ff, #ff6b00);
}

.hero-decorative-circle {
    position: absolute;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    opacity: 0.1;
}

.hero-orange-glow {
    background: radial-gradient(circle, rgba(255, 107, 0, 0.05), transparent 70%);
    top: 20px;
    right: 10%;
}

.hero-blue-glow {
    background: radial-gradient(circle, rgba(0, 119, 255, 0.05), transparent 70%);
    bottom: 20px;
    left: 10%;
}

.hero-content {
    padding: 40px 0;
}

.hero-title {
    margin-bottom: 30px;
}

.hero-title-main {
    display: block;
    font-size: 3rem;
    font-weight: bold;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.hero-title-sub {
    display: block;
    font-size: 1.5rem;
    color: var(--primary-color);
    font-weight: 600;
}

.hero-description {
    font-size: 1.1rem;
    color: var(--text-light);
    line-height: 1.8;
    margin-bottom: 40px;
    text-align: justify;
}

.hero-buttons {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.hero-image {
    text-align: center;
}

.hero-image img {
    border-radius: 15px;
    box-shadow: var(--shadow);
}

/* Buttons */
.btn-primary-custom {
    background: linear-gradient(135deg, var(--primary-color), #ff8c00);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 0, 0.4);
    color: white;
}

.btn-outline-custom {
    background: transparent;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    padding: 10px 30px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.btn-outline-custom:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

/* Section Headers */
.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-title {
    position: relative;
    display: inline-block;
    margin-bottom: 20px;
}

.title-accent {
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--text-dark);
    position: relative;
}

.title-underline {
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    border-radius: 2px;
}

.section-description {
    font-size: 1.1rem;
    color: var(--text-light);
    line-height: 1.8;
    max-width: 800px;
    margin: 0 auto;
}

/* About Section */
.about-section {
    padding: 100px 0;
    background: var(--white);
}

.feature-card {
    background: var(--white);
    padding: 40px 30px;
    border-radius: 15px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), #ff8c00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
    font-size: 2rem;
}

.feature-card h4 {
    font-size: 1.3rem;
    font-weight: bold;
    color: var(--text-dark);
    margin-bottom: 15px;
}

.feature-card p {
    color: var(--text-light);
    line-height: 1.6;
}

/* Projects Section */
.projects-section {
    padding: 100px 0;
    background: var(--bg-light);
}

.project-card {
    background: var(--white);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    height: 100%;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.project-image {
    position: relative;
    overflow: hidden;
    height: 250px;
}

.project-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.project-card:hover .project-image img {
    transform: scale(1.05);
}

.project-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.project-card:hover .project-overlay {
    opacity: 1;
}

.project-content {
    padding: 30px;
}

.project-content h4 {
    font-size: 1.3rem;
    font-weight: bold;
    color: var(--text-dark);
    margin-bottom: 15px;
}

.project-content p {
    color: var(--text-light);
    line-height: 1.6;
    margin-bottom: 15px;
}

.project-meta {
    color: var(--primary-color);
    font-weight: 500;
}

.project-meta i {
    margin-left: 5px;
}

/* Services Section */
.services-section {
    padding: 100px 0;
    background: var(--white);
}

.service-card {
    background: var(--white);
    padding: 40px 30px;
    border-radius: 15px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    height: 100%;
    border: 2px solid transparent;
}

.service-card:hover {
    transform: translateY(-5px);
    border-color: var(--primary-color);
    box-shadow: 0 8px 25px rgba(255, 107, 0, 0.2);
}

.service-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--secondary-color), #00a0ff);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
    font-size: 2rem;
}

.service-card h4 {
    font-size: 1.3rem;
    font-weight: bold;
    color: var(--text-dark);
    margin-bottom: 15px;
}

.service-card p {
    color: var(--text-light);
    line-height: 1.6;
}

/* Statistics Section */
.stats-section {
    padding: 100px 0;
    background: linear-gradient(135deg, var(--primary-color), #ff8c00);
    color: white;
}

.stat-card {
    text-align: center;
    padding: 40px 20px;
    background: rgba(255,255,255,0.1);
    border-radius: 15px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    background: rgba(255,255,255,0.2);
}

.stat-icon {
    font-size: 3rem;
    margin-bottom: 20px;
    color: var(--accent-color);
}

.stat-number {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 10px;
    color: var(--accent-color);
}

.stat-label {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Map Section */
.map-section {
    padding: 100px 0;
    background: var(--bg-light);
}

.map-container {
    background: var(--white);
    border-radius: 15px;
    padding: 30px;
    box-shadow: var(--shadow);
}

.map-wrapper {
    position: relative;
    width: 100%;
    height: 400px;
    overflow: hidden;
    border-radius: 10px;
}

.map-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    filter: grayscale(20%);
}

.project-marker {
    position: absolute;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
}

.project-marker:hover {
    transform: scale(1.1);
}

.marker-dot {
    width: 12px;
    height: 12px;
    background: linear-gradient(135deg, var(--primary-color), #ff8c00);
    border: 3px solid var(--white);
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(255, 107, 0, 0.4);
    animation: pulse 2s infinite;
}

.marker-label {
    position: absolute;
    top: -35px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: bold;
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.project-marker:hover .marker-label {
    opacity: 1;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 107, 0, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(255, 107, 0, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 107, 0, 0);
    }
}

.map-stats {
    background: linear-gradient(135deg, var(--secondary-color), #00a0ff);
    color: white;
    padding: 40px;
    border-radius: 15px;
    height: fit-content;
}

.map-stats h4 {
    color: white;
    margin-bottom: 30px;
    font-weight: bold;
    font-size: 1.5rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 30px;
}

.stat-item {
    text-align: center;
    padding: 20px;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    backdrop-filter: blur(10px);
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: var(--accent-color);
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.project-list h5 {
    color: white;
    margin-bottom: 20px;
    font-weight: bold;
}

.project-list ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.project-list li {
    padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,0.2);
    position: relative;
    padding-right: 25px;
}

.project-list li:before {
    content: "📍";
    position: absolute;
    right: 0;
    top: 10px;
}

.project-list li:last-child {
    border-bottom: none;
}

/* Contact CTA Section */
.contact-cta-section {
    padding: 100px 0;
    background: linear-gradient(135deg, var(--text-dark), #444);
    color: white;
    text-align: center;
}

.cta-content h2 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 20px;
}

.cta-content p {
    font-size: 1.2rem;
    margin-bottom: 40px;
    opacity: 0.9;
}

.cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title-main {
        font-size: 2rem;
    }

    .hero-title-sub {
        font-size: 1.2rem;
    }

    .title-accent {
        font-size: 2rem;
    }

    .hero-buttons {
        justify-content: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    @media (max-width: 768px) {
        .hero-buttons {
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .btn-success-custom,
        .btn-warning-custom {
            width: 100%;
            max-width: 200px;
            justify-content: center;
        }

        .user-welcome-card {
            padding: 20px;
        }

        .user-info h3 {
            font-size: 1.25rem;
        }

        .quick-stats .stat-number {
            font-size: 1.5rem;
        }

        .quick-actions .btn {
            font-size: 0.875rem;
            padding: 8px 16px;
        }
    }

    .btn-success-custom,
    .btn-warning-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .btn-success-custom {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-success-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-warning-custom {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .btn-warning-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        color: white;
    }

    .btn-success-custom i,
    .btn-warning-custom i {
        font-size: 1.1em;
    }

    /* User Dashboard Section */
    .user-dashboard-section {
        margin: 50px 0;
    }

    .user-welcome-card {
        animation: slideInUp 0.6s ease-out;
    }

    .user-info h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .quick-stats .stat-number {
        font-size: 2rem;
        line-height: 1;
    }

    .quick-stats .stat-label {
        font-size: 0.875rem;
        margin-top: 5px;
    }

    .quick-actions .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .quick-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .map-wrapper {
        height: 300px;
    }

    .stat-number {
        font-size: 2rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
    // Map markers functionality
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.project-marker').forEach(marker => {
            marker.addEventListener('click', function() {
                const projectName = this.getAttribute('data-project');

                const projectDetails = {
                    'تهران': 'پروژه‌های متعدد در پایتخت شامل مراکز تجاری و مسکونی',
                    'اصفهان': 'پروژه‌های صنعتی و مسکونی در شهر تاریخی اصفهان',
                    'شیراز': 'پروژه‌های عمرانی و کمپ‌های اقامتی در شیراز',
                    'مشهد': 'پروژه‌های مذهبی و مسکونی در مشهد مقدس',
                    'بوشهر': 'پروژه‌های پتروشیمی و صنعتی در بوشهر',
                    'اهواز': 'پروژه‌های نفتی و صنعتی در اهواز'
                };

                const details = projectDetails[projectName] || 'اطلاعات پروژه در دسترس نیست';
                alert(`${projectName}:\n${details}`);
            });
        });
    });
</script>
@endpush
