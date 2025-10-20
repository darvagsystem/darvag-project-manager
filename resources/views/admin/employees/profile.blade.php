@extends('admin.layout')

@section('title', 'پروفایل پرسنل - ' . $employee->full_name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-user-circle text-primary mr-2"></i>
                        پروفایل پرسنل
                    </h1>
                    <p class="text-muted mb-0">{{ $employee->full_name }} - {{ $employee->employee_code }}</p>
                </div>
                <div>
                    <a href="{{ route('panel.employees.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right mr-1"></i>
                        بازگشت به لیست پرسنل
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Profile Card -->
    <div class="row mb-4">
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-4">
                        @if($employee->avatar && $employee->avatar !== 'default-avatar.png')
                            <img src="{{ asset('storage/avatars/' . $employee->avatar) }}"
                                 alt="{{ $employee->full_name }}"
                                 class="rounded-circle shadow-sm"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-gradient-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm"
                                 style="width: 120px; height: 120px; font-size: 48px; font-weight: bold;">
                                {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h4 class="mb-2 text-dark">{{ $employee->full_name }}</h4>
                    <p class="text-muted mb-3">{{ $employee->employee_code }}</p>
                    <span class="badge badge-{{ $employee->status === 'active' ? 'success' : 'danger' }} px-3 py-2">
                        <i class="fas fa-circle mr-1"></i>
                        {{ $employee->status === 'active' ? 'فعال' : 'غیرفعال' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        اطلاعات شخصی
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">کد ملی</label>
                                <p class="mb-0 font-weight-bold">{{ $employee->national_code }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small">وضعیت تأهل</label>
                                <p class="mb-0 font-weight-bold">
                                    @switch($employee->marital_status)
                                        @case('single') مجرد @break
                                        @case('married') متأهل @break
                                        @case('divorced') مطلقه @break
                                        @case('widowed') بیوه @break
                                        @default نامشخص @break
                                    @endswitch
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">تحصیلات</label>
                                <p class="mb-0 font-weight-bold">
                                    @switch($employee->education)
                                        @case('diploma') دیپلم @break
                                        @case('associate') فوق دیپلم @break
                                        @case('bachelor') لیسانس @break
                                        @case('master') فوق لیسانس @break
                                        @case('phd') دکترا @break
                                        @default نامشخص @break
                                    @endswitch
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small">تاریخ استخدام</label>
                                <p class="mb-0 font-weight-bold">{{ \App\Helpers\DateHelper::toPersianDate($employee->created_at) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-white-50 small">پروژه‌های فعال</div>
                            <div class="h4 mb-0">{{ $totalProjects }}</div>
                        </div>
                        <div class="ml-3">
                            <i class="fas fa-project-diagram fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-white-50 small">روزهای حضور</div>
                            <div class="h4 mb-0">{{ $presentDays }}</div>
                        </div>
                        <div class="ml-3">
                            <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-white-50 small">کل حضور و غیاب</div>
                            <div class="h4 mb-0">{{ $totalAttendance }}</div>
                        </div>
                        <div class="ml-3">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-white-50 small">درصد حضور</div>
                            <div class="h4 mb-0">
                                {{ $totalAttendance > 0 ? round(($presentDays / $totalAttendance) * 100, 1) : 0 }}%
                            </div>
                        </div>
                        <div class="ml-3">
                            <i class="fas fa-percentage fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-tools text-primary mr-2"></i>
                        عملیات سریع
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('panel.employees.projects', $employee) }}" class="btn btn-outline-primary btn-block h-100 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <i class="fas fa-project-diagram fa-2x mb-2 d-block"></i>
                                    <span>مشاهده پروژه‌ها</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('panel.employees.attendance', $employee) }}" class="btn btn-outline-success btn-block h-100 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <i class="fas fa-calendar-check fa-2x mb-2 d-block"></i>
                                    <span>حضور و غیاب</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('panel.employees.attendance.report', $employee) }}" class="btn btn-outline-info btn-block h-100 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <i class="fas fa-chart-bar fa-2x mb-2 d-block"></i>
                                    <span>گزارش حضور و غیاب</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('panel.employees.bank-accounts', $employee) }}" class="btn btn-outline-warning btn-block h-100 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <i class="fas fa-credit-card fa-2x mb-2 d-block"></i>
                                    <span>حساب‌های بانکی</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-project-diagram text-primary mr-2"></i>
                        پروژه‌های اخیر
                    </h5>
                </div>
                <div class="card-body">
                    @if($projects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">نام پروژه</th>
                                        <th class="border-0">وضعیت</th>
                                        <th class="border-0">تاریخ شروع</th>
                                        <th class="border-0 text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projects->take(5) as $projectEmployee)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                         style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">
                                                        {{ substr($projectEmployee->project->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold text-dark">{{ $projectEmployee->project->name }}</div>
                                                        <small class="text-muted">پروژه</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                @if($projectEmployee->project->status === 'active')
                                                    <span class="badge badge-success px-3 py-2" style="background-color: #28a745; color: white;">
                                                        <i class="fas fa-circle mr-1"></i>
                                                        فعال
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary px-3 py-2" style="background-color: #6c757d; color: white;">
                                                        <i class="fas fa-circle mr-1"></i>
                                                        غیرفعال
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-muted">{{ \App\Helpers\DateHelper::toPersianDate($projectEmployee->created_at) }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('panel.projects.show', $projectEmployee->project) }}"
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="مشاهده پروژه">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($projects->count() > 5)
                            <div class="text-center mt-3">
                                <a href="{{ route('panel.employees.projects', $employee) }}" class="btn btn-primary">
                                    <i class="fas fa-list mr-1"></i>
                                    مشاهده همه پروژه‌ها
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">هیچ پروژه‌ای یافت نشد</h5>
                            <p class="text-muted">این پرسنل در هیچ پروژه‌ای شرکت ندارد.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.table th {
    font-weight: 600;
    color: #495057;
    background-color: #f8f9fa;
}

.table td {
    vertical-align: middle;
}

.badge {
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.8rem;
    text-shadow: none;
}

.badge-success {
    background-color: #28a745 !important;
    color: white !important;
    border: none;
}

.badge-secondary {
    background-color: #6c757d !important;
    color: white !important;
    border: none;
}

.badge-success:hover,
.badge-secondary:hover {
    opacity: 0.9;
    transform: scale(1.05);
    transition: all 0.2s ease;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.btn-outline-primary:hover,
.btn-outline-success:hover,
.btn-outline-info:hover,
.btn-outline-warning:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}
</style>
@endsection
