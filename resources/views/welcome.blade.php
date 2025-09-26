<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $companySettings->company_name ?? 'شرکت کاخ‌سازان داروگ' }} - پیشرو در صنعت ساختمان</title>
    <meta name="description" content="{{ $companySettings->description ?? 'شرکت کاخ‌سازان داروگ، پیشرو در صنعت ساختمان و مهندسی با بیش از 15 سال سابقه درخشان' }}">
    <meta name="keywords" content="ساختمان, مهندسی, پروژه, داروگ, کاخ‌سازان">

        <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Vazir:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
            <style>
        :root {
            --primary-color: #2563eb;
            --primary-light: #dbeafe;
            --primary-dark: #1d4ed8;
            --secondary-color: #64748b;
            --accent-color: #7c3aed;
            --accent-light: #ede9fe;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --bg-light: #f8fafc;
            --border-light: #e2e8f0;
            --shadow-light: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazir', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: white;
            direction: rtl;
        }

        /* Success Message Notification */
        .success-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--success-color);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: var(--shadow-lg);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInRight 0.5s ease-out;
            min-width: 300px;
        }

        .success-notification.fade-out {
            animation: fadeOut 0.5s ease-out forwards;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        .success-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .header {
            background: white;
            box-shadow: var(--shadow-light);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .header.scrolled {
            box-shadow: var(--shadow-md);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
        }

        .nav {
            display: flex;
            gap: 30px;
        }

        .nav-link {
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: var(--transition);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .admin-btn {
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .admin-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            padding: 150px 0 100px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 300"><polygon fill="%23ffffff" opacity="0.1" points="0,300 50,250 100,280 150,220 200,260 250,200 300,240 350,180 400,220 450,160 500,200 550,140 600,180 650,120 700,160 750,100 800,140 850,80 900,120 950,60 1000,100 1000,300"></polygon></svg>') center/cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero-subtitle {
            font-size: 20px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .hero-description {
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto 40px;
            line-height: 1.8;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            font-size: 16px;
        }

        .btn-primary {
            background: white;
            color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--bg-light);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: white;
            color: var(--primary-color);
        }

        /* Stats Section */
        .stats {
            background: white;
            padding: 80px 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            text-align: center;
        }

        .stat-item {
            padding: 30px;
            border-radius: 16px;
            background: var(--bg-light);
            transition: var(--transition);
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 16px;
            color: var(--text-light);
        }

        /* Services Section */
        .services {
            background: var(--bg-light);
            padding: 80px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .section-subtitle {
            font-size: 18px;
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .service-card {
            background: white;
            padding: 40px 30px;
            border-radius: 16px;
            text-align: center;
            transition: var(--transition);
            border: 1px solid var(--border-light);
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-light);
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }

        .service-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .service-description {
            color: var(--text-light);
            line-height: 1.7;
        }

        /* Projects Section */
        .projects {
            background: white;
            padding: 80px 0;
        }

        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .project-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .project-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            font-weight: 600;
        }

        .project-content {
            padding: 25px;
        }

        .project-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .project-client {
            font-size: 14px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .project-description {
            color: var(--text-light);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .project-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--text-light);
        }

        .project-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .status-completed {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .status-in-progress {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary-color);
        }

        /* Team Section */
        .team {
            background: var(--bg-light);
            padding: 80px 0;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .team-member {
            background: white;
            padding: 30px;
            border-radius: 16px;
            text-align: center;
            transition: var(--transition);
        }

        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .member-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 24px;
            font-weight: 600;
        }

        .member-name {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .member-position {
            font-size: 14px;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .member-department {
            font-size: 12px;
            color: var(--text-light);
        }

        /* Contact Section */
        .contact {
            background: white;
            padding: 80px 0;
        }

        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-light);
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .contact-details h4 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .contact-details p {
            color: var(--text-light);
            font-size: 14px;
        }

        .contact-form {
            background: var(--bg-light);
            padding: 40px;
            border-radius: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            transition: var(--transition);
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: white;
        }

        .footer-section p,
        .footer-section a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            line-height: 1.6;
        }

        .footer-section a:hover {
            color: var(--primary-color);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .nav {
                display: none;
            }

            .hero-title {
                font-size: 32px;
            }

            .hero-subtitle {
                font-size: 16px;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .contact-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .stats-grid,
            .services-grid,
            .projects-grid,
            .team-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animations */
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

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Scroll behavior */
        html {
            scroll-behavior: smooth;
        }
            </style>
    </head>
<body>
    <!-- Success Notification -->
    @if(session('success'))
        <div class="success-notification" id="successNotification">
            <svg class="success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
                        </div>
    @endif

    <!-- Header -->
    <header class="header" id="header">
        <div class="container">
            <div class="header-content">
                <a href="#" class="logo">
                    <div class="logo-icon">د</div>
                    <span>{{ $companySettings->company_name ?? 'کاخ‌سازان داروگ' }}</span>
                </a>

                <nav class="nav">
                    <a href="#home" class="nav-link">خانه</a>
                    <a href="#services" class="nav-link">خدمات</a>
                    <a href="#projects" class="nav-link">پروژه‌ها</a>
                    <a href="#team" class="nav-link">تیم</a>
                    <a href="#contact" class="nav-link">تماس</a>
                            </nav>

                <a href="/admin" class="admin-btn">پنل مدیریت</a>
            </div>
        </div>
                    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">{{ $companySettings->company_name ?? 'شرکت کاخ‌سازان داروگ' }}</h1>
                <p class="hero-subtitle">پیشرو در صنعت ساختمان و مهندسی</p>
                <p class="hero-description">
                    {{ $companySettings->description ?? 'با بیش از 15 سال سابقه درخشان در زمینه طراحی، ساخت و اجرای پروژه‌های عمرانی، صنعتی و تجاری، ما افتخار همکاری با بزرگترین شرکت‌ها و سازمان‌های کشور را داریم.' }}
                </p>
                <div class="cta-buttons">
                    <a href="#services" class="btn btn-primary">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        مشاهده خدمات
                    </a>
                    <a href="#projects" class="btn btn-secondary">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        پروژه‌های ما
                    </a>
                </div>
            </div>
                                </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon">
                        <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="stat-number">150+</div>
                    <div class="stat-label">پروژه تکمیل شده</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-number">50+</div>
                    <div class="stat-label">کارکنان متخصص</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="stat-number">15+</div>
                    <div class="stat-label">سال تجربه</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-number">100%</div>
                    <div class="stat-label">رضایت مشتریان</div>
                </div>
            </div>
                                        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">خدمات ما</h2>
                <p class="section-subtitle">مجموعه کاملی از خدمات تخصصی در زمینه ساختمان و مهندسی</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="service-title">ساخت و ساز</h3>
                    <p class="service-description">طراحی و اجرای ساختمان‌های مسکونی، تجاری و صنعتی با استفاده از تکنولوژی‌های روز دنیا</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="service-title">مشاوره مهندسی</h3>
                    <p class="service-description">ارائه خدمات مشاوره تخصصی در زمینه طراحی، نظارت و اجرای پروژه‌های عمرانی</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="service-title">پروژه‌های صنعتی</h3>
                    <p class="service-description">اجرای پروژه‌های صنعتی شامل کارخانجات، تصفیه‌خانه‌ها و تاسیسات نفتی</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="service-title">نگهداری و تعمیرات</h3>
                    <p class="service-description">خدمات نگهداری، تعمیرات و بهسازی تاسیسات و ساختمان‌های موجود</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="projects" id="projects">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">پروژه‌های اخیر</h2>
                <p class="section-subtitle">نمونه‌ای از پروژه‌های موفق اجرا شده توسط تیم ما</p>
            </div>
            <div class="projects-grid">
                <div class="project-card">
                    <div class="project-image">
                        <svg width="60" height="60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">پروژه احداث پالایشگاه نفت</h3>
                        <p class="project-client">شرکت نفت شرق</p>
                        <p class="project-description">احداث پالایشگاه نفت جدید با ظرفیت روزانه 100 هزار بشکه شامل تاسیسات کامل</p>
                        <div class="project-meta">
                            <span>1403/01/15</span>
                            <span class="project-status status-in-progress">در حال اجرا</span>
                        </div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image">
                        <svg width="60" height="60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">توسعه نیروگاه برق</h3>
                        <p class="project-client">مپنا</p>
                        <p class="project-description">توسعه و نوسازی نیروگاه برق با افزایش ظرفیت تولید و بهبود کارایی</p>
                        <div class="project-meta">
                            <span>1403/02/01</span>
                            <span class="project-status status-in-progress">در حال اجرا</span>
                        </div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image">
                        <svg width="60" height="60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">احداث پل شهری</h3>
                        <p class="project-client">شهرداری مشهد</p>
                        <p class="project-description">طراحی و اجرای پل شهری به طول 500 متر با معماری مدرن</p>
                        <div class="project-meta">
                            <span>1402/11/15</span>
                            <span class="project-status status-completed">تکمیل شده</span>
                        </div>
                    </div>
                </div>
                                        </div>
                                    </div>
    </section>

    <!-- Team Section -->
    <section class="team" id="team">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">تیم مدیریت</h2>
                <p class="section-subtitle">تیم متخصص و با تجربه ما</p>
            </div>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">ا.ر</div>
                    <h3 class="member-name">احمد رضایی</h3>
                    <p class="member-position">مدیر پروژه</p>
                    <p class="member-department">بخش مهندسی</p>
                </div>
                <div class="team-member">
                    <div class="member-avatar">س.م</div>
                    <h3 class="member-name">سارا محمدی</h3>
                    <p class="member-position">مهندس عمران</p>
                    <p class="member-department">بخش فنی</p>
                </div>
                <div class="team-member">
                    <div class="member-avatar">ح.ک</div>
                    <h3 class="member-name">حسین کریمی</h3>
                    <p class="member-position">حسابدار</p>
                    <p class="member-department">بخش مالی</p>
                </div>
                <div class="team-member">
                    <div class="member-avatar">ف.ا</div>
                    <h3 class="member-name">فاطمه احمدی</h3>
                    <p class="member-position">منابع انسانی</p>
                    <p class="member-department">بخش اداری</p>
                </div>
            </div>
                                </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">تماس با ما</h2>
                <p class="section-subtitle">آماده پاسخگویی و همکاری با شما هستیم</p>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="contact-details">
                            <h4>آدرس دفتر مرکزی</h4>
                            <p>{{ $companySettings->company_address ?? 'مشهد، خیابان امام رضا، پلاک 123' }}</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="contact-details">
                            <h4>تلفن تماس</h4>
                            <p>{{ $companySettings->phone ?? '051-38234567' }}</p>
                        </div>
                                </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                                </div>
                        <div class="contact-details">
                            <h4>ایمیل</h4>
                            <p>{{ $companySettings->email ?? 'info@darvag.com' }}</p>
                                </div>
                                </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                        <div class="contact-details">
                            <h4>ساعات کاری</h4>
                            <p>شنبه تا چهارشنبه: 8:00 - 17:00</p>
                        </div>
                                </div>
                            </div>
                <div class="contact-form">
                    <h3 style="margin-bottom: 20px; color: var(--text-dark);">ارسال پیام</h3>
                    <form>
                        <div class="form-group">
                            <label class="form-label">نام و نام خانوادگی</label>
                            <input type="text" class="form-input" placeholder="نام کامل شما">
                        </div>
                        <div class="form-group">
                            <label class="form-label">ایمیل</label>
                            <input type="email" class="form-input" placeholder="email@example.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">موضوع</label>
                            <input type="text" class="form-input" placeholder="موضوع پیام">
                        </div>
                        <div class="form-group">
                            <label class="form-label">پیام</label>
                            <textarea class="form-textarea" placeholder="پیام شما..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">ارسال پیام</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>{{ $companySettings->company_name ?? 'شرکت کاخ‌سازان داروگ' }}</h3>
                    <p>{{ $companySettings->description ?? 'پیشرو در صنعت ساختمان و مهندسی با بیش از 15 سال سابقه درخشان در اجرای پروژه‌های بزرگ صنعتی و عمرانی' }}</p>
                </div>
                <div class="footer-section">
                    <h3>خدمات</h3>
                    <p><a href="#services">ساخت و ساز</a></p>
                    <p><a href="#services">مشاوره مهندسی</a></p>
                    <p><a href="#services">پروژه‌های صنعتی</a></p>
                    <p><a href="#services">نگهداری و تعمیرات</a></p>
                </div>
                <div class="footer-section">
                    <h3>لینک‌های مفید</h3>
                    <p><a href="#projects">پروژه‌ها</a></p>
                    <p><a href="#team">تیم ما</a></p>
                    <p><a href="/admin">پنل مدیریت</a></p>
                    <p><a href="#contact">تماس با ما</a></p>
                </div>
                <div class="footer-section">
                    <h3>اطلاعات تماس</h3>
                    <p>{{ $companySettings->company_address ?? 'مشهد، خیابان امام رضا، پلاک 123' }}</p>
                    <p>تلفن: {{ $companySettings->phone ?? '051-38234567' }}</p>
                    <p>ایمیل: {{ $companySettings->email ?? 'info@darvag.com' }}</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 1403 {{ $companySettings->company_name ?? 'شرکت کاخ‌سازان داروگ' }}. تمام حقوق محفوظ است.</p>
            </div>
        </div>
    </footer>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Form submission
        document.querySelector('.contact-form form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('پیام شما با موفقیت ارسال شد! به زودی با شما تماس خواهیم گرفت.');
            this.reset();
        });

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.stat-item, .service-card, .project-card, .team-member').forEach(el => {
            observer.observe(el);
        });

        // Auto-hide success notification
        const successNotification = document.getElementById('successNotification');
        if (successNotification) {
            setTimeout(() => {
                successNotification.classList.add('fade-out');
                setTimeout(() => {
                    successNotification.remove();
                }, 500);
            }, 4000); // Hide after 4 seconds
        }
    </script>
    </body>
</html>
