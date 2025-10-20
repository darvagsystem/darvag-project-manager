@extends('admin.layout')

@section('title', 'حضور و غیاب پرسنل - ' . $employee->full_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-check mr-2"></i>
                            حضور و غیاب پرسنل - {{ $employee->full_name }}
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('panel.employees.profile', $employee) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-right mr-1"></i>
                                بازگشت به پروفایل
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter mr-2"></i>
                        فیلترها
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('panel.employees.attendance', $employee) }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="project_id">پروژه:</label>
                                    <select name="project_id" id="project_id" class="form-control">
                                        <option value="">همه پروژه‌ها</option>
                                        @foreach($projects as $projectEmployee)
                                            <option value="{{ $projectEmployee->project->id }}"
                                                    {{ $projectId == $projectEmployee->project->id ? 'selected' : '' }}>
                                                {{ $projectEmployee->project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">از تاریخ:</label>
                                    <input type="text"
                                           name="start_date"
                                           id="start_date"
                                           class="form-control"
                                           value="{{ $startDate }}"
                                           placeholder="1404/07/01"
                                           dir="rtl">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">تا تاریخ:</label>
                                    <input type="text"
                                           name="end_date"
                                           id="end_date"
                                           class="form-control"
                                           value="{{ $endDate }}"
                                           placeholder="1404/07/23"
                                           dir="rtl">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search mr-1"></i>
                                            جستجو
                                        </button>
                                        <a href="{{ route('panel.employees.attendance.report', $employee) }}?project_id={{ $projectId }}&start_date={{ $startDate }}&end_date={{ $endDate }}"
                                           class="btn btn-info">
                                            <i class="fas fa-chart-bar mr-1"></i>
                                            گزارش
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics -->
            <div class="row mt-4">
                <div class="col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">کل روزها</span>
                            <span class="info-box-number">{{ $statistics['total_days'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-success">
                            <i class="fas fa-check"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">حاضر</span>
                            <span class="info-box-number">{{ $statistics['present_days'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">غایب</span>
                            <span class="info-box-number">{{ $statistics['absent_days'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">تأخیر</span>
                            <span class="info-box-number">{{ $statistics['late_days'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info">
                            <i class="fas fa-percentage"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">درصد حضور</span>
                            <span class="info-box-number">{{ $statistics['attendance_rate'] }}%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary">
                            <i class="fas fa-clock"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">ساعات کاری</span>
                            <span class="info-box-number">{{ round($statistics['total_working_hours'] / 60, 1) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Records -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>
                        سوابق حضور و غیاب
                    </h5>
                </div>
                <div class="card-body">
                    @if($attendanceRecords->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>تاریخ</th>
                                        <th>پروژه</th>
                                        <th>وضعیت</th>
                                        <th>ساعت ورود</th>
                                        <th>ساعت خروج</th>
                                        <th>ساعات کاری</th>
                                        <th>اضافه کاری</th>
                                        <th>یادداشت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendanceRecords as $record)
                                        <tr>
                                            <td>{{ $record->persian_date }}</td>
                                            <td>{{ $record->project->name ?? 'نامشخص' }}</td>
                                            <td>
                                                @switch($record->status)
                                                    @case('present')
                                                        <span class="badge badge-success">حاضر</span>
                                                        @break
                                                    @case('absent')
                                                        <span class="badge badge-danger">غایب</span>
                                                        @break
                                                    @case('late')
                                                        <span class="badge badge-warning">تأخیر</span>
                                                        @break
                                                    @case('half_day')
                                                        <span class="badge badge-info">نیم روز</span>
                                                        @break
                                                    @case('vacation')
                                                        <span class="badge badge-primary">مرخصی</span>
                                                        @break
                                                    @case('sick_leave')
                                                        <span class="badge badge-secondary">مرخصی استعلاجی</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $record->check_in_time ? $record->check_in_time->format('H:i') : '-' }}</td>
                                            <td>{{ $record->check_out_time ? $record->check_out_time->format('H:i') : '-' }}</td>
                                            <td>{{ $record->working_hours ? round($record->working_hours / 60, 1) . ' ساعت' : '-' }}</td>
                                            <td>{{ $record->overtime_hours ? round($record->overtime_hours, 1) . ' ساعت' : '-' }}</td>
                                            <td>{{ $record->notes ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            برای بازه زمانی انتخاب شده هیچ سابقه حضور و غیابی یافت نشد.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
