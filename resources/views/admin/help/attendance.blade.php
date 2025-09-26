@extends('admin.layout')

@section('title', 'مدیریت حضور و غیاب - راهنمای سیستم مدیریت پروژه')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.help') }}">راهنما</a></li>
                        <li class="breadcrumb-item active">حضور و غیاب</li>
                    </ol>
                </div>
                <h4 class="page-title">راهنمای مدیریت حضور و غیاب</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="text-primary">مدیریت حضور و غیاب</h2>
                        <p class="text-muted">راهنمای کامل برای ثبت و مدیریت حضور و غیاب کارمندان در پروژه‌ها</p>
                    </div>

                    <!-- Recording Attendance -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-clock-in me-2"></i>
                                        ثبت حضور و غیاب
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>مراحل ثبت حضور:</h6>
                                    <ol>
                                        <li>از صفحه پروژه، روی <strong>حضور و غیاب</strong> کلیک کنید</li>
                                        <li>روی <strong>ثبت حضور جدید</strong> کلیک کنید</li>
                                        <li>فرم حضور را تکمیل کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات اصلی:</h6>
                                            <ul>
                                                <li><strong>کارمند:</strong> انتخاب از لیست کارمندان پروژه</li>
                                                <li><strong>تاریخ:</strong> تاریخ حضور</li>
                                                <li><strong>ساعت ورود:</strong> زمان شروع کار</li>
                                                <li><strong>ساعت خروج:</strong> زمان پایان کار</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>جزئیات اضافی:</h6>
                                            <ul>
                                                <li><strong>نوع حضور:</strong> عادی، اضافه‌کاری، نیمه‌وقت</li>
                                                <li><strong>توضیحات:</strong> یادداشت‌های اضافی</li>
                                                <li><strong>وضعیت:</strong> تایید شده یا در انتظار</li>
                                                <li><strong>ساعت کاری:</strong> محاسبه خودکار</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mt-3">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> سیستم به صورت خودکار ساعت کاری روزانه را بر اساس ورود و خروج محاسبه می‌کند.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Types -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-flag me-2"></i>
                                        انواع حضور و غیاب
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>انواع مختلف حضور:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>حضور عادی:</strong> حضور در ساعات معمول کار</li>
                                                <li><strong>اضافه‌کاری:</strong> کار بیش از ساعات عادی</li>
                                                <li><strong>نیمه‌وقت:</strong> حضور کمتر از ساعات عادی</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>غیبت موجه:</strong> غیبت با دلیل موجه</li>
                                                <li><strong>غیبت غیرموجه:</strong> غیبت بدون دلیل</li>
                                                <li><strong>مرخصی:</strong> مرخصی رسمی</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-warning">
                                        <i class="mdi mdi-alert me-2"></i>
                                        <strong>توجه:</strong> هر نوع حضور تأثیر متفاوتی بر محاسبه حقوق و پاداش دارد.
                                    </div>
                                </div>
                            </div>
                        </div>
    </div>

                    <!-- Daily Attendance -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-calendar me-2"></i>
                                        مشاهده حضور روزانه
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>مشاهده حضور روزانه:</h6>
                                    <ol>
                                        <li>از صفحه حضور و غیاب، روی <strong>تاریخ مورد نظر</strong> کلیک کنید</li>
                                        <li>لیست حضور تمام کارمندان در آن تاریخ نمایش داده می‌شود</li>
                                        <li>می‌توانید حضور هر کارمند را ویرایش یا حذف کنید</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات نمایش داده شده:</h6>
                                            <ul>
                                                <li>نام کارمند</li>
                                                <li>ساعت ورود و خروج</li>
                                                <li>ساعت کاری روزانه</li>
                                                <li>نوع حضور</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>امکانات موجود:</h6>
                                            <ul>
                                                <li>ویرایش حضور</li>
                                                <li>حذف حضور</li>
                                                <li>تایید حضور</li>
                                                <li>چاپ گزارش</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Reports -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-chart-line me-2"></i>
                                        گزارش‌های حضور و غیاب
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>انواع گزارش‌های موجود:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>گزارش روزانه:</strong> حضور در یک روز خاص</li>
                                                <li><strong>گزارش هفتگی:</strong> حضور در یک هفته</li>
                                                <li><strong>گزارش ماهانه:</strong> حضور در یک ماه</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>گزارش کارمند:</strong> حضور یک کارمند خاص</li>
                                                <li><strong>گزارش پروژه:</strong> حضور در یک پروژه</li>
                                                <li><strong>گزارش کلی:</strong> آمار کلی حضور</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>راهنمایی:</strong> گزارش‌ها به صورت PDF قابل دانلود هستند و می‌توانید آن‌ها را چاپ کنید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Rules -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-rule me-2"></i>
                                        قوانین حضور و غیاب
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>قوانین مهم:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li>حضور باید روزانه ثبت شود</li>
                                                <li>ساعت ورود نباید از ساعت خروج بیشتر باشد</li>
                                                <li>ساعت کاری عادی ۸ ساعت است</li>
                                                <li>اضافه‌کاری بیش از ۴ ساعت نیاز به تایید دارد</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li>غیبت باید با دلیل ثبت شود</li>
                                                <li>مرخصی باید از قبل درخواست شود</li>
                                                <li>تغییرات حضور نیاز به تایید دارد</li>
                                                <li>گزارش‌ها باید ماهانه بررسی شوند</li>
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
                                            <h6>ثبت حضور:</h6>
                                            <ul>
                                                <li>حضور را به صورت روزانه ثبت کنید</li>
                                                <li>اطلاعات را دقیق و کامل وارد کنید</li>
                                                <li>تغییرات را به موقع اعمال کنید</li>
                                                <li>از سیستم خودکار استفاده کنید</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>مدیریت:</h6>
                                            <ul>
                                                <li>گزارش‌ها را منظم بررسی کنید</li>
                                                <li>قوانین را به کارمندان اعلام کنید</li>
                                                <li>مشکلات را سریع حل کنید</li>
                                                <li>آمارها را تحلیل کنید</li>
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
                            <a href="{{ route('projects.index') }}" class="btn btn-primary">
                                <i class="mdi mdi-clock-check me-1"></i>
                                مدیریت حضور و غیاب
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
