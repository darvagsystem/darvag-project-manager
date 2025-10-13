@extends('admin.layout')

@section('title', 'پروفایل کارمند - ' . $employee->first_name . ' ' . $employee->last_name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar-lg">
                                @if($employee->avatar && $employee->avatar !== 'default-avatar.png')
                                    <img src="{{ asset('storage/avatars/' . $employee->avatar) }}"
                                         alt="Avatar" class="rounded-circle img-thumbnail" width="80" height="80">
                                @else
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 80px; height: 80px; font-size: 2rem;">
                                        {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <h2 class="mb-1">{{ $employee->first_name }} {{ $employee->last_name }}</h2>
                            <p class="text-muted mb-2">کد پرسنلی: {{ $employee->employee_code }}</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ $employee->status === 'active' ? 'فعال' : 'غیرفعال' }}
                                </span>
                                <span class="badge bg-info">{{ ucfirst($employee->marital_status) }}</span>
                                <span class="badge bg-warning">{{ ucfirst($employee->education) }}</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('panel.employees.edit', $employee) }}" class="btn btn-primary">
                                <i class="mdi mdi-pencil me-1"></i>
                                ویرایش
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->

    <!-- Content Tabs -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="employeeTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab"
                                    data-bs-target="#info" type="button" role="tab">
                                <i class="mdi mdi-information me-1"></i>
                                اطلاعات شخصی
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="projects-tab" data-bs-toggle="tab"
                                    data-bs-target="#projects" type="button" role="tab">
                                <i class="mdi mdi-folder me-1"></i>
                                پروژه‌ها
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bank-tab" data-bs-toggle="tab"
                                    data-bs-target="#bank" type="button" role="tab">
                                <i class="mdi mdi-bank me-1"></i>
                                حساب‌های بانکی
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="documents-tab" data-bs-toggle="tab"
                                    data-bs-target="#documents" type="button" role="tab">
                                <i class="mdi mdi-file-document me-1"></i>
                                مدارک
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="employeeTabsContent">
                        <!-- اطلاعات شخصی -->
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>اطلاعات پایه</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>نام:</strong></td>
                                            <td>{{ $employee->first_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>نام خانوادگی:</strong></td>
                                            <td>{{ $employee->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>کد ملی:</strong></td>
                                            <td>{{ $employee->national_code }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>تاریخ تولد:</strong></td>
                                            <td>{{ $employee->birth_date }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>وضعیت تأهل:</strong></td>
                                            <td>{{ ucfirst($employee->marital_status) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>تحصیلات:</strong></td>
                                            <td>{{ ucfirst($employee->education) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>اطلاعات تماس</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>تلفن:</strong></td>
                                            <td>{{ $employee->phone ?? 'ثبت نشده' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>موبایل:</strong></td>
                                            <td>{{ $employee->mobile ?? 'ثبت نشده' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>ایمیل:</strong></td>
                                            <td>{{ $employee->email ?? 'ثبت نشده' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>آدرس:</strong></td>
                                            <td>{{ $employee->address ?? 'ثبت نشده' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>تاریخ استخدام:</strong></td>
                                            <td>{{ $employee->hire_date ?? 'ثبت نشده' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>وضعیت:</strong></td>
                                            <td>
                                                <span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ $employee->status === 'active' ? 'فعال' : 'غیرفعال' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <!-- پروژه‌ها -->
                        <div class="tab-pane fade" id="projects" role="tabpanel">
                            <h5>پروژه‌های فعال</h5>
                            @if($activeProjects->count() > 0)
                                <div class="row">
                                    @foreach($activeProjects as $project)
                                        <div class="col-md-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        <a href="{{ route('panel.projects.show', $project) }}" class="text-decoration-none">
                                                            {{ $project->name }}
                                                        </a>
                                                    </h6>
                                                    <p class="card-text text-muted">{{ $project->description }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge bg-primary">{{ $project->status }}</span>
                                                        <small class="text-muted">
                                                            شروع: {{ \Carbon\Carbon::parse($project->start_date)->format('Y/m/d') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="mdi mdi-information me-2"></i>
                                    هیچ پروژه فعالی یافت نشد.
                                </div>
                            @endif
                        </div>

                        <!-- حساب‌های بانکی -->
                        <div class="tab-pane fade" id="bank" role="tabpanel">
                            <h5>حساب‌های بانکی</h5>
                            @if($bankAccounts->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>بانک</th>
                                                <th>شماره حساب</th>
                                                <th>شماره شبا</th>
                                                <th>نوع حساب</th>
                                                <th>وضعیت</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($bankAccounts as $account)
                                                <tr>
                                                    <td>{{ $account->bank->name ?? 'نامشخص' }}</td>
                                                    <td>{{ $account->account_number }}</td>
                                                    <td>{{ $account->sheba_number ?? '-' }}</td>
                                                    <td>{{ ucfirst($account->account_type) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $account->is_active ? 'success' : 'secondary' }}">
                                                            {{ $account->is_active ? 'فعال' : 'غیرفعال' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="mdi mdi-information me-2"></i>
                                    هیچ حساب بانکی ثبت نشده است.
                                </div>
                            @endif
                        </div>

                        <!-- مدارک -->
                        <div class="tab-pane fade" id="documents" role="tabpanel">
                            <h5>مدارک</h5>
                            @if($documents->count() > 0)
                                <div class="row">
                                    @foreach($documents as $document)
                                        <div class="col-md-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $document->title }}</h6>
                                                    <p class="card-text text-muted">{{ $document->description }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge bg-info">{{ $document->type }}</span>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($document->created_at)->format('Y/m/d') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="mdi mdi-information me-2"></i>
                                    هیچ مدرکی ثبت نشده است.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-lg img {
    object-fit: cover;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.nav-tabs .nav-link {
    border: none;
    border-bottom: 2px solid transparent;
}

.nav-tabs .nav-link.active {
    border-bottom-color: #007bff;
    background: none;
}

.table-borderless td {
    border: none;
    padding: 0.5rem 0;
}

.badge {
    font-size: 0.75em;
}
</style>
@endpush
