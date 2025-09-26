@extends('admin.layout')

@section('title', 'راهنمای سیستم مدیریت پروژه')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item active">راهنما</li>
                    </ol>
                </div>
                <h4 class="page-title">راهنمای سیستم مدیریت پروژه</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="text-primary">به سیستم مدیریت پروژه خوش آمدید</h2>
                        <p class="text-muted">راهنمای کامل برای استفاده از تمامی امکانات سیستم</p>
                    </div>

                    <div class="row">
                        <!-- Getting Started -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center">
                                    <div class="avatar-sm mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-primary text-white font-size-18">
                                            <i class="mdi mdi-rocket-launch"></i>
                                        </span>
                                    </div>
                                    <h5 class="card-title">شروع کار</h5>
                                    <p class="card-text text-muted">راهنمای گام به گام برای شروع کار با سیستم</p>
                                    <a href="{{ route('admin.help.getting-started') }}" class="btn btn-primary btn-sm">مشاهده راهنما</a>
                                </div>
                            </div>
                        </div>

                        <!-- Dashboard -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-info h-100">
                                <div class="card-body text-center">
                                    <div class="avatar-sm mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-info text-white font-size-18">
                                            <i class="mdi mdi-view-dashboard"></i>
                                        </span>
                                    </div>
                                    <h5 class="card-title">داشبورد</h5>
                                    <p class="card-text text-muted">آشنایی با داشبورد و آمارهای کلی</p>
                                    <a href="{{ route('admin.help.dashboard') }}" class="btn btn-info btn-sm">مشاهده راهنما</a>
                                </div>
                            </div>
                        </div>

                        <!-- Employees -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-success h-100">
                                <div class="card-body text-center">
                                    <div class="avatar-sm mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-success text-white font-size-18">
                                            <i class="mdi mdi-account-group"></i>
                                        </span>
                                    </div>
                                    <h5 class="card-title">مدیریت کارمندان</h5>
                                    <p class="card-text text-muted">راهنمای کامل مدیریت اطلاعات کارمندان</p>
                                    <a href="{{ route('admin.help.employees') }}" class="btn btn-success btn-sm">مشاهده راهنما</a>
                                </div>
                            </div>
                        </div>

                        <!-- Projects -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-warning h-100">
                                <div class="card-body text-center">
                                    <div class="avatar-sm mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-warning text-white font-size-18">
                                            <i class="mdi mdi-folder-multiple"></i>
                                        </span>
                                    </div>
                                    <h5 class="card-title">مدیریت پروژه‌ها</h5>
                                    <p class="card-text text-muted">راهنمای ایجاد و مدیریت پروژه‌ها</p>
                                    <a href="{{ route('admin.help.projects') }}" class="btn btn-warning btn-sm">مشاهده راهنما</a>
                                </div>
                            </div>
                        </div>

                        <!-- Clients -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-danger h-100">
                                <div class="card-body text-center">
                                    <div class="avatar-sm mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-danger text-white font-size-18">
                                            <i class="mdi mdi-account-tie"></i>
                                        </span>
                                    </div>
                                    <h5 class="card-title">مدیریت مشتریان</h5>
                                    <p class="card-text text-muted">راهنمای مدیریت اطلاعات مشتریان</p>
                                    <a href="{{ route('admin.help.clients') }}" class="btn btn-danger btn-sm">مشاهده راهنما</a>
                                </div>
                            </div>
                        </div>

                        <!-- Attendance -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-secondary h-100">
                                <div class="card-body text-center">
                                    <div class="avatar-sm mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-secondary text-white font-size-18">
                                            <i class="mdi mdi-clock-check"></i>
                                        </span>
                                    </div>
                                    <h5 class="card-title">مدیریت حضور و غیاب</h5>
                                    <p class="card-text text-muted">راهنمای ثبت و مدیریت حضور و غیاب</p>
                                    <a href="{{ route('admin.help.attendance') }}" class="btn btn-secondary btn-sm">مشاهده راهنما</a>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Accounts -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-dark h-100">
                                <div class="card-body text-center">
                                    <div class="avatar-sm mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-dark text-white font-size-18">
                                            <i class="mdi mdi-bank"></i>
                                        </span>
                                    </div>
                                    <h5 class="card-title">حساب‌های بانکی</h5>
                                    <p class="card-text text-muted">راهنمای مدیریت حساب‌های بانکی کارمندان</p>
                                    <a href="{{ route('admin.help.bank-accounts') }}" class="btn btn-dark btn-sm">مشاهده راهنما</a>
                                </div>
                            </div>
                        </div>

                        <!-- Project Employees -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-purple h-100">
                                <div class="card-body text-center">
                                    <div class="avatar-sm mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-purple text-white font-size-18">
                                            <i class="mdi mdi-account-multiple-plus"></i>
                                        </span>
                                    </div>
                                    <h5 class="card-title">تخصیص کارمندان به پروژه</h5>
                                    <p class="card-text text-muted">راهنمای تخصیص کارمندان به پروژه‌ها</p>
                                    <a href="{{ route('admin.help.project-employees') }}" class="btn btn-purple btn-sm">مشاهده راهنما</a>
                                </div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-indigo h-100">
                                <div class="card-body text-center">
                                    <div class="avatar-sm mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-indigo text-white font-size-18">
                                            <i class="mdi mdi-cog"></i>
                                        </span>
                                    </div>
                                    <h5 class="card-title">تنظیمات سیستم</h5>
                                    <p class="card-text text-muted">راهنمای تنظیمات و پیکربندی سیستم</p>
                                    <a href="{{ route('admin.help.settings') }}" class="btn btn-indigo btn-sm">مشاهده راهنما</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Tips Section -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card border-light">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">نکات مهم و سریع</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="list-unstyled">
                                                <li class="mb-2">
                                                    <i class="mdi mdi-check-circle text-success me-2"></i>
                                                    برای شروع کار ابتدا اطلاعات شرکت را در بخش تنظیمات تکمیل کنید
                                                </li>
                                                <li class="mb-2">
                                                    <i class="mdi mdi-check-circle text-success me-2"></i>
                                                    قبل از ایجاد پروژه، کارمندان و مشتریان را اضافه کنید
                                                </li>
                                                <li class="mb-2">
                                                    <i class="mdi mdi-check-circle text-success me-2"></i>
                                                    حساب‌های بانکی کارمندان را برای پرداخت حقوق تنظیم کنید
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-unstyled">
                                                <li class="mb-2">
                                                    <i class="mdi mdi-check-circle text-success me-2"></i>
                                                    از داشبورد برای مشاهده آمار کلی استفاده کنید
                                                </li>
                                                <li class="mb-2">
                                                    <i class="mdi mdi-check-circle text-success me-2"></i>
                                                    حضور و غیاب را به صورت روزانه ثبت کنید
                                                </li>
                                                <li class="mb-2">
                                                    <i class="mdi mdi-check-circle text-success me-2"></i>
                                                    گزارش‌های پروژه را به صورت منظم بررسی کنید
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

.btn-purple {
    background-color: #6f42c1;
    border-color: #6f42c1;
    color: white;
}

.btn-purple:hover {
    background-color: #5a32a3;
    border-color: #5a32a3;
    color: white;
}

.border-indigo {
    border-color: #6610f2 !important;
}

.bg-indigo {
    background-color: #6610f2 !important;
}

.btn-indigo {
    background-color: #6610f2;
    border-color: #6610f2;
    color: white;
}

.btn-indigo:hover {
    background-color: #520dc2;
    border-color: #520dc2;
    color: white;
}
</style>
@endsection
