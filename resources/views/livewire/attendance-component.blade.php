<div>
    <!-- Header -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-calendar-check mr-2"></i>
                حضور و غیاب - {{ $project->name }}
                @if($persianDate)
                    <small class="text-muted">({{ $persianDate }})</small>
                @endif
            </h3>
            <div class="card-tools">
                <a href="{{ route('panel.projects.show', $project) }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-right mr-1"></i>
                    بازگشت به پروژه
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Date Selection -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="persianDateInput" class="form-label">انتخاب تاریخ (شمسی):</label>
                        <input type="text"
                               wire:model.live="persianDateInput"
                               class="form-control"
                               id="persianDateInput"
                               placeholder="1403/01/01"
                               dir="rtl">
                        <small class="form-text text-muted">تاریخ را به فرمت 1403/01/01 وارد کنید</small>
                    </div>
                </div>
                <div class="col-md-6 text-left">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success" wire:click="bulkUpdateStatus('present')">
                            <i class="fas fa-check mr-1"></i>
                            همه حاضر
                        </button>
                        <button type="button" class="btn btn-danger" wire:click="bulkUpdateStatus('absent')">
                            <i class="fas fa-times mr-1"></i>
                            همه غایب
                        </button>
                        <button type="button" class="btn btn-warning" wire:click="bulkUpdateStatus('late')">
                            <i class="fas fa-clock mr-1"></i>
                            همه تأخیر
                        </button>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #28a745;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fa-2x mr-3" style="color: #28a745;"></i>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-2" style="color: #155724; font-weight: bold;">
                                <i class="fas fa-calendar-check mr-2"></i>
                                ثبت موفقیت‌آمیز حضور و غیاب
                            </h5>
                            <div style="white-space: pre-line; color: #155724; font-size: 14px;">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #dc3545;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x mr-3" style="color: #dc3545;"></i>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-2" style="color: #721c24; font-weight: bold;">
                                <i class="fas fa-times-circle mr-2"></i>
                                خطا در ثبت حضور و غیاب
                            </h5>
                            <div style="color: #721c24; font-size: 14px;">
                                {{ session('error') }}
                            </div>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Existing Attendance Records -->
            @if(count($existingAttendance) > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-history mr-2"></i>
                                    حضور و غیاب ثبت شده
                                    @if($persianDate)
                                        برای {{ $persianDate }}
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #2c3e50; color: white; font-weight: bold;">نام و نام خانوادگی</th>
                                                <th style="background-color: #2c3e50; color: white; font-weight: bold;">کد پرسنلی</th>
                                                <th style="background-color: #2c3e50; color: white; font-weight: bold;">وضعیت</th>
                                                <th style="background-color: #2c3e50; color: white; font-weight: bold;">ساعت ورود</th>
                                                <th style="background-color: #2c3e50; color: white; font-weight: bold;">ساعت خروج</th>
                                                <th style="background-color: #2c3e50; color: white; font-weight: bold;">ساعات کاری</th>
                                                <th style="background-color: #2c3e50; color: white; font-weight: bold;">اضافه کاری</th>
                                                <th style="background-color: #2c3e50; color: white; font-weight: bold;">ساعات مفید</th>
                                                <th style="background-color: #2c3e50; color: white; font-weight: bold;">یادداشت</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($existingAttendance as $record)
                                                <tr>
                                                    <td><strong>{{ $record['employee']['full_name'] ?? 'نامشخص' }}</strong></td>
                                                    <td><span class="badge badge-info" style="font-size: 0.9em; padding: 8px 12px;">{{ $record['employee']['employee_code'] ?? 'نامشخص' }}</span></td>
                                                    <td>
                                                        <span class="badge badge-{{ $this->getStatusColor($record['status']) }}" style="font-size: 0.9em; padding: 8px 12px;">
                                                            {{ $this->getStatusText($record['status']) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $record['check_in_time'] ?: '-' }}</td>
                                                    <td>{{ $record['check_out_time'] ?: '-' }}</td>
                                                    <td>
                                                        <span class="badge badge-primary" style="font-size: 0.9em; padding: 8px 12px;">
                                                            {{ $this->getFormattedWorkingHours($record['working_hours'] ?? 0) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-warning" style="font-size: 0.9em; padding: 8px 12px;">
                                                            {{ $record['overtime_hours'] ?? 0 }} ساعت
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-success" style="font-size: 0.9em; padding: 8px 12px;">
                                                            {{ ($record['useful_hours'] ?? 8) + ($record['overtime_hours'] ?? 0) }} ساعت
                                                        </span>
                                                    </td>
                                                    <td>{{ $record['notes'] ?: '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Attendance Form -->
            <form wire:submit.prevent="saveAttendance">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                        <tr>
                                            <th width="12%" style="background-color: #2c3e50; color: white; font-weight: bold;">نام و نام خانوادگی</th>
                                            <th width="8%" style="background-color: #2c3e50; color: white; font-weight: bold;">کد پرسنلی</th>
                                            <th width="10%" style="background-color: #2c3e50; color: white; font-weight: bold;">وضعیت</th>
                                            <th width="10%" style="background-color: #2c3e50; color: white; font-weight: bold;">ساعت ورود</th>
                                            <th width="10%" style="background-color: #2c3e50; color: white; font-weight: bold;">ساعت خروج</th>
                                            <th width="10%" style="background-color: #2c3e50; color: white; font-weight: bold;">ساعات کاری</th>
                                            <th width="10%" style="background-color: #2c3e50; color: white; font-weight: bold;">اضافه کاری</th>
                                            <th width="10%" style="background-color: #2c3e50; color: white; font-weight: bold;">ساعات مفید</th>
                                            <th width="20%" style="background-color: #2c3e50; color: white; font-weight: bold;">یادداشت</th>
                                        </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceData as $index => $data)
                                    <tr>
                                        <td>
                                            <strong>{{ $data['employee_name'] }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-info" style="font-size: 0.9em; padding: 8px 12px;">{{ $data['employee_code'] }}</span>
                                        </td>
                                        <td>
                                            <select wire:model.live="attendanceData.{{ $index }}.status"
                                                    wire:change="updateStatus({{ $index }}, $event.target.value)"
                                                    class="form-control form-control-sm">
                                                <option value="present">حاضر</option>
                                                <option value="absent">غایب</option>
                                                <option value="late">تأخیر</option>
                                                <option value="half_day">نیم روز</option>
                                                <option value="vacation">مرخصی</option>
                                                <option value="sick_leave">مرخصی استعلاجی</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="time"
                                                   wire:model.live="attendanceData.{{ $index }}.check_in_time"
                                                   wire:change="updateTime({{ $index }}, 'check_in_time', $event.target.value)"
                                                   class="form-control form-control-sm"
                                                   value="{{ $data['check_in_time'] ?: '07:15' }}"
                                                   {{ $data['status'] == 'absent' ? 'disabled' : '' }}>
                                        </td>
                                        <td>
                                            <input type="time"
                                                   wire:model.live="attendanceData.{{ $index }}.check_out_time"
                                                   wire:change="updateTime({{ $index }}, 'check_out_time', $event.target.value)"
                                                   class="form-control form-control-sm"
                                                   value="{{ $data['check_out_time'] ?: '17:00' }}"
                                                   {{ $data['status'] == 'absent' ? 'disabled' : '' }}>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary" style="font-size: 0.9em; padding: 8px 12px;">
                                                {{ $this->getFormattedWorkingHours($data['working_hours'], $data['overtime'] ?? 0) }}
                                            </span>
                                        </td>
                                        <td>
                                            <input type="number"
                                                   wire:model.live="attendanceData.{{ $index }}.overtime_hours"
                                                   class="form-control form-control-sm"
                                                   placeholder="0"
                                                   min="0"
                                                   step="0.5">
                                        </td>
                                        <td>
                                            <span class="badge badge-success" style="font-size: 0.9em; padding: 8px 12px;">
                                                {{ ($data['useful_hours'] ?? 8) + ($data['overtime_hours'] ?? 0) }} ساعت
                                            </span>
                                        </td>
                                        <td>
                                            <input type="text"
                                                   wire:model="attendanceData.{{ $index }}.notes"
                                                   class="form-control form-control-sm"
                                                   placeholder="یادداشت...">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            هیچ کارمند فعالی در این پروژه یافت نشد.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(count($attendanceData) > 0)
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-save mr-2"></i>
                                    ثبت حضور و غیاب
                                </button>
                                <a href="{{ route('panel.projects.attendance.report', $project) }}" class="btn btn-info btn-lg mr-2">
                                    <i class="fas fa-chart-bar mr-2"></i>
                                    گزارش حضور و غیاب
                                </a>
                            </div>
                        </div>
                    @endif
                </form>

            <!-- Attendance Summary -->
            @if(count($existingAttendance) > 0)
                @php
                    $summary = $this->getAttendanceSummary();
                @endphp
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-pie mr-2"></i>
                                    خلاصه گزارش حضور و غیاب
                                    @if($persianDate)
                                        - {{ $persianDate }}
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-success">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">حاضر</span>
                                                <span class="info-box-number">{{ $summary['present'] ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-danger">
                                                <i class="fas fa-times"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">غایب</span>
                                                <span class="info-box-number">{{ $summary['absent'] ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-warning">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">تأخیر</span>
                                                <span class="info-box-number">{{ $summary['late'] ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-info">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">مرخصی</span>
                                                <span class="info-box-number">{{ ($summary['vacation'] ?? 0) + ($summary['sick_leave'] ?? 0) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-primary">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">مجموع ساعات کاری</span>
                                                <span class="info-box-number">
                                                    {{ $this->getFormattedWorkingHours($summary['total_working_hours'] ?? 0) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-warning">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">مجموع اضافه کاری</span>
                                                <span class="info-box-number">
                                                    {{ $this->getFormattedWorkingHours($summary['total_overtime'] ?? 0) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
</div>

    <style>
        /* Table Styling */
        .table {
            background-color: #fff;
            border-collapse: collapse;
            width: 100%;
        }

        .table th {
            background-color: #2c3e50 !important;
            color: white !important;
            border: 1px solid #34495e !important;
            padding: 12px 8px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .table td {
            border: 1px solid #dee2e6 !important;
            padding: 10px 8px;
            text-align: center;
            vertical-align: middle;
            background-color: #fff;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e3f2fd;
        }

        /* Badge Styling */
        .badge {
            font-size: 0.8em;
            padding: 6px 10px;
            border-radius: 4px;
            font-weight: 500;
        }

        .badge-success {
            background-color: #28a745 !important;
            color: white !important;
        }

        .badge-danger {
            background-color: #dc3545 !important;
            color: white !important;
        }

        .badge-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }

        .badge-info {
            background-color: #17a2b8 !important;
            color: white !important;
        }

        .badge-primary {
            background-color: #007bff !important;
            color: white !important;
        }

        .badge-secondary {
            background-color: #6c757d !important;
            color: white !important;
        }

        /* Form Controls */
        .form-control-sm {
            font-size: 0.875rem;
            padding: 6px 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .form-control-sm:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Button Group */
        .btn-group .btn {
            margin-right: 5px;
            border-radius: 4px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        /* Info Box */
        .info-box {
            display: block;
            min-height: 90px;
            background: #fff;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 6px;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
        }

        .info-box-icon {
            border-top-left-radius: 6px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 6px;
            display: block;
            float: left;
            height: 90px;
            width: 90px;
            text-align: center;
            font-size: 45px;
            line-height: 90px;
            color: white;
        }

        .info-box-icon.bg-success {
            background-color: #28a745 !important;
        }

        .info-box-icon.bg-danger {
            background-color: #dc3545 !important;
        }

        .info-box-icon.bg-warning {
            background-color: #ffc107 !important;
        }

        .info-box-icon.bg-info {
            background-color: #17a2b8 !important;
        }

        .info-box-icon.bg-primary {
            background-color: #007bff !important;
        }

        .info-box-content {
            padding: 15px 20px;
            margin-left: 90px;
        }

        .info-box-text {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .info-box-number {
            display: block;
            font-weight: bold;
            font-size: 24px;
            color: #2c3e50;
        }

        /* Card Styling */
        .card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            border-radius: 6px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 15px 20px;
        }

        .card-body {
            padding: 20px;
        }

        /* Alert Styling */
        .alert {
            border-radius: 6px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        /* Table Responsive */
        .table-responsive {
            border-radius: 6px;
            overflow: hidden;
        }

        /* Text Styling */
        .text-muted {
            color: #6c757d !important;
        }

        .text-center {
            text-align: center !important;
        }

        /* RTL Support */
        [dir="rtl"] .info-box-content {
            margin-left: 0;
            margin-right: 90px;
        }

        [dir="rtl"] .info-box-icon {
            float: right;
            border-top-left-radius: 0;
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
            border-bottom-left-radius: 0;
        }
    </style>
</div>
