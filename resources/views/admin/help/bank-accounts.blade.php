@extends('admin.layout')

@section('title', 'حساب‌های بانکی - راهنمای سیستم مدیریت پروژه')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.help') }}">راهنما</a></li>
                        <li class="breadcrumb-item active">حساب‌های بانکی</li>
                    </ol>
                </div>
                <h4 class="page-title">راهنمای مدیریت حساب‌های بانکی</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="text-primary">مدیریت حساب‌های بانکی</h2>
                        <p class="text-muted">راهنمای کامل برای مدیریت حساب‌های بانکی کارمندان</p>
                    </div>

                    <!-- Adding Bank Account -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-bank-plus me-2"></i>
                                        افزودن حساب بانکی
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>مراحل افزودن حساب بانکی:</h6>
                                    <ol>
                                        <li>از لیست کارمندان، روی <strong>حساب‌های بانکی</strong> کلیک کنید</li>
                                        <li>روی <strong>افزودن حساب جدید</strong> کلیک کنید</li>
                                        <li>فرم اطلاعات حساب را تکمیل کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات حساب:</h6>
                                            <ul>
                                                <li><strong>بانک:</strong> انتخاب از لیست بانک‌های موجود</li>
                                                <li><strong>شماره شبا:</strong> شماره شبا ۲۴ رقمی</li>
                                                <li><strong>شماره کارت:</strong> شماره کارت ۱۶ رقمی</li>
                                                <li><strong>نام صاحب حساب:</strong> نام کامل</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>تنظیمات:</h6>
                                            <ul>
                                                <li><strong>وضعیت:</strong> فعال یا غیرفعال</li>
                                                <li><strong>حساب پیش‌فرض:</strong> برای پرداخت حقوق</li>
                                                <li><strong>شعبه:</strong> نام شعبه بانک</li>
                                                <li><strong>توضیحات:</strong> اطلاعات اضافی</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mt-3">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> شماره شبا باید ۲۴ رقمی و معتبر باشد. سیستم به صورت خودکار اعتبار آن را بررسی می‌کند.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Account Validation -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-check-circle me-2"></i>
                                        اعتبارسنجی حساب بانکی
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>سیستم اعتبارسنجی:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>اعتبارسنجی شبا:</strong> بررسی فرمت و صحت شماره شبا</li>
                                                <li><strong>اعتبارسنجی کارت:</strong> بررسی شماره کارت با الگوریتم Luhn</li>
                                                <li><strong>بررسی بانک:</strong> مطابقت با بانک انتخاب شده</li>
                                                <li><strong>بررسی تکراری:</strong> جلوگیری از ثبت حساب تکراری</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>اعتبارسنجی آنلاین:</strong> بررسی با بانک مرکزی</li>
                                                <li><strong>بررسی وضعیت حساب:</strong> فعال یا مسدود</li>
                                                <li><strong>بررسی مالکیت:</strong> تطبیق با اطلاعات کارمند</li>
                                                <li><strong>گزارش خطاها:</strong> نمایش خطاهای اعتبارسنجی</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-success mt-3">
                                        <i class="mdi mdi-lightbulb me-2"></i>
                                        <strong>راهنمایی:</strong> در صورت بروز خطا در اعتبارسنجی، اطلاعات را دوباره بررسی کنید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Default Account Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-star me-2"></i>
                                        مدیریت حساب پیش‌فرض
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>تنظیم حساب پیش‌فرض:</h6>
                                    <ol>
                                        <li>از لیست حساب‌های کارمند، روی <strong>تنظیم به عنوان پیش‌فرض</strong> کلیک کنید</li>
                                        <li>تایید کنید که این حساب برای پرداخت حقوق استفاده شود</li>
                                        <li>حساب قبلی به صورت خودکار از حالت پیش‌فرض خارج می‌شود</li>
                                    </ol>

                                    <div class="alert alert-warning mt-3">
                                        <i class="mdi mdi-alert me-2"></i>
                                        <strong>توجه:</strong> هر کارمند فقط می‌تواند یک حساب پیش‌فرض داشته باشد. حساب پیش‌فرض برای پرداخت حقوق استفاده می‌شود.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Status Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-toggle-switch me-2"></i>
                                        مدیریت وضعیت حساب
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>وضعیت‌های مختلف حساب:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>فعال:</strong> حساب قابل استفاده</li>
                                                <li><strong>غیرفعال:</strong> حساب موقتاً غیرقابل استفاده</li>
                                                <li><strong>مسدود:</strong> حساب مسدود شده</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>در انتظار تایید:</strong> منتظر تایید</li>
                                                <li><strong>رد شده:</strong> تایید نشده</li>
                                                <li><strong>منقضی شده:</strong> تاریخ انقضا گذشته</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mt-3">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> فقط حساب‌های فعال می‌توانند به عنوان پیش‌فرض تنظیم شوند.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-bank me-2"></i>
                                        مدیریت بانک‌ها
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>افزودن بانک جدید:</h6>
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Processing -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-credit-card me-2"></i>
                                        پردازش پرداخت
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>استفاده از حساب‌های بانکی:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>پرداخت حقوق:</strong> استفاده از حساب پیش‌فرض</li>
                                                <li><strong>پرداخت پاداش:</strong> انتخاب حساب مناسب</li>
                                                <li><strong>پرداخت اضافه‌کاری:</strong> محاسبه و پرداخت</li>
                                                <li><strong>پرداخت مرخصی:</strong> پرداخت مرخصی استحقاقی</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>گزارش پرداخت‌ها:</strong> تاریخچه تراکنش‌ها</li>
                                                <li><strong>تایید پرداخت:</strong> تایید تراکنش‌ها</li>
                                                <li><strong>برگشت پرداخت:</strong> در صورت خطا</li>
                                                <li><strong>گزارش مالی:</strong> گزارش‌های مالی</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security and Privacy -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-dark">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-shield-lock me-2"></i>
                                        امنیت و حریم خصوصی
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>اقدامات امنیتی:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>رمزگذاری داده‌ها:</strong> محافظت از اطلاعات حساس</li>
                                                <li><strong>دسترسی محدود:</strong> فقط کاربران مجاز</li>
                                                <li><strong>لاگ فعالیت‌ها:</strong> ثبت تمام تغییرات</li>
                                                <li><strong>پشتیبان‌گیری:</strong> بک‌آپ منظم</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>اعتبارسنجی:</strong> بررسی صحت اطلاعات</li>
                                                <li><strong>کنترل دسترسی:</strong> مدیریت مجوزها</li>
                                                <li><strong>نظارت امنیتی:</strong> مانیتورینگ مداوم</li>
                                                <li><strong>بروزرسانی امنیتی:</strong> آپدیت‌های امنیتی</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-dark mt-3">
                                        <i class="mdi mdi-alert me-2"></i>
                                        <strong>هشدار:</strong> اطلاعات بانکی بسیار حساس هستند. از دسترسی غیرمجاز جلوگیری کنید.
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
                                            <h6>مدیریت حساب‌ها:</h6>
                                            <ul>
                                                <li>اطلاعات را دقیق و کامل وارد کنید</li>
                                                <li>حساب پیش‌فرض را به درستی تنظیم کنید</li>
                                                <li>وضعیت حساب‌ها را به‌روز نگه دارید</li>
                                                <li>از اعتبارسنجی سیستم استفاده کنید</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>امنیت:</h6>
                                            <ul>
                                                <li>اطلاعات حساس را محرمانه نگه دارید</li>
                                                <li>دسترسی‌ها را کنترل کنید</li>
                                                <li>لاگ‌ها را بررسی کنید</li>
                                                <li>از پسوردهای قوی استفاده کنید</li>
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
                            <a href="{{ route('employees.index') }}" class="btn btn-primary">
                                <i class="mdi mdi-bank me-1"></i>
                                مدیریت حساب‌های بانکی
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
