@extends('admin.layout')

@section('title', 'داشبورد - راهنمای سیستم مدیریت پروژه')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panel.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('panel.help.index') }}">راهنما</a></li>
                        <li class="breadcrumb-item active">داشبورد</li>
                    </ol>
                </div>
                <h4 class="page-title">راهنمای داشبورد</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="text-primary">داشبورد سیستم</h2>
                        <p class="text-muted">راهنمای کامل برای استفاده از داشبورد و آمارهای کلی سیستم</p>
                    </div>

                    <!-- Dashboard Overview -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-view-dashboard me-2"></i>
                                        نمای کلی داشبورد
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>داشبورد مرکز کنترل سیستم مدیریت پروژه است که آمارهای مهم و دسترسی سریع به بخش‌های مختلف را فراهم می‌کند.</p>

                                    <h6>بخش‌های اصلی داشبورد:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>آمار کلی:</strong> تعداد کارمندان، پروژه‌ها، مشتریان</li>
                                                <li><strong>نمودارها:</strong> نمایش گرافیکی آمارها</li>
                                                <li><strong>فعالیت‌های اخیر:</strong> آخرین تغییرات سیستم</li>
                                                <li><strong>اعلان‌ها:</strong> هشدارها و یادآوری‌ها</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>دسترسی سریع:</strong> لینک‌های مهم</li>
                                                <li><strong>گزارش‌های فوری:</strong> آمارهای کلیدی</li>
                                                <li><strong>وضعیت سیستم:</strong> سلامت سیستم</li>
                                                <li><strong>تقویم:</strong> رویدادهای مهم</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-chart-box me-2"></i>
                                        کارت‌های آمار
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>آمارهای نمایش داده شده:</h6>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <div class="card border-info">
                                                <div class="card-body text-center">
                                                    <i class="mdi mdi-account-group text-info font-size-24"></i>
                                                    <h6 class="mt-2">کارمندان</h6>
                                                    <p class="text-muted">تعداد کل کارمندان فعال</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card border-warning">
                                                <div class="card-body text-center">
                                                    <i class="mdi mdi-folder-multiple text-warning font-size-24"></i>
                                                    <h6 class="mt-2">پروژه‌ها</h6>
                                                    <p class="text-muted">تعداد پروژه‌های فعال</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card border-danger">
                                                <div class="card-body text-center">
                                                    <i class="mdi mdi-account-tie text-danger font-size-24"></i>
                                                    <h6 class="mt-2">مشتریان</h6>
                                                    <p class="text-muted">تعداد مشتریان</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card border-secondary">
                                                <div class="card-body text-center">
                                                    <i class="mdi mdi-clock-check text-secondary font-size-24"></i>
                                                    <h6 class="mt-2">حضور امروز</h6>
                                                    <p class="text-muted">کارمندان حاضر</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts and Graphs -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-chart-line me-2"></i>
                                        نمودارها و گراف‌ها
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>انواع نمودارهای موجود:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>نمودار پیشرفت پروژه‌ها:</strong> درصد تکمیل پروژه‌ها</li>
                                                <li><strong>نمودار حضور کارمندان:</strong> آمار حضور ماهانه</li>
                                                <li><strong>نمودار درآمد:</strong> درآمد پروژه‌ها</li>
                                                <li><strong>نمودار هزینه‌ها:</strong> هزینه‌های پروژه‌ها</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>نمودار توزیع کارمندان:</strong> بر اساس پروژه</li>
                                                <li><strong>نمودار وضعیت پروژه‌ها:</strong> فعال، تکمیل شده</li>
                                                <li><strong>نمودار عملکرد:</strong> کارایی تیم‌ها</li>
                                                <li><strong>نمودار زمانی:</strong> زمان صرف شده</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mt-3">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>نکته:</strong> نمودارها به صورت خودکار به‌روزرسانی می‌شوند و می‌توانید بازه زمانی آن‌ها را تغییر دهید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-lightning-bolt me-2"></i>
                                        اقدامات سریع
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>دسترسی سریع به عملیات مهم:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>افزودن کارمند جدید:</strong> ثبت کارمند</li>
                                                <li><strong>ایجاد پروژه جدید:</strong> شروع پروژه</li>
                                                <li><strong>ثبت حضور:</strong> حضور و غیاب</li>
                                                <li><strong>افزودن مشتری:</strong> ثبت مشتری</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>گزارش روزانه:</strong> آمار امروز</li>
                                                <li><strong>تنظیمات:</strong> پیکربندی سیستم</li>
                                                <li><strong>پشتیبان‌گیری:</strong> بک‌آپ داده‌ها</li>
                                                <li><strong>راهنما:</strong> کمک و راهنمایی</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-history me-2"></i>
                                        فعالیت‌های اخیر
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>نمایش آخرین تغییرات:</h6>
                                    <ul>
                                        <li><strong>ورود کاربران:</strong> آخرین ورودها به سیستم</li>
                                        <li><strong>تغییرات داده‌ها:</strong> ویرایش اطلاعات</li>
                                        <li><strong>ایجاد رکوردهای جدید:</strong> افزودن اطلاعات</li>
                                        <li><strong>گزارش‌های تولید شده:</strong> گزارش‌های جدید</li>
                                        <li><strong>خطاهای سیستم:</strong> مشکلات و هشدارها</li>
                                    </ul>

                                    <div class="alert alert-secondary mt-3">
                                        <i class="mdi mdi-information me-2"></i>
                                        <strong>راهنمایی:</strong> فعالیت‌های اخیر به شما کمک می‌کند تا از تغییرات سیستم مطلع باشید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-bell me-2"></i>
                                        اعلان‌ها و هشدارها
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>انواع اعلان‌ها:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>هشدارهای امنیتی:</strong> ورودهای مشکوک</li>
                                                <li><strong>یادآوری‌ها:</strong> کارهای مهم</li>
                                                <li><strong>اعلان‌های سیستم:</strong> بروزرسانی‌ها</li>
                                                <li><strong>هشدارهای عملکرد:</strong> مشکلات سیستم</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>اعلان‌های پروژه:</strong> مهلت‌های مهم</li>
                                                <li><strong>یادآوری حضور:</strong> ثبت حضور</li>
                                                <li><strong>هشدارهای مالی:</strong> بودجه پروژه‌ها</li>
                                                <li><strong>اعلان‌های پشتیبان‌گیری:</strong> بک‌آپ</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customization -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-dark">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-palette me-2"></i>
                                        شخصی‌سازی داشبورد
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>امکانات شخصی‌سازی:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>انتخاب ویجت‌ها:</strong> نمایش یا مخفی کردن بخش‌ها</li>
                                                <li><strong>تغییر ترتیب:</strong> چیدمان عناصر</li>
                                                <li><strong>انتخاب نمودارها:</strong> نوع نمودارهای نمایشی</li>
                                                <li><strong>تنظیم بازه زمانی:</strong> دوره آمارها</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>انتخاب رنگ‌ها:</strong> تم رنگی</li>
                                                <li><strong>تنظیم اعلان‌ها:</strong> نوع و فرکانس</li>
                                                <li><strong>انتخاب زبان:</strong> زبان رابط کاربری</li>
                                                <li><strong>ذخیره تنظیمات:</strong> حفظ تنظیمات شخصی</li>
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
                                            <h6>استفاده از داشبورد:</h6>
                                            <ul>
                                                <li>روزانه داشبورد را بررسی کنید</li>
                                                <li>آمارها را تحلیل کنید</li>
                                                <li>از اعلان‌ها غافل نشوید</li>
                                                <li>داشبورد را شخصی‌سازی کنید</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>مدیریت:</h6>
                                            <ul>
                                                <li>گزارش‌ها را منظم بررسی کنید</li>
                                                <li>مشکلات را سریع حل کنید</li>
                                                <li>از نمودارها برای تصمیم‌گیری استفاده کنید</li>
                                                <li>تنظیمات را به‌روز نگه دارید</li>
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
                            <a href="{{ route('panel.dashboard') }}" class="btn btn-primary">
                                <i class="mdi mdi-view-dashboard me-1"></i>
                                مشاهده داشبورد
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
