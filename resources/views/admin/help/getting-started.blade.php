@extends('admin.layout')

@section('title', 'شروع کار - راهنمای سیستم مدیریت پروژه')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.help') }}">راهنما</a></li>
                        <li class="breadcrumb-item active">شروع کار</li>
                    </ol>
                </div>
                <h4 class="page-title">راهنمای شروع کار</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="text-primary">شروع کار با سیستم مدیریت پروژه</h2>
                        <p class="text-muted">این راهنما شما را گام به گام برای شروع کار با سیستم راهنمایی می‌کند</p>
                    </div>

                    <!-- Step 1 -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-numeric-1-circle me-2"></i>
                                        مرحله اول: تنظیم اطلاعات شرکت
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>ابتدا باید اطلاعات شرکت خود را در سیستم ثبت کنید:</p>
                                    <ol>
                                        <li>از منوی سمت راست روی <strong>تنظیمات</strong> کلیک کنید</li>
                                        <li>سپس <strong>تنظیمات شرکت</strong> را انتخاب کنید</li>
                                        <li>اطلاعات زیر را تکمیل کنید:
                                            <ul>
                                                <li>نام شرکت</li>
                                                <li>آدرس</li>
                                                <li>شماره تلفن</li>
                                                <li>ایمیل</li>
                                                <li>سایر اطلاعات مورد نیاز</li>
                                            </ul>
                                        </li>
                                        <li>در نهایت روی <strong>ذخیره</strong> کلیک کنید</li>
                                    </ol>
                                    <div class="alert alert-info">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> این اطلاعات در گزارش‌ها و فاکتورها نمایش داده می‌شود.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-numeric-2-circle me-2"></i>
                                        مرحله دوم: اضافه کردن بانک‌ها
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>برای مدیریت حساب‌های بانکی کارمندان، ابتدا بانک‌ها را اضافه کنید:</p>
                                    <ol>
                                        <li>از منوی تنظیمات، <strong>مدیریت بانک‌ها</strong> را انتخاب کنید</li>
                                        <li>روی <strong>افزودن بانک جدید</strong> کلیک کنید</li>
                                        <li>اطلاعات بانک را وارد کنید:
                                            <ul>
                                                <li>نام بانک</li>
                                                <li>کد بانک</li>
                                                <li>شماره شبا</li>
                                            </ul>
                                        </li>
                                        <li>روی <strong>ذخیره</strong> کلیک کنید</li>
                                    </ol>
                                    <div class="alert alert-success">
                                        <i class="mdi mdi-lightbulb me-2"></i>
                                        <strong>راهنمایی:</strong> می‌توانید از دکمه "افزودن بانک‌های پیش‌فرض" برای اضافه کردن بانک‌های اصلی استفاده کنید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-numeric-3-circle me-2"></i>
                                        مرحله سوم: اضافه کردن کارمندان
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>حالا نوبت اضافه کردن کارمندان است:</p>
                                    <ol>
                                        <li>از منوی اصلی <strong>کارمندان</strong> را انتخاب کنید</li>
                                        <li>روی <strong>افزودن کارمند جدید</strong> کلیک کنید</li>
                                        <li>اطلاعات کارمند را تکمیل کنید:
                                            <ul>
                                                <li>نام و نام خانوادگی</li>
                                                <li>کد ملی</li>
                                                <li>تاریخ تولد</li>
                                                <li>شماره تلفن</li>
                                                <li>آدرس</li>
                                                <li>وضعیت استخدام</li>
                                            </ul>
                                        </li>
                                        <li>روی <strong>ذخیره</strong> کلیک کنید</li>
                                    </ol>
                                    <div class="alert alert-warning">
                                        <i class="mdi mdi-alert me-2"></i>
                                        <strong>توجه:</strong> بعد از اضافه کردن کارمند، حتماً حساب بانکی او را نیز تنظیم کنید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-numeric-4-circle me-2"></i>
                                        مرحله چهارم: تنظیم حساب‌های بانکی کارمندان
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>برای هر کارمند حساب بانکی تنظیم کنید:</p>
                                    <ol>
                                        <li>از لیست کارمندان، روی <strong>حساب‌های بانکی</strong> کلیک کنید</li>
                                        <li>روی <strong>افزودن حساب جدید</strong> کلیک کنید</li>
                                        <li>اطلاعات حساب را وارد کنید:
                                            <ul>
                                                <li>بانک</li>
                                                <li>شماره شبا</li>
                                                <li>شماره کارت</li>
                                                <li>وضعیت حساب</li>
                                            </ul>
                                        </li>
                                        <li>در صورت نیاز، حساب را به عنوان پیش‌فرض تنظیم کنید</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-numeric-5-circle me-2"></i>
                                        مرحله پنجم: اضافه کردن مشتریان
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>مشتریان پروژه‌ها را اضافه کنید:</p>
                                    <ol>
                                        <li>از منوی اصلی <strong>مشتریان</strong> را انتخاب کنید</li>
                                        <li>روی <strong>افزودن مشتری جدید</strong> کلیک کنید</li>
                                        <li>اطلاعات مشتری را تکمیل کنید:
                                            <ul>
                                                <li>نام شرکت/شخص</li>
                                                <li>آدرس</li>
                                                <li>شماره تلفن</li>
                                                <li>ایمیل</li>
                                            </ul>
                                        </li>
                                        <li>در صورت نیاز، اطلاعات تماس اضافی اضافه کنید</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 6 -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-numeric-6-circle me-2"></i>
                                        مرحله ششم: ایجاد پروژه
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>حالا می‌توانید اولین پروژه خود را ایجاد کنید:</p>
                                    <ol>
                                        <li>از منوی اصلی <strong>پروژه‌ها</strong> را انتخاب کنید</li>
                                        <li>روی <strong>افزودن پروژه جدید</strong> کلیک کنید</li>
                                        <li>اطلاعات پروژه را تکمیل کنید:
                                            <ul>
                                                <li>نام پروژه</li>
                                                <li>توضیحات</li>
                                                <li>مشتری</li>
                                                <li>تاریخ شروع و پایان</li>
                                                <li>بودجه</li>
                                            </ul>
                                        </li>
                                        <li>روی <strong>ذخیره</strong> کلیک کنید</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 7 -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-purple">
                                <div class="card-header bg-purple text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-numeric-7-circle me-2"></i>
                                        مرحله هفتم: تخصیص کارمندان به پروژه
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>کارمندان را به پروژه تخصیص دهید:</p>
                                    <ol>
                                        <li>از صفحه پروژه، روی <strong>کارمندان پروژه</strong> کلیک کنید</li>
                                        <li>روی <strong>افزودن کارمند</strong> کلیک کنید</li>
                                        <li>کارمند مورد نظر را انتخاب کنید</li>
                                        <li>نقش و مسئولیت‌های او را تعریف کنید</li>
                                        <li>روی <strong>ذخیره</strong> کلیک کنید</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 8 -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-indigo">
                                <div class="card-header bg-indigo text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-numeric-8-circle me-2"></i>
                                        مرحله هشتم: ثبت حضور و غیاب
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>حضور و غیاب کارمندان را ثبت کنید:</p>
                                    <ol>
                                        <li>از صفحه پروژه، روی <strong>حضور و غیاب</strong> کلیک کنید</li>
                                        <li>روی <strong>ثبت حضور جدید</strong> کلیک کنید</li>
                                        <li>تاریخ و ساعت ورود و خروج را وارد کنید</li>
                                        <li>توضیحات اضافی در صورت نیاز</li>
                                        <li>روی <strong>ذخیره</strong> کلیک کنید</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-check-circle me-2"></i>
                                        گام‌های بعدی
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>حالا که سیستم را راه‌اندازی کرده‌اید، می‌توانید:</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li>از داشبورد برای مشاهده آمار کلی استفاده کنید</li>
                                                <li>گزارش‌های پروژه را بررسی کنید</li>
                                                <li>حضور و غیاب را به صورت منظم ثبت کنید</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li>اطلاعات کارمندان و مشتریان را به‌روزرسانی کنید</li>
                                                <li>پروژه‌های جدید ایجاد کنید</li>
                                                <li>تنظیمات سیستم را شخصی‌سازی کنید</li>
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
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                <i class="mdi mdi-view-dashboard me-1"></i>
                                رفتن به داشبورد
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-purple {
    border-color: #6f42c1 !important;
}

.bg-purple {
    background-color: #6f42c1 !important;
}

.border-indigo {
    border-color: #6610f2 !important;
}

.bg-indigo {
    background-color: #6610f2 !important;
}
</style>
@endsection
