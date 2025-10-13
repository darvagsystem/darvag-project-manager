@extends('admin.layout')

@section('title', 'مدیریت پروژه‌ها - راهنمای سیستم مدیریت پروژه')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panel.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('panel.help.index') }}">راهنما</a></li>
                        <li class="breadcrumb-item active">مدیریت پروژه‌ها</li>
                    </ol>
                </div>
                <h4 class="page-title">راهنمای مدیریت پروژه‌ها</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="text-primary">مدیریت پروژه‌ها</h2>
                        <p class="text-muted">راهنمای کامل برای ایجاد و مدیریت پروژه‌ها در سیستم</p>
                    </div>

                    <!-- Creating Projects -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-folder-plus me-2"></i>
                                        ایجاد پروژه جدید
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>مراحل ایجاد پروژه:</h6>
                                    <ol>
                                        <li>از منوی اصلی <strong>پروژه‌ها</strong> را انتخاب کنید</li>
                                        <li>روی دکمه <strong>افزودن پروژه جدید</strong> کلیک کنید</li>
                                        <li>فرم اطلاعات پروژه را تکمیل کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات اصلی:</h6>
                                            <ul>
                                                <li><strong>نام پروژه:</strong> عنوان پروژه</li>
                                                <li><strong>توضیحات:</strong> شرح کامل پروژه</li>
                                                <li><strong>مشتری:</strong> انتخاب از لیست مشتریان</li>
                                                <li><strong>اولویت:</strong> بالا، متوسط، پایین</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>اطلاعات زمانی و مالی:</h6>
                                            <ul>
                                                <li><strong>تاریخ شروع:</strong> تاریخ شروع پروژه</li>
                                                <li><strong>تاریخ پایان:</strong> تاریخ تحویل پروژه</li>
                                                <li><strong>بودجه:</strong> مبلغ کل پروژه</li>
                                                <li><strong>وضعیت:</strong> در حال انجام، تکمیل شده و...</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mt-3">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> قبل از ایجاد پروژه، حتماً مشتری مربوطه را در سیستم اضافه کنید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Project Status Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-flag me-2"></i>
                                        مدیریت وضعیت پروژه
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>وضعیت‌های مختلف پروژه:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>برنامه‌ریزی:</strong> پروژه در مرحله برنامه‌ریزی</li>
                                                <li><strong>در حال انجام:</strong> پروژه در حال اجرا</li>
                                                <li><strong>متوقف شده:</strong> پروژه موقتاً متوقف</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>تکمیل شده:</strong> پروژه به پایان رسیده</li>
                                                <li><strong>لغو شده:</strong> پروژه لغو شده</li>
                                                <li><strong>در انتظار تایید:</strong> منتظر تایید مشتری</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-warning">
                                        <i class="mdi mdi-alert me-2"></i>
                                        <strong>توجه:</strong> تغییر وضعیت پروژه بر روی دسترسی‌ها و گزارش‌ها تأثیر می‌گذارد.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Project Team Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-group me-2"></i>
                                        مدیریت تیم پروژه
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>افزودن کارمند به پروژه:</h6>
                                    <ol>
                                        <li>از صفحه پروژه، روی <strong>کارمندان پروژه</strong> کلیک کنید</li>
                                        <li>روی <strong>افزودن کارمند</strong> کلیک کنید</li>
                                        <li>کارمند مورد نظر را از لیست انتخاب کنید</li>
                                        <li>نقش و مسئولیت‌های او را تعریف کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>نقش‌های رایج:</h6>
                                            <ul>
                                                <li><strong>مدیر پروژه:</strong> مسئول کلی پروژه</li>
                                                <li><strong>توسعه‌دهنده:</strong> برنامه‌نویس</li>
                                                <li><strong>طراح:</strong> طراح UI/UX</li>
                                                <li><strong>تست‌کننده:</strong> مسئول تست</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>تنظیمات:</h6>
                                            <ul>
                                                <li><strong>تاریخ شروع:</strong> شروع همکاری</li>
                                                <li><strong>تاریخ پایان:</strong> پایان همکاری</li>
                                                <li><strong>ساعت کاری:</strong> ساعت‌های اختصاص یافته</li>
                                                <li><strong>وضعیت:</strong> فعال یا غیرفعال</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-success mt-3">
                                        <i class="mdi mdi-lightbulb me-2"></i>
                                        <strong>راهنمایی:</strong> هر کارمند می‌تواند در چندین پروژه همزمان شرکت کند.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-clock-check me-2"></i>
                                        مدیریت حضور و غیاب پروژه
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>ثبت حضور و غیاب:</h6>
                                    <ol>
                                        <li>از صفحه پروژه، روی <strong>حضور و غیاب</strong> کلیک کنید</li>
                                        <li>روی <strong>ثبت حضور جدید</strong> کلیک کنید</li>
                                        <li>اطلاعات حضور را وارد کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات حضور:</h6>
                                            <ul>
                                                <li><strong>کارمند:</strong> انتخاب کارمند</li>
                                                <li><strong>تاریخ:</strong> تاریخ حضور</li>
                                                <li><strong>ساعت ورود:</strong> زمان شروع کار</li>
                                                <li><strong>ساعت خروج:</strong> زمان پایان کار</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>جزئیات اضافی:</h6>
                                            <ul>
                                                <li><strong>ساعت کاری:</strong> محاسبه خودکار</li>
                                                <li><strong>توضیحات:</strong> یادداشت‌های اضافی</li>
                                                <li><strong>نوع حضور:</strong> عادی، اضافه‌کاری</li>
                                                <li><strong>وضعیت:</strong> تایید شده یا در انتظار</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> سیستم به صورت خودکار ساعت کاری روزانه را محاسبه می‌کند.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Project Reports -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-chart-line me-2"></i>
                                        گزارش‌های پروژه
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>انواع گزارش‌های موجود:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>گزارش پیشرفت:</strong> درصد تکمیل پروژه</li>
                                                <li><strong>گزارش حضور:</strong> آمار حضور کارمندان</li>
                                                <li><strong>گزارش مالی:</strong> هزینه‌های پروژه</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>گزارش زمانی:</strong> زمان صرف شده</li>
                                                <li><strong>گزارش تیم:</strong> عملکرد اعضای تیم</li>
                                                <li><strong>گزارش کلی:</strong> خلاصه کامل پروژه</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-secondary">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>راهنمایی:</strong> گزارش‌ها به صورت PDF قابل دانلود هستند و می‌توانید آن‌ها را برای مشتری ارسال کنید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Project Timeline -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-dark">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-timeline me-2"></i>
                                        مدیریت زمان‌بندی پروژه
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>نکات مهم در زمان‌بندی:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li>تاریخ شروع و پایان واقعی تعیین کنید</li>
                                                <li>زمان‌های اضافی برای مشکلات احتمالی در نظر بگیرید</li>
                                                <li>مراحل مختلف پروژه را تعریف کنید</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li>وظایف را به اعضای تیم تخصیص دهید</li>
                                                <li>پیشرفت پروژه را به‌روزرسانی کنید</li>
                                                <li>هشدارهای زمانی تنظیم کنید</li>
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
                                            <h6>مدیریت پروژه:</h6>
                                            <ul>
                                                <li>اهداف پروژه را به وضوح تعریف کنید</li>
                                                <li>تیم مناسب را انتخاب کنید</li>
                                                <li>پیشرفت را به صورت منظم بررسی کنید</li>
                                                <li>با مشتری ارتباط منظم داشته باشید</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>کنترل کیفیت:</h6>
                                            <ul>
                                                <li>مراحل تست را تعریف کنید</li>
                                                <li>بازخورد مشتری را دریافت کنید</li>
                                                <li>مستندات را به‌روز نگه دارید</li>
                                                <li>درس‌های آموخته را ثبت کنید</li>
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
                            <a href="{{ route('panel.help.index') }}" class="btn btn-secondary me-2">
                                <i class="mdi mdi-arrow-right me-1"></i>
                                بازگشت به راهنما
                            </a>
                            <a href="{{ route('panel.projects.index') }}" class="btn btn-primary">
                                <i class="mdi mdi-folder-multiple me-1"></i>
                                مدیریت پروژه‌ها
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
