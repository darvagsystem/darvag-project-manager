@extends('admin.layout')

@section('title', 'تخصیص کارمندان به پروژه - راهنمای سیستم مدیریت پروژه')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.help') }}">راهنما</a></li>
                        <li class="breadcrumb-item active">تخصیص کارمندان</li>
                    </ol>
                </div>
                <h4 class="page-title">راهنمای تخصیص کارمندان به پروژه</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="text-primary">تخصیص کارمندان به پروژه</h2>
                        <p class="text-muted">راهنمای کامل برای تخصیص و مدیریت کارمندان در پروژه‌ها</p>
                    </div>

                    <!-- Adding Employee to Project -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-plus me-2"></i>
                                        افزودن کارمند به پروژه
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>مراحل افزودن کارمند:</h6>
                                    <ol>
                                        <li>از صفحه پروژه، روی <strong>کارمندان پروژه</strong> کلیک کنید</li>
                                        <li>روی <strong>افزودن کارمند</strong> کلیک کنید</li>
                                        <li>فرم تخصیص کارمند را تکمیل کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات کارمند:</h6>
                                            <ul>
                                                <li><strong>کارمند:</strong> انتخاب از لیست کارمندان</li>
                                                <li><strong>نقش:</strong> نقش در پروژه</li>
                                                <li><strong>مسئولیت‌ها:</strong> وظایف محوله</li>
                                                <li><strong>سطح دسترسی:</strong> مجوزهای دسترسی</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>اطلاعات زمانی:</h6>
                                            <ul>
                                                <li><strong>تاریخ شروع:</strong> شروع همکاری</li>
                                                <li><strong>تاریخ پایان:</strong> پایان همکاری</li>
                                                <li><strong>ساعت کاری:</strong> ساعت‌های اختصاص یافته</li>
                                                <li><strong>نوع همکاری:</strong> تمام‌وقت، پاره‌وقت</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mt-3">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> کارمند باید قبلاً در سیستم ثبت شده باشد تا بتوانید او را به پروژه تخصیص دهید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-star me-2"></i>
                                        مدیریت نقش‌ها
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>نقش‌های رایج در پروژه:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>مدیر پروژه:</strong> مسئول کلی پروژه</li>
                                                <li><strong>توسعه‌دهنده ارشد:</strong> برنامه‌نویس ارشد</li>
                                                <li><strong>توسعه‌دهنده:</strong> برنامه‌نویس</li>
                                                <li><strong>طراح UI/UX:</strong> طراح رابط کاربری</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>تست‌کننده:</strong> مسئول تست و کنترل کیفیت</li>
                                                <li><strong>تحلیلگر سیستم:</strong> تحلیلگر</li>
                                                <li><strong>مشاور فنی:</strong> مشاور تخصصی</li>
                                                <li><strong>هماهنگ‌کننده:</strong> هماهنگ‌کننده تیم</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-success mt-3">
                                        <i class="mdi mdi-lightbulb me-2"></i>
                                        <strong>راهنمایی:</strong> نقش‌ها تعیین‌کننده مسئولیت‌ها و دسترسی‌های کارمند در پروژه هستند.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Time Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-clock me-2"></i>
                                        مدیریت زمان
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>تنظیمات زمانی:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>تاریخ شروع:</strong> شروع همکاری در پروژه</li>
                                                <li><strong>تاریخ پایان:</strong> پایان همکاری</li>
                                                <li><strong>ساعت کاری روزانه:</strong> ساعت‌های کار روزانه</li>
                                                <li><strong>روزهای کاری:</strong> روزهای هفته</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>نوع همکاری:</strong> تمام‌وقت، پاره‌وقت</li>
                                                <li><strong>ساعت اضافه‌کاری:</strong> ساعت‌های اضافی</li>
                                                <li><strong>مرخصی:</strong> روزهای مرخصی</li>
                                                <li><strong>انعطاف‌پذیری:</strong> ساعت‌های انعطاف‌پذیر</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-warning mt-3">
                                        <i class="mdi mdi-alert me-2"></i>
                                        <strong>توجه:</strong> تنظیمات زمانی بر روی محاسبه حقوق و حضور و غیاب تأثیر می‌گذارد.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Status -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-check me-2"></i>
                                        وضعیت کارمند در پروژه
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>وضعیت‌های مختلف:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>فعال:</strong> کارمند در حال کار در پروژه</li>
                                                <li><strong>غیرفعال:</strong> کارمند از پروژه خارج شده</li>
                                                <li><strong>در انتظار:</strong> منتظر شروع کار</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>مرخصی:</strong> کارمند در مرخصی</li>
                                                <li><strong>تکمیل شده:</strong> کار تمام شده</li>
                                                <li><strong>تعلیق:</strong> کار موقتاً متوقف</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mt-3">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> تغییر وضعیت کارمند بر روی دسترسی‌ها و محاسبات تأثیر می‌گذارد.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Team Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-group me-2"></i>
                                        مدیریت تیم
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>اصول مدیریت تیم:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>تعادل تیم:</strong> ترکیب مناسب مهارت‌ها</li>
                                                <li><strong>توزیع مسئولیت‌ها:</strong> تقسیم عادلانه کار</li>
                                                <li><strong>ارتباطات:</strong> برقراری ارتباط موثر</li>
                                                <li><strong>هماهنگی:</strong> هماهنگی بین اعضا</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>نظارت:</strong> نظارت بر پیشرفت کار</li>
                                                <li><strong>پشتیبانی:</strong> حمایت از اعضای تیم</li>
                                                <li><strong>تشویق:</strong> انگیزه‌دهی به تیم</li>
                                                <li><strong>حل مشکل:</strong> رفع مشکلات تیم</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Tracking -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-chart-line me-2"></i>
                                        ردیابی عملکرد
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>شاخص‌های عملکرد:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>ساعت کاری:</strong> ساعت‌های صرف شده</li>
                                                <li><strong>کیفیت کار:</strong> کیفیت خروجی</li>
                                                <li><strong>مهلت‌ها:</strong> رعایت زمان‌بندی</li>
                                                <li><strong>همکاری:</strong> تعامل با تیم</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>خلاقیت:</strong> نوآوری و ابتکار</li>
                                                <li><strong>مسئولیت‌پذیری:</strong> انجام وظایف</li>
                                                <li><strong>یادگیری:</strong> توسعه مهارت‌ها</li>
                                                <li><strong>رضایت مشتری:</strong> رضایت مشتری</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-danger mt-3">
                                        <i class="mdi mdi-alert me-2"></i>
                                        <strong>توجه:</strong> ردیابی عملکرد باید منصفانه و بر اساس شاخص‌های عینی باشد.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Communication -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-dark">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-message me-2"></i>
                                        ارتباطات تیم
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>ابزارهای ارتباطی:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>جلسات منظم:</strong> جلسات هفتگی</li>
                                                <li><strong>گزارش‌های روزانه:</strong> گزارش پیشرفت</li>
                                                <li><strong>پیام‌رسانی:</strong> ارتباط فوری</li>
                                                <li><strong>اشتراک‌گذاری:</strong> اشتراک فایل‌ها</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>نظرات و بازخورد:</strong> دریافت بازخورد</li>
                                                <li><strong>مستندسازی:</strong> ثبت تصمیم‌ها</li>
                                                <li><strong>آموزش:</strong> آموزش اعضای تیم</li>
                                                <li><strong>تشویق:</strong> قدردانی از تلاش‌ها</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Best Practices -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-lightbulb me-2"></i>
                                        بهترین روش‌ها
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>تخصیص کارمندان:</h6>
                                            <ul>
                                                <li>کارمندان مناسب را انتخاب کنید</li>
                                                <li>نقش‌ها را به وضوح تعریف کنید</li>
                                                <li>زمان‌بندی واقعی تعیین کنید</li>
                                                <li>وضعیت‌ها را به‌روز نگه دارید</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>مدیریت تیم:</h6>
                                            <ul>
                                                <li>ارتباط موثر برقرار کنید</li>
                                                <li>عملکرد را ردیابی کنید</li>
                                                <li>مشکلات را سریع حل کنید</li>
                                                <li>از تیم حمایت کنید</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <a href="{{ route('admin.help') }}" class="btn btn-secondary me-2">
                                <i class="mdi mdi-arrow-right me-1"></i>
                                بازگشت به راهنما
                            </a>
                            <a href="{{ route('panel.projects.index') }}" class="btn btn-primary">
                                <i class="mdi mdi-account-multiple-plus me-1"></i>
                                مدیریت تخصیص کارمندان
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
