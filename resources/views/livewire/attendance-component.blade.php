<div class="attendance-container">
    <!-- Header -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="mdi mdi-account-clock me-2"></i>
                حضور و غیاب کارکنان - {{ $project->name }}
            </h3>
            <div class="card-tools">
                <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-right me-1"></i>
                    بازگشت به پروژه
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">تاریخ</label>
                    <input type="date" wire:model.live="selectedDate" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">جستجو</label>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                           placeholder="جستجو بر اساس نام، نام خانوادگی یا کد پرسنلی...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button wire:click="loadData" class="btn btn-primary w-100">
                        <i class="mdi mdi-refresh"></i>
                        بروزرسانی
                    </button>
                </div>
            </div>

            <!-- Bulk Actions -->
            @if($showBulkActions)
                <div class="alert alert-info d-flex justify-content-between align-items-center">
                    <span>
                        <i class="mdi mdi-information me-2"></i>
                        {{ count($selectedEmployees) }} کارمند انتخاب شده
                    </span>
                    <div class="btn-group">
                        <button wire:click="bulkMarkPresent" class="btn btn-success btn-sm">
                            <i class="mdi mdi-check me-1"></i>
                            حضور
                        </button>
                        <button wire:click="bulkMarkAbsent" class="btn btn-danger btn-sm">
                            <i class="mdi mdi-close me-1"></i>
                            غیبت
                        </button>
                        <button wire:click="bulkMarkLate" class="btn btn-warning btn-sm">
                            <i class="mdi mdi-clock-alert me-1"></i>
                            تأخیر
                        </button>
                        <button wire:click="clearSelection" class="btn btn-secondary btn-sm">
                            <i class="mdi mdi-close-circle me-1"></i>
                            لغو انتخاب
                        </button>
                    </div>
                </div>
            @endif

            <!-- Flash Messages -->
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll"
                                       class="form-check-input">
                            </th>
                            <th>کد پرسنلی</th>
                            <th>نام و نام خانوادگی</th>
                            <th>وضعیت</th>
                            <th>ورود</th>
                            <th>خروج</th>
                            <th>یادداشت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            @php
                                $attendance = $attendances->get($employee->id);
                                $status = $attendance ? $attendance->status : null;
                                $isSelected = $this->isEmployeeSelected($employee->id);
                            @endphp
                            <tr class="{{ $isSelected ? 'table-primary' : '' }}">
                                <td>
                                    <input type="checkbox"
                                           wire:click="toggleEmployeeSelection({{ $employee->id }})"
                                           {{ $isSelected ? 'checked' : '' }}
                                           class="form-check-input">
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $employee->employee_code }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2">
                                            <span class="avatar-title text-primary">
                                                {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong>
                                            @if($employee->position)
                                                <br><small class="text-muted">{{ $employee->position }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($status)
                                        <span class="badge bg-{{ $status === 'present' ? 'success' : ($status === 'absent' ? 'danger' : 'warning') }}">
                                            {{ $status === 'present' ? 'حاضر' : ($status === 'absent' ? 'غایب' : 'تأخیر') }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark">ثبت نشده</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance && $attendance->check_in_time)
                                        <input type="time"
                                               wire:change="updateCheckIn({{ $employee->id }}, $event.target.value)"
                                               value="{{ $attendance->check_in_time }}"
                                               class="form-control form-control-sm">
                                    @else
                                        <input type="time"
                                               wire:change="updateCheckIn({{ $employee->id }}, $event.target.value)"
                                               class="form-control form-control-sm">
                                    @endif
                                </td>
                                <td>
                                    @if($attendance && $attendance->check_out_time)
                                        <input type="time"
                                               wire:change="updateCheckOut({{ $employee->id }}, $event.target.value)"
                                               value="{{ $attendance->check_out_time }}"
                                               class="form-control form-control-sm">
                                    @else
                                        <input type="time"
                                               wire:change="updateCheckOut({{ $employee->id }}, $event.target.value)"
                                               class="form-control form-control-sm">
                                    @endif
                                </td>
                                <td>
                                    <input type="text"
                                           wire:change="addNote({{ $employee->id }}, $event.target.value)"
                                           value="{{ $attendance ? $attendance->notes : '' }}"
                                           placeholder="یادداشت..."
                                           class="form-control form-control-sm">
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if(!$attendance)
                                            <button wire:click="toggleAttendance({{ $employee->id }})"
                                                    class="btn btn-success btn-sm" title="حضور">
                                                <i class="mdi mdi-check"></i>
                                            </button>
                                        @else
                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item"
                                                           wire:click="updateStatus({{ $employee->id }}, 'present')">
                                                            <i class="mdi mdi-check text-success me-2"></i>
                                                            حضور
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                           wire:click="updateStatus({{ $employee->id }}, 'absent')">
                                                            <i class="mdi mdi-close text-danger me-2"></i>
                                                            غیبت
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                           wire:click="updateStatus({{ $employee->id }}, 'late')">
                                                            <i class="mdi mdi-clock-alert text-warning me-2"></i>
                                                            تأخیر
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item text-danger"
                                                           wire:click="toggleAttendance({{ $employee->id }})"
                                                           onclick="return confirm('آیا مطمئن هستید؟')">
                                                            <i class="mdi mdi-delete me-2"></i>
                                                            حذف
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="mdi mdi-account-off display-4 d-block mb-3"></i>
                                        هیچ کارمندی یافت نشد
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            @if($employees->count() > 0)
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h4>{{ $attendances->where('status', 'present')->count() }}</h4>
                                <p class="mb-0">حاضر</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <h4>{{ $attendances->where('status', 'absent')->count() }}</h4>
                                <p class="mb-0">غایب</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h4>{{ $attendances->where('status', 'late')->count() }}</h4>
                                <p class="mb-0">تأخیر</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light text-dark">
                            <div class="card-body text-center">
                                <h4>{{ $employees->count() - $attendances->count() }}</h4>
                                <p class="mb-0">ثبت نشده</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.attendance-container {
    padding: 20px;
}

.avatar-sm {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.table-responsive {
    max-height: 70vh;
    overflow-y: auto;
}

.table th {
    position: sticky;
    top: 0;
    background: white;
    z-index: 10;
}

.btn-group .btn {
    margin-right: 2px;
}

.alert {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table-primary {
    background-color: rgba(13, 110, 253, 0.1) !important;
}

.form-control-sm {
    font-size: 0.875rem;
    padding: 0.25rem 0.5rem;
}

.dropdown-menu {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.badge {
    font-size: 0.75em;
}
</style>
@endpush
