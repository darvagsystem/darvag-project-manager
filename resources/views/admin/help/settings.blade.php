@extends('admin.layout')

@section('title', 'تنظیمات سیستم - راهنمای سیستم مدیریت پروژه')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.help') }}">راهنما</a></li>
                        <li class="breadcrumb-item active">تنظیمات سیستم</li>
                    </ol>
                </div>
                <h4 class="page-title">راهنمای تنظیمات سیستم</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="text-primary">تنظیمات سیستم</h2>
                        <p class="text-muted">راهنمای کامل برای پیکربندی و تنظیم سیستم مدیریت پروژه</p>
                    </div>

                    <!-- Company Settings -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-office-building me-2"></i>
                                        تنظیمات شرکت
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>اطلاعات شرکت:</h6>
                                    <ol>
                                        <li>از منوی اصلی <strong>تنظیمات</strong> را انتخاب کنید</li>
                                        <li>روی <strong>تنظیمات شرکت</strong> کلیک کنید</li>
                                        <li>اطلاعات زیر را تکمیل کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات اصلی:</h6>
                                            <ul>
                                                <li><strong>نام شرکت:</strong> نام رسمی شرکت</li>
                                                <li><strong>نام تجاری:</strong> نام برند</li>
                                                <li><strong>شناسه ملی:</strong> شماره ثبت شرکت</li>
                                                <li><strong>کد اقتصادی:</strong> کد اقتصادی</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>اطلاعات تماس:</h6>
                                            <ul>
                                                <li><strong>آدرس:</strong> آدرس کامل شرکت</li>
                                                <li><strong>تلفن:</strong> شماره تلفن اصلی</li>
                                                <li><strong>فکس:</strong> شماره فکس</li>
                                                <li><strong>ایمیل:</strong> ایمیل رسمی</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mt-3">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> این اطلاعات در گزارش‌ها، فاکتورها و مستندات رسمی نمایش داده می‌شود.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-bank me-2"></i>
                                        مدیریت بانک‌ها
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>افزودن بانک:</h6>
                                    <ol>
                                        <li>از منوی تنظیمات، <strong>مدیریت بانک‌ها</strong> را انتخاب کنید</li>
                                        <li>روی <strong>افزودن بانک جدید</strong> کلیک کنید</li>
                                        <li>اطلاعات بانک را وارد کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات بانک:</h6>
                                            <ul>
                                                <li><strong>نام بانک:</strong> نام رسمی بانک</li>
                                                <li><strong>کد بانک:</strong> کد ۴ رقمی بانک</li>
                                                <li><strong>شماره شبا:</strong> شماره شبا بانک</li>
                                                <li><strong>شعبه:</strong> نام شعبه</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>تنظیمات:</h6>
                                            <ul>
                                                <li><strong>وضعیت:</strong> فعال یا غیرفعال</li>
                                                <li><strong>اولویت:</strong> ترتیب نمایش</li>
                                                <li><strong>توضیحات:</strong> اطلاعات اضافی</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-success mt-3">
                                        <i class="mdi mdi-lightbulb me-2"></i>
                                        <strong>راهنمایی:</strong> می‌توانید از دکمه "افزودن بانک‌های پیش‌فرض" برای اضافه کردن بانک‌های اصلی استفاده کنید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Configuration -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-cog me-2"></i>
                                        پیکربندی سیستم
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>تنظیمات مهم سیستم:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>زبان سیستم:</strong> فارسی یا انگلیسی</li>
                                                <li><strong>منطقه زمانی:</strong> تنظیم زمان محلی</li>
                                                <li><strong>فرمت تاریخ:</strong> شمسی یا میلادی</li>
                                                <li><strong>واحد پول:</strong> ریال، تومان</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>ساعت کاری عادی:</strong> ۸ ساعت</li>
                                                <li><strong>روزهای کاری:</strong> شنبه تا چهارشنبه</li>
                                                <li><strong>حداکثر اضافه‌کاری:</strong> ۴ ساعت</li>
                                                <li><strong>دوره گزارش‌گیری:</strong> ماهانه</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-group me-2"></i>
                                        مدیریت کاربران
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>مدیریت دسترسی‌ها:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>مدیر سیستم:</strong> دسترسی کامل</li>
                                                <li><strong>مدیر پروژه:</strong> مدیریت پروژه‌ها</li>
                                                <li><strong>کارمند:</strong> دسترسی محدود</li>
                                                <li><strong>مشاهده‌گر:</strong> فقط مشاهده</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li>تعریف نقش‌های جدید</li>
                                                <li>تخصیص مجوزها</li>
                                                <li>مدیریت رمز عبور</li>
                                                <li>لاگ فعالیت‌ها</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Backup and Security -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-shield-check me-2"></i>
                                        پشتیبان‌گیری و امنیت
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>تنظیمات امنیتی:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>پشتیبان‌گیری خودکار:</strong> روزانه</li>
                                                <li><strong>رمزگذاری داده‌ها:</strong> فعال</li>
                                                <li><strong>لاگ ورود:</strong> ثبت ورودها</li>
                                                <li><strong>تایید دو مرحله‌ای:</strong> اختیاری</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>مدت انقضای رمز:</strong> ۹۰ روز</li>
                                                <li><strong>حداکثر تلاش ورود:</strong> ۵ بار</li>
                                                <li><strong>فیلتر IP:</strong> محدودیت دسترسی</li>
                                                <li><strong>SSL:</strong> رمزگذاری ارتباط</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-danger mt-3">
                                        <i class="mdi mdi-alert me-2"></i>
                                        <strong>هشدار:</strong> تنظیمات امنیتی را با دقت انجام دهید و از پشتیبان‌گیری منظم اطمینان حاصل کنید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Maintenance -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-wrench me-2"></i>
                                        نگهداری سیستم
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>عملیات نگهداری:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>پاک‌سازی لاگ‌ها:</strong> حذف لاگ‌های قدیمی</li>
                                                <li><strong>بهینه‌سازی دیتابیس:</strong> بهبود عملکرد</li>
                                                <li><strong>بروزرسانی سیستم:</strong> نصب آپدیت‌ها</li>
                                                <li><strong>بررسی امنیت:</strong> اسکن امنیتی</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>پشتیبان‌گیری دستی:</strong> در صورت نیاز</li>
                                                <li><strong>بازگردانی داده:</strong> از پشتیبان</li>
                                                <li><strong>نظارت بر عملکرد:</strong> مانیتورینگ</li>
                                                <li><strong>گزارش خطاها:</strong> رفع مشکلات</li>
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
                                            <h6>تنظیمات اولیه:</h6>
                                            <ul>
                                                <li>اطلاعات شرکت را کامل تکمیل کنید</li>
                                                <li>بانک‌های مورد نیاز را اضافه کنید</li>
                                                <li>تنظیمات امنیتی را فعال کنید</li>
                                                <li>کاربران را با نقش‌های مناسب تعریف کنید</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>نگهداری:</h6>
                                            <ul>
                                                <li>پشتیبان‌گیری منظم انجام دهید</li>
                                                <li>سیستم را به‌روز نگه دارید</li>
                                                <li>لاگ‌ها را بررسی کنید</li>
                                                <li>عملکرد سیستم را نظارت کنید</li>
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
                            <a href="{{ route('admin.settings') }}" class="btn btn-primary">
                                <i class="mdi mdi-cog me-1"></i>
                                تنظیمات سیستم
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
