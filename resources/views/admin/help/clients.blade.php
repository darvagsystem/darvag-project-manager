@extends('admin.layout')

@section('title', 'مدیریت مشتریان - راهنمای سیستم مدیریت پروژه')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panel.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('panel.help.index') }}">راهنما</a></li>
                        <li class="breadcrumb-item active">مدیریت مشتریان</li>
                    </ol>
                </div>
                <h4 class="page-title">راهنمای مدیریت مشتریان</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="text-primary">مدیریت مشتریان</h2>
                        <p class="text-muted">راهنمای کامل برای مدیریت اطلاعات مشتریان و ارتباطات</p>
                    </div>

                    <!-- Adding Clients -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-plus me-2"></i>
                                        افزودن مشتری جدید
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>مراحل افزودن مشتری:</h6>
                                    <ol>
                                        <li>از منوی اصلی <strong>مشتریان</strong> را انتخاب کنید</li>
                                        <li>روی دکمه <strong>افزودن مشتری جدید</strong> کلیک کنید</li>
                                        <li>فرم اطلاعات مشتری را تکمیل کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات اصلی:</h6>
                                            <ul>
                                                <li><strong>نام شرکت/شخص:</strong> نام کامل مشتری</li>
                                                <li><strong>نوع مشتری:</strong> شرکت یا شخص حقیقی</li>
                                                <li><strong>کد ملی/شناسه ملی:</strong> شناسه رسمی</li>
                                                <li><strong>وب‌سایت:</strong> آدرس وب‌سایت</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>اطلاعات تماس:</h6>
                                            <ul>
                                                <li><strong>آدرس:</strong> آدرس کامل</li>
                                                <li><strong>شماره تلفن:</strong> شماره تماس اصلی</li>
                                                <li><strong>ایمیل:</strong> آدرس ایمیل</li>
                                                <li><strong>توضیحات:</strong> اطلاعات اضافی</li>
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

                    <!-- Client Contacts Management -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-multiple me-2"></i>
                                        مدیریت اطلاعات تماس
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>افزودن اطلاعات تماس:</h6>
                                    <ol>
                                        <li>از لیست مشتریان، روی <strong>اطلاعات تماس</strong> کلیک کنید</li>
                                        <li>روی <strong>افزودن تماس جدید</strong> کلیک کنید</li>
                                        <li>اطلاعات تماس را وارد کنید:</li>
                                    </ol>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>اطلاعات شخص:</h6>
                                            <ul>
                                                <li><strong>نام:</strong> نام شخص</li>
                                                <li><strong>نام خانوادگی:</strong> نام خانوادگی</li>
                                                <li><strong>سمت:</strong> موقعیت شغلی</li>
                                                <li><strong>دپارتمان:</strong> بخش مربوطه</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>اطلاعات تماس:</h6>
                                            <ul>
                                                <li><strong>شماره تلفن:</strong> شماره تماس</li>
                                                <li><strong>ایمیل:</strong> آدرس ایمیل</li>
                                                <li><strong>موبایل:</strong> شماره موبایل</li>
                                                <li><strong>وضعیت:</strong> فعال یا غیرفعال</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-success mt-3">
                                        <i class="mdi mdi-lightbulb me-2"></i>
                                        <strong>راهنمایی:</strong> هر مشتری می‌تواند چندین نفر به عنوان مسئول تماس داشته باشد.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Client Projects -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-folder-multiple me-2"></i>
                                        پروژه‌های مشتری
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>مشاهده پروژه‌های مشتری:</h6>
                                    <ol>
                                        <li>از صفحه مشتری، روی <strong>پروژه‌ها</strong> کلیک کنید</li>
                                        <li>لیست تمام پروژه‌های مربوط به این مشتری نمایش داده می‌شود</li>
                                        <li>می‌توانید وضعیت، پیشرفت و جزئیات هر پروژه را مشاهده کنید</li>
                                    </ol>

                                    <div class="alert alert-warning">
                                        <i class="mdi mdi-alert me-2"></i>
                                        <strong>توجه:</strong> برای ایجاد پروژه جدید برای این مشتری، از بخش پروژه‌ها استفاده کنید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Client Communication -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-message me-2"></i>
                                        ارتباط با مشتری
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>نکات مهم در ارتباط با مشتری:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li>اطلاعات تماس را به‌روز نگه دارید</li>
                                                <li>پاسخ‌دهی سریع به درخواست‌ها</li>
                                                <li>گزارش‌های منظم ارسال کنید</li>
                                                <li>انتظارات را مدیریت کنید</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li>مستندات پروژه را به اشتراک بگذارید</li>
                                                <li>جلسات منظم برگزار کنید</li>
                                                <li>بازخورد دریافت کنید</li>
                                                <li>رابطه بلندمدت برقرار کنید</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Client Categories -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-tag me-2"></i>
                                        دسته‌بندی مشتریان
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>انواع مشتریان:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>مشتریان VIP:</strong> مشتریان مهم و پرتکرار</li>
                                                <li><strong>مشتریان عادی:</strong> مشتریان معمولی</li>
                                                <li><strong>مشتریان بالقوه:</strong> مشتریان آینده</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>مشتریان قدیمی:</strong> مشتریان با سابقه طولانی</li>
                                                <li><strong>مشتریان جدید:</strong> مشتریان تازه</li>
                                                <li><strong>مشتریان غیرفعال:</strong> مشتریان بدون فعالیت</li>
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
                                                <li>اطلاعات مشتری را کامل و دقیق ثبت کنید</li>
                                                <li>تاریخچه ارتباطات را نگه دارید</li>
                                                <li>اطلاعات تماس را به‌روز نگه دارید</li>
                                                <li>مستندات مهم را آرشیو کنید</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>رابطه با مشتری:</h6>
                                            <ul>
                                                <li>ارتباط منظم و حرفه‌ای داشته باشید</li>
                                                <li>نیازهای مشتری را درک کنید</li>
                                                <li>کیفیت خدمات را حفظ کنید</li>
                                                <li>رابطه بلندمدت برقرار کنید</li>
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
                            <a href="{{ route('panel.clients.index') }}" class="btn btn-primary">
                                <i class="mdi mdi-account-tie me-1"></i>
                                مدیریت مشتریان
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
