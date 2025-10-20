<div>
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-calendar-check text-primary mr-2"></i>
                        حضور و غیاب پرسنل
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

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-0">
            <h5 class="card-title mb-0 text-dark">
                <i class="fas fa-filter text-primary mr-2"></i>
                فیلترها
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="projectId" class="text-muted small">پروژه:</label>
                        <select wire:model.live="projectId" id="projectId" class="form-control">
                            <option value="">همه پروژه‌ها</option>
                            @foreach($projects as $projectEmployee)
                                <option value="{{ $projectEmployee->project->id }}">
                                    {{ $projectEmployee->project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="startDate" class="text-muted small">از تاریخ:</label>
                        <input type="text"
                               wire:model.live="startDate"
                               id="startDate"
                               class="form-control"
                               placeholder="1404/07/01"
                               dir="rtl">
                        @error('startDate') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="endDate" class="text-muted small">تا تاریخ:</label>
                        <input type="text"
                               wire:model.live="endDate"
                               id="endDate"
                               class="form-control"
                               placeholder="1404/07/23"
                               dir="rtl">
                        @error('endDate') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-muted small">&nbsp;</label>
                        <div>
                            <a href="{{ route('panel.employees.attendance.report', $employee) }}?project_id={{ $projectId }}&start_date={{ $startDate }}&end_date={{ $endDate }}"
                               class="btn btn-info btn-block">
                                <i class="fas fa-chart-bar mr-1"></i>
                                گزارش
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-primary text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ $statistics['total_days'] ?? 0 }}</div>
                    <div class="text-white-50 small">کل روزها</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-success text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ $statistics['present_days'] ?? 0 }}</div>
                    <div class="text-white-50 small">حاضر</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-danger text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ $statistics['absent_days'] ?? 0 }}</div>
                    <div class="text-white-50 small">غایب</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-warning text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ $statistics['late_days'] ?? 0 }}</div>
                    <div class="text-white-50 small">تأخیر</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-info text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-percentage fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ $statistics['attendance_rate'] ?? 0 }}%</div>
                    <div class="text-white-50 small">درصد حضور</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-secondary text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-hourglass-half fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ round(($statistics['total_working_hours'] ?? 0) / 60, 1) }}</div>
                    <div class="text-white-50 small">ساعات کاری</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="text-center py-5">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="sr-only">در حال بارگذاری...</span>
        </div>
        <p class="mt-3 text-muted">در حال بارگذاری...</p>
    </div>

    <!-- Attendance Records -->
    <div class="card shadow-sm" wire:loading.remove>
        <div class="card-header bg-white border-0">
            <h5 class="card-title mb-0 text-dark">
                <i class="fas fa-list text-primary mr-2"></i>
                سوابق حضور و غیاب
                @if($totalRecords > 0)
                    <span class="badge badge-light ml-2">{{ $totalRecords }} رکورد</span>
                @endif
            </h5>
        </div>
        <div class="card-body p-0">
            @if($attendanceRecords->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0 text-center">تاریخ</th>
                                <th class="border-0">پروژه</th>
                                <th class="border-0 text-center">وضعیت</th>
                                <th class="border-0 text-center">ساعت ورود</th>
                                <th class="border-0 text-center">ساعت خروج</th>
                                <th class="border-0 text-center">ساعات کاری</th>
                                <th class="border-0 text-center">اضافه کاری</th>
                                <th class="border-0">یادداشت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceRecords as $record)
                                <tr>
                                    <td class="text-center align-middle">
                                        <span class="text-muted">{{ $record->persian_date }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-2"
                                                 style="width: 30px; height: 30px; font-size: 12px; font-weight: bold;">
                                                {{ substr($record->project->name ?? 'ن', 0, 1) }}
                                            </div>
                                            <span class="font-weight-bold">{{ $record->project->name ?? 'نامشخص' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($record->status === 'present')
                                            <span class="badge badge-success px-3 py-2" style="background-color: #28a745; color: white;">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                حاضر
                                            </span>
                                        @elseif($record->status === 'absent')
                                            <span class="badge badge-danger px-3 py-2" style="background-color: #dc3545; color: white;">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                غایب
                                            </span>
                                        @elseif($record->status === 'late')
                                            <span class="badge badge-warning px-3 py-2" style="background-color: #ffc107; color: #212529;">
                                                <i class="fas fa-clock mr-1"></i>
                                                تأخیر
                                            </span>
                                        @elseif($record->status === 'half_day')
                                            <span class="badge badge-info px-3 py-2" style="background-color: #17a2b8; color: white;">
                                                <i class="fas fa-clock mr-1"></i>
                                                نیم روز
                                            </span>
                                        @elseif($record->status === 'vacation')
                                            <span class="badge badge-primary px-3 py-2" style="background-color: #007bff; color: white;">
                                                <i class="fas fa-umbrella-beach mr-1"></i>
                                                مرخصی
                                            </span>
                                        @elseif($record->status === 'sick_leave')
                                            <span class="badge badge-secondary px-3 py-2" style="background-color: #6c757d; color: white;">
                                                <i class="fas fa-user-injured mr-1"></i>
                                                مرخصی استعلاجی
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($record->check_in_time)
                                            <span class="badge badge-light px-2 py-1">
                                                <i class="fas fa-sign-in-alt mr-1 text-success"></i>
                                                {{ $record->check_in_time->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($record->check_out_time)
                                            <span class="badge badge-light px-2 py-1">
                                                <i class="fas fa-sign-out-alt mr-1 text-danger"></i>
                                                {{ $record->check_out_time->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($record->working_hours)
                                            <span class="badge badge-light px-2 py-1">
                                                <i class="fas fa-clock mr-1 text-info"></i>
                                                {{ $this->getFormattedWorkingHours($record->working_hours) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($record->overtime_hours)
                                            <span class="badge badge-warning px-2 py-1" style="background-color: #ffc107; color: #212529;">
                                                <i class="fas fa-plus-circle mr-1"></i>
                                                {{ round($record->overtime_hours, 1) }} ساعت
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($record->notes)
                                            <span class="text-muted small">{{ Str::limit($record->notes, 30) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($this->getTotalPages() > 1)
                    <div class="d-flex justify-content-between align-items-center p-3 border-top">
                        <div>
                            <span class="text-muted small">
                                نمایش {{ (($currentPage - 1) * $perPage) + 1 }} تا {{ min($currentPage * $perPage, $totalRecords) }} از {{ $totalRecords }} رکورد
                            </span>
                        </div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                    <button class="page-link" wire:click="previousPage" {{ $currentPage == 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </li>

                                @for($i = max(1, $currentPage - 2); $i <= min($this->getTotalPages(), $currentPage + 2); $i++)
                                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                        <button class="page-link" wire:click="goToPage({{ $i }})">{{ $i }}</button>
                                    </li>
                                @endfor

                                <li class="page-item {{ $currentPage == $this->getTotalPages() ? 'disabled' : '' }}">
                                    <button class="page-link" wire:click="nextPage" {{ $currentPage == $this->getTotalPages() ? 'disabled' : '' }}>
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">هیچ سابقه‌ای یافت نشد</h5>
                    <p class="text-muted">برای بازه زمانی انتخاب شده هیچ سابقه حضور و غیابی یافت نشد.</p>
                </div>
            @endif
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

    .badge {
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .table th {
        font-weight: 600;
        color: #495057;
        background-color: #f8f9fa;
        border: none;
    }

    .table td {
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    .page-link {
        border-radius: 6px;
        margin: 0 2px;
        border: 1px solid #dee2e6;
    }

    .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .spinner-border {
        border-width: 3px;
    }
    </style>
</div>
