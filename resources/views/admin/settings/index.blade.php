@extends('admin.layout')

@section('title', 'تنظیمات سیستم')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-dark">
                        <i class="fas fa-cog me-2 text-primary"></i>
                        تنظیمات سیستم
                    </h1>
                    <p class="text-muted mb-0">مدیریت تنظیمات و پیکربندی سیستم</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Cards -->
    <div class="row g-4">
        <!-- Payment Types -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-credit-card text-primary fs-4"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-2">انواع پرداخت</h5>
                    <p class="text-muted small mb-3">مدیریت انواع مختلف پرداخت‌ها</p>
                    <a href="{{ route('panel.projects.settings.payment-types.index', 1) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        مدیریت انواع پرداخت
                    </a>
                </div>
            </div>
        </div>

        <!-- Payment Recipients -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-users text-success fs-4"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-2">دریافت‌کنندگان</h5>
                    <p class="text-muted small mb-3">مدیریت دریافت‌کنندگان پرداخت</p>
                    <a href="{{ route('panel.payment-recipients.index') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        مدیریت دریافت‌کنندگان
                    </a>
                </div>
            </div>
        </div>

        <!-- Company Settings -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-building text-info fs-4"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-2">تنظیمات شرکت</h5>
                    <p class="text-muted small mb-3">اطلاعات و تنظیمات شرکت</p>
                    <a href="#" class="btn btn-info btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        تنظیمات شرکت
                    </a>
                </div>
            </div>
        </div>

        <!-- User Management -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-user-cog text-warning fs-4"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-2">مدیریت کاربران</h5>
                    <p class="text-muted small mb-3">مدیریت دسترسی‌ها و نقش‌ها</p>
                    <a href="#" class="btn btn-warning btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        مدیریت کاربران
                    </a>
                </div>
            </div>
        </div>

        <!-- System Settings -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-cogs text-secondary fs-4"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-2">تنظیمات سیستم</h5>
                    <p class="text-muted small mb-3">تنظیمات کلی سیستم</p>
                    <a href="#" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        تنظیمات سیستم
                    </a>
                </div>
            </div>
        </div>

        <!-- Backup & Restore -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-database text-danger fs-4"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-2">پشتیبان‌گیری</h5>
                    <p class="text-muted small mb-3">پشتیبان‌گیری و بازیابی داده‌ها</p>
                    <a href="#" class="btn btn-danger btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        پشتیبان‌گیری
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        آمار کلی
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 text-primary mb-1">{{ \App\Models\PaymentType::count() }}</div>
                                <div class="text-muted small">انواع پرداخت</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 text-success mb-1">{{ \App\Models\PaymentRecipient::count() }}</div>
                                <div class="text-muted small">دریافت‌کنندگان</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 text-info mb-1">{{ \App\Models\Project::count() }}</div>
                                <div class="text-muted small">پروژه‌ها</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 text-warning mb-1">{{ \App\Models\Employee::count() }}</div>
                                <div class="text-muted small">پرسنل</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Reset any problematic styles */
body, html {
    pointer-events: auto !important;
}

/* Simple and clean styles */
.card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
    position: relative;
    z-index: 1;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.btn {
    transition: all 0.3s ease;
    position: relative;
    z-index: 10;
    display: inline-block;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Ensure all elements are clickable */
a, button, .btn {
    cursor: pointer !important;
    text-decoration: none !important;
    pointer-events: auto !important;
    position: relative !important;
    z-index: 10 !important;
}

a:hover, button:hover, .btn:hover {
    text-decoration: none !important;
}

/* Fix any overlay issues */
.overlay, .modal-backdrop, .loading-overlay {
    display: none !important;
    pointer-events: none !important;
}

/* Ensure cards are clickable */
.card-body {
    pointer-events: auto !important;
    position: relative;
    z-index: 1;
}

/* Fix any potential z-index issues */
.container-fluid {
    position: relative;
    z-index: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Settings page loaded successfully');

    // Remove any problematic overlays
    const overlays = document.querySelectorAll('.overlay, .modal-backdrop, .loading-overlay');
    overlays.forEach(overlay => {
        if (overlay) {
            overlay.style.display = 'none';
            overlay.style.pointerEvents = 'none';
        }
    });

    // Ensure all links work
    const links = document.querySelectorAll('a');
    links.forEach(link => {
        link.style.pointerEvents = 'auto';
        link.style.cursor = 'pointer';
        link.style.zIndex = '10';
        link.style.position = 'relative';
    });

    // Ensure all buttons work
    const buttons = document.querySelectorAll('button, .btn');
    buttons.forEach(button => {
        button.style.pointerEvents = 'auto';
        button.style.cursor = 'pointer';
        button.style.zIndex = '10';
        button.style.position = 'relative';
    });

    console.log('All clickable elements fixed');
});
</script>
@endsection
