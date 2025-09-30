@extends('website.layout')

@section('title', 'پروژه‌های داروگ - شرکت کاخ‌سازان داروگ')
@section('description', 'مشاهده پروژه‌های شاخص و نمونه کارهای انجام شده توسط شرکت کاخ‌سازان داروگ')

@section('content')
<!-- Hero Section -->
<section class="projects-hero">
    <div class="hero-gradient-line"></div>
    <div class="hero-decorative-circle hero-orange-glow"></div>
    <div class="hero-decorative-circle hero-blue-glow"></div>
    
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">
                <span class="hero-title-main">پروژه‌های داروگ</span>
                <span class="hero-title-sub">نمونه کارهای شاخص ما</span>
            </h1>
            <p class="hero-description">
                بیش از دو دهه تجربه در اجرای پروژه‌های بزرگ عمرانی، از کمپ‌های اقامتی تا پروژه‌های پتروشیمی و مسکونی
            </p>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="filter-section">
    <div class="container">
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">
                <i class="bi bi-grid-3x3-gap"></i>
                همه پروژه‌ها
            </button>
            <button class="filter-btn" data-filter="petrochemical">
                <i class="bi bi-building"></i>
                پتروشیمی
            </button>
            <button class="filter-btn" data-filter="residential">
                <i class="bi bi-house"></i>
                مسکونی
            </button>
            <button class="filter-btn" data-filter="camp">
                <i class="bi bi-tent"></i>
                کمپ اقامتی
            </button>
            <button class="filter-btn" data-filter="industrial">
                <i class="bi bi-gear"></i>
                صنعتی
            </button>
        </div>
    </div>
</section>

<!-- Projects Grid -->
<section class="projects-grid-section">
    <div class="container">
        <div class="projects-grid">
            <!-- Project 1 - Petrochemical -->
            <div class="project-card" data-category="petrochemical">
                <div class="project-image">
                    <img src="https://vima-ir.com/wp-content/uploads/2023/12/pic-no-201-copy-2048x852.webp" alt="پروژه پتروشیمی بوشهر">
                    <div class="project-overlay">
                        <div class="project-actions">
                            <button class="btn btn-light" onclick="openProjectModal(1)">
                                <i class="bi bi-eye"></i>
                                مشاهده
                            </button>
                            <a href="#" class="btn btn-outline-light">
                                <i class="bi bi-arrow-left"></i>
                                جزئیات
                            </a>
                        </div>
                    </div>
                    <div class="project-badge">پتروشیمی</div>
                </div>
                <div class="project-content">
                    <h3>پروژه پتروشیمی بوشهر</h3>
                    <p>طراحی و اجرای کمپ اقامتی کارکنان پروژه پتروشیمی بوشهر با امکانات کامل رفاهی</p>
                    <div class="project-meta">
                        <div class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>عسلویه، بوشهر</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar"></i>
                            <span>1402</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-rulers"></i>
                            <span>5000 متر مربع</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project 2 - Camp -->
            <div class="project-card" data-category="camp">
                <div class="project-image">
                    <img src="https://vima-ir.com/wp-content/uploads/2023/11/Banner-Shorijeh-camp-jpg.webp" alt="کمپ اقامتی پردیس آذر">
                    <div class="project-overlay">
                        <div class="project-actions">
                            <button class="btn btn-light" onclick="openProjectModal(2)">
                                <i class="bi bi-eye"></i>
                                مشاهده
                            </button>
                            <a href="#" class="btn btn-outline-light">
                                <i class="bi bi-arrow-left"></i>
                                جزئیات
                            </a>
                        </div>
                    </div>
                    <div class="project-badge">کمپ اقامتی</div>
                </div>
                <div class="project-content">
                    <h3>کمپ اقامتی پردیس آذر</h3>
                    <p>طراحی، تأمین و ساخت تجهیزات کمپ پروژه شوریجه با امکانات مدرن و رفاهی</p>
                    <div class="project-meta">
                        <div class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>خراسان رضوی، سرخس</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar"></i>
                            <span>1401</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-rulers"></i>
                            <span>3000 متر مربع</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project 3 - Residential -->
            <div class="project-card" data-category="residential">
                <div class="project-image">
                    <img src="https://vima-ir.com/wp-content/uploads/2023/11/Tabnak-project-1-jpg.webp" alt="پروژه مسکونی تابناک">
                    <div class="project-overlay">
                        <div class="project-actions">
                            <button class="btn btn-light" onclick="openProjectModal(3)">
                                <i class="bi bi-eye"></i>
                                مشاهده
                            </button>
                            <a href="#" class="btn btn-outline-light">
                                <i class="bi bi-arrow-left"></i>
                                جزئیات
                            </a>
                        </div>
                    </div>
                    <div class="project-badge">مسکونی</div>
                </div>
                <div class="project-content">
                    <h3>پروژه مسکونی تابناک</h3>
                    <p>تأمین و تجهیز واحدهای مسکونی با طراحی مدرن و امکانات رفاهی کامل</p>
                    <div class="project-meta">
                        <div class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>تهران، ایران</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar"></i>
                            <span>1400</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-rulers"></i>
                            <span>8000 متر مربع</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project 4 - Industrial -->
            <div class="project-card" data-category="industrial">
                <div class="project-image">
                    <img src="https://vima-ir.com/wp-content/uploads/2023/11/Homma-baner-jpg.webp" alt="مرکز نوآوری هُما">
                    <div class="project-overlay">
                        <div class="project-actions">
                            <button class="btn btn-light" onclick="openProjectModal(4)">
                                <i class="bi bi-eye"></i>
                                مشاهده
                            </button>
                            <a href="#" class="btn btn-outline-light">
                                <i class="bi bi-arrow-left"></i>
                                جزئیات
                            </a>
                        </div>
                    </div>
                    <div class="project-badge">صنعتی</div>
                </div>
                <div class="project-content">
                    <h3>مرکز نوآوری و فناوری هُما</h3>
                    <p>ایجاد فضای کاری مدرن و خلاقانه برای استارتاپ‌ها و شرکت‌های دانش‌بنیان</p>
                    <div class="project-meta">
                        <div class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>تهران، ایران</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar"></i>
                            <span>1399</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-rulers"></i>
                            <span>6000 متر مربع</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project 5 - Petrochemical -->
            <div class="project-card" data-category="petrochemical">
                <div class="project-image">
                    <img src="https://vima-ir.com/wp-content/uploads/2023/11/Banner-Shorijeh-camp-jpg.webp" alt="پروژه پتروشیمی پارس">
                    <div class="project-overlay">
                        <div class="project-actions">
                            <button class="btn btn-light" onclick="openProjectModal(5)">
                                <i class="bi bi-eye"></i>
                                مشاهده
                            </button>
                            <a href="#" class="btn btn-outline-light">
                                <i class="bi bi-arrow-left"></i>
                                جزئیات
                            </a>
                        </div>
                    </div>
                    <div class="project-badge">پتروشیمی</div>
                </div>
                <div class="project-content">
                    <h3>پروژه پتروشیمی پارس</h3>
                    <p>ساخت و تجهیز فضاهای اداری و رفاهی برای کارکنان پروژه پتروشیمی پارس</p>
                    <div class="project-meta">
                        <div class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>عسلویه، بوشهر</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar"></i>
                            <span>1398</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-rulers"></i>
                            <span>4000 متر مربع</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project 6 - Camp -->
            <div class="project-card" data-category="camp">
                <div class="project-image">
                    <img src="https://vima-ir.com/wp-content/uploads/2023/12/pic-no-201-copy-2048x852.webp" alt="کمپ اقامتی خلیج فارس">
                    <div class="project-overlay">
                        <div class="project-actions">
                            <button class="btn btn-light" onclick="openProjectModal(6)">
                                <i class="bi bi-eye"></i>
                                مشاهده
                            </button>
                            <a href="#" class="btn btn-outline-light">
                                <i class="bi bi-arrow-left"></i>
                                جزئیات
                            </a>
                        </div>
                    </div>
                    <div class="project-badge">کمپ اقامتی</div>
                </div>
                <div class="project-content">
                    <h3>کمپ اقامتی خلیج فارس</h3>
                    <p>طراحی و اجرای کمپ اقامتی برای کارکنان پروژه‌های نفتی در منطقه خلیج فارس</p>
                    <div class="project-meta">
                        <div class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>بوشهر، ایران</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar"></i>
                            <span>1397</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-rulers"></i>
                            <span>3500 متر مربع</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-5">
            <button class="btn btn-primary-custom" id="loadMoreBtn">
                <span>مشاهده پروژه‌های بیشتر</span>
                <i class="bi bi-arrow-left"></i>
            </button>
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

<!-- CTA Section -->
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
/* Projects Page Styles */
:root {
    --primary-color: #0077ff;
    --secondary-color: #ff6b00;
    --accent-color: #ffd700;
    --text-dark: #2c2c2c;
    --text-light: #666666;
    --bg-light: #f0f2f5;
    --white: #ffffff;
    --shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Hero Section */
.projects-hero {
    background: linear-gradient(135deg, #f0f2f5 0%, #e8ecf0 100%);
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
    text-align: center;
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
    max-width: 600px;
    margin: 0 auto;
}

/* Filter Section */
.filter-section {
    padding: 40px 0;
    background: var(--white);
    border-bottom: 1px solid #eee;
}

.filter-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border: 2px solid #e0e0e0;
    background: var(--white);
    color: var(--text-dark);
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.filter-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateY(-2px);
}

.filter-btn.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    box-shadow: 0 4px 15px rgba(0, 119, 255, 0.3);
}

/* Projects Grid */
.projects-grid-section {
    padding: 80px 0;
    background: var(--bg-light);
}

.projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.project-card {
    background: var(--white);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    opacity: 1;
    transform: scale(1);
}

.project-card.hidden {
    opacity: 0;
    transform: scale(0.8);
    pointer-events: none;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.project-image {
    position: relative;
    height: 250px;
    overflow: hidden;
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

.project-actions {
    display: flex;
    gap: 15px;
}

.project-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: var(--primary-color);
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
}

.project-content {
    padding: 25px;
}

.project-content h3 {
    font-size: 1.3rem;
    font-weight: bold;
    color: var(--text-dark);
    margin-bottom: 15px;
}

.project-content p {
    color: var(--text-light);
    line-height: 1.6;
    margin-bottom: 20px;
}

.project-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-light);
    font-size: 14px;
}

.meta-item i {
    color: var(--primary-color);
    width: 16px;
}

/* Buttons */
.btn-primary-custom {
    background: linear-gradient(135deg, var(--primary-color), #00a0ff);
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
    box-shadow: 0 4px 15px rgba(0, 119, 255, 0.3);
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 119, 255, 0.4);
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

.btn-light {
    background: white;
    color: var(--text-dark);
    border: 1px solid #ddd;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-light:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.btn-outline-light {
    background: transparent;
    color: white;
    border: 1px solid white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-outline-light:hover {
    background: white;
    color: var(--text-dark);
}

/* Statistics Section */
.stats-section {
    padding: 80px 0;
    background: linear-gradient(135deg, var(--primary-color), #00a0ff);
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

/* Contact CTA Section */
.contact-cta-section {
    padding: 80px 0;
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
    
    .projects-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .filter-buttons {
        gap: 10px;
    }
    
    .filter-btn {
        padding: 10px 20px;
        font-size: 14px;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter projects
            projectCards.forEach(card => {
                const category = card.getAttribute('data-category');
                
                if (filter === 'all' || category === filter) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    });
    
    // Load more functionality
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            // Simulate loading more projects
            this.innerHTML = '<span>در حال بارگذاری...</span><i class="bi bi-arrow-clockwise"></i>';
            
            setTimeout(() => {
                this.innerHTML = '<span>مشاهده پروژه‌های بیشتر</span><i class="bi bi-arrow-left"></i>';
                alert('پروژه‌های بیشتری در آینده اضافه خواهد شد');
            }, 1500);
        });
    }
});

// Project modal function (placeholder)
function openProjectModal(projectId) {
    alert(`جزئیات پروژه ${projectId} در حال آماده‌سازی است`);
}
</script>
@endpush