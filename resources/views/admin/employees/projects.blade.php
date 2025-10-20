@extends('admin.layout')

@section('title', 'پروژه‌های پرسنل - ' . $employee->full_name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-project-diagram text-primary mr-2"></i>
                        پروژه‌های پرسنل
                    </h1>
                    <p class="text-muted mb-0">{{ $employee->full_name }} - {{ $employee->employee_code }}</p>
                </div>
                <div>
                    <a href="{{ route('panel.employees.profile', $employee) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right mr-1"></i>
                        بازگشت به پروفایل
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects List -->
    <div class="row">
        @if($projects->count() > 0)
            @foreach($projects as $projectEmployee)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                     style="width: 50px; height: 50px; font-size: 20px; font-weight: bold;">
                                    {{ substr($projectEmployee->project->name, 0, 1) }}
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0 text-dark">{{ $projectEmployee->project->name }}</h5>
                                    <small class="text-muted">پروژه</small>
                                </div>
                                <div>
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
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-building text-muted mr-2"></i>
                                    <span class="text-muted small">مشتری</span>
                                </div>
                                <p class="mb-0 font-weight-bold text-dark">
                                    {{ $projectEmployee->project->client->name ?? 'نامشخص' }}
                                </p>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar text-muted mr-2"></i>
                                    <span class="text-muted small">تاریخ شروع</span>
                                </div>
                                <p class="mb-0 font-weight-bold text-dark">
                                    {{ \App\Helpers\DateHelper::toPersianDate($projectEmployee->created_at) }}
                                </p>
                            </div>

                            @if($projectEmployee->project->description)
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-info-circle text-muted mr-2"></i>
                                        <span class="text-muted small">توضیحات</span>
                                    </div>
                                    <p class="mb-0 text-muted small">
                                        {{ Str::limit($projectEmployee->project->description, 120) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('panel.projects.show', $projectEmployee->project) }}"
                                       class="btn btn-outline-primary btn-block">
                                        <i class="fas fa-eye mr-1"></i>
                                        مشاهده
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('panel.employees.attendance', $employee) }}?project_id={{ $projectEmployee->project->id }}"
                                       class="btn btn-outline-success btn-block">
                                        <i class="fas fa-calendar-check mr-1"></i>
                                        حضور و غیاب
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-project-diagram fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">هیچ پروژه‌ای یافت نشد</h4>
                        <p class="text-muted mb-4">این پرسنل در هیچ پروژه‌ای شرکت ندارد.</p>
                        <a href="{{ route('panel.employees.profile', $employee) }}" class="btn btn-primary">
                            <i class="fas fa-arrow-right mr-1"></i>
                            بازگشت به پروفایل
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
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

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.btn-outline-primary:hover,
.btn-outline-success:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}
</style>
@endsection
