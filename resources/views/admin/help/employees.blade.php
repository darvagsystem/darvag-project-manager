@extends('admin.layout')

@section('title', 'مدیریت کارمندان - راهنمای سیستم مدیریت پروژه')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.help') }}">راهنما</a></li>
                        <li class="breadcrumb-item active">مدیریت کارمندان</li>
                    </ol>
                </div>
                <h4 class="page-title">راهنمای مدیریت کارمندان</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="text-primary">مدیریت کارمندان</h2>
                        <p class="text-muted">راهنمای کامل برای مدیریت اطلاعات کارمندان در سیستم</p>
                    </div>

                    <!-- Adding Employees -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-plus me-2"></i>
                                        افزودن کارمند جدید
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>مراحل افزودن کارمند:</h6>
                                    <ol>
                                        <li>از منوی اصلی <strong>کارمندان</strong> را انتخاب کنید</li>
                                        <li>روی دکمه <strong>افزودن کارمند جدید</strong> کلیک کنید</li>
                                        <li>فرم اطلاعات کارمند را تکمیل کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات شخصی:</h6>
                                            <ul>
                                                <li><strong>نام:</strong> نام کارمند</li>
                                                <li><strong>نام خانوادگی:</strong> نام خانوادگی کارمند</li>
                                                <li><strong>کد ملی:</strong> کد ملی ۱۰ رقمی</li>
                                                <li><strong>تاریخ تولد:</strong> تاریخ تولد به شمسی</li>
                                                <li><strong>جنسیت:</strong> مرد یا زن</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>اطلاعات تماس:</h6>
                                            <ul>
                                                <li><strong>شماره تلفن:</strong> شماره تماس اصلی</li>
                                                <li><strong>آدرس:</strong> آدرس محل سکونت</li>
                                                <li><strong>وضعیت استخدام:</strong> فعال یا غیرفعال</li>
                                                <li><strong>تاریخ استخدام:</strong> تاریخ شروع کار</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mt-3">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> تمامی فیلدهای ستاره‌دار اجباری هستند و باید تکمیل شوند.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Editing Employees -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-edit me-2"></i>
                                        ویرایش اطلاعات کارمند
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>مراحل ویرایش کارمند:</h6>
                                    <ol>
                                        <li>از لیست کارمندان، روی <strong>ویرایش</strong> کلیک کنید</li>
                                        <li>اطلاعات مورد نظر را تغییر دهید</li>
                                        <li>روی <strong>ذخیره تغییرات</strong> کلیک کنید</li>
                                    </ol>

                                    <div class="alert alert-warning">
                                        <i class="mdi mdi-alert me-2"></i>
                                        <strong>توجه:</strong> تغییرات در اطلاعات کارمند بر روی تمام پروژه‌هایی که در آن شرکت دارد تأثیر می‌گذارد.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Accounts Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-bank me-2"></i>
                                        مدیریت حساب‌های بانکی
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>افزودن حساب بانکی:</h6>
                                    <ol>
                                        <li>از لیست کارمندان، روی <strong>حساب‌های بانکی</strong> کلیک کنید</li>
                                        <li>روی <strong>افزودن حساب جدید</strong> کلیک کنید</li>
                                        <li>اطلاعات حساب را وارد کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات حساب:</h6>
                                            <ul>
                                                <li><strong>بانک:</strong> انتخاب از لیست بانک‌های موجود</li>
                                                <li><strong>شماره شبا:</strong> شماره شبا ۲۴ رقمی</li>
                                                <li><strong>شماره کارت:</strong> شماره کارت ۱۶ رقمی</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>تنظیمات:</h6>
                                            <ul>
                                                <li><strong>وضعیت:</strong> فعال یا غیرفعال</li>
                                                <li><strong>حساب پیش‌فرض:</strong> برای پرداخت حقوق</li>
                                                <li><strong>توضیحات:</strong> توضیحات اضافی</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-success mt-3">
                                        <i class="mdi mdi-lightbulb me-2"></i>
                                        <strong>راهنمایی:</strong> هر کارمند می‌تواند چندین حساب بانکی داشته باشد، اما فقط یکی می‌تواند به عنوان پیش‌فرض تنظیم شود.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-file-document me-2"></i>
                                        مدیریت اسناد کارمند
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>افزودن سند:</h6>
                                    <ol>
                                        <li>از لیست کارمندان، روی <strong>اسناد</strong> کلیک کنید</li>
                                        <li>روی <strong>افزودن سند جدید</strong> کلیک کنید</li>
                                        <li>فایل سند را آپلود کنید</li>
                                        <li>نوع سند را انتخاب کنید (رزومه، قرارداد، مدارک هویتی و...)</li>
                                        <li>توضیحات اضافی در صورت نیاز</li>
                                    </ol>

                                    <div class="alert alert-info">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> فرمت‌های مجاز: PDF, DOC, DOCX, JPG, PNG با حداکثر حجم ۵ مگابایت
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Status -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-check me-2"></i>
                                        مدیریت وضعیت کارمند
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>وضعیت‌های مختلف کارمند:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>فعال:</strong> کارمند در حال کار است</li>
                                                <li><strong>غیرفعال:</strong> کارمند از کار برکنار شده</li>
                                                <li><strong>مرخصی:</strong> کارمند در مرخصی است</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>پروژه‌ای:</strong> کارمند فقط برای پروژه‌های خاص</li>
                                                <li><strong>پاره‌وقت:</strong> کارمند پاره‌وقت کار می‌کند</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-secondary">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>توجه:</strong> تغییر وضعیت کارمند بر روی دسترسی‌های او در سیستم تأثیر می‌گذارد.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-dark">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-magnify me-2"></i>
                                        جستجو و فیلتر کارمندان
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>امکانات جستجو:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>جستجو بر اساس نام:</strong> نام یا نام خانوادگی</li>
                                                <li><strong>جستجو بر اساس کد ملی:</strong> کد ملی کارمند</li>
                                                <li><strong>فیلتر بر اساس وضعیت:</strong> فعال، غیرفعال و...</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>فیلتر بر اساس تاریخ استخدام:</strong> بازه زمانی</li>
                                                <li><strong>جستجو در پروژه‌ها:</strong> کارمندان پروژه خاص</li>
                                                <li><strong>مرتب‌سازی:</strong> بر اساس نام، تاریخ استخدام</li>
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
                                            <h6>مدیریت اطلاعات:</h6>
                                            <ul>
                                                <li>اطلاعات کارمندان را به‌روز نگه دارید</li>
                                                <li>اسناد مهم را آپلود کنید</li>
                                                <li>حساب بانکی پیش‌فرض را تنظیم کنید</li>
                                                <li>وضعیت کارمندان را به‌روزرسانی کنید</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>امنیت:</h6>
                                            <ul>
                                                <li>اطلاعات حساس را محرمانه نگه دارید</li>
                                                <li>دسترسی‌ها را کنترل کنید</li>
                                                <li>از پسوردهای قوی استفاده کنید</li>
                                                <li>بک‌آپ منظم بگیرید</li>
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
                                <i class="mdi mdi-account-group me-1"></i>
                                مدیریت کارمندان
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
