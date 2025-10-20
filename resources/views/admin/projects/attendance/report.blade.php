@extends('admin.layout')

@section('title', 'گزارش حضور و غیاب - ' . $project->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-2"></i>
                        گزارش حضور و غیاب - {{ $project->name }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('panel.projects.attendance.index', $project) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-calendar-check mr-1"></i>
                            حضور و غیاب روزانه
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Date Range Selection -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('panel.projects.attendance.report', $project) }}" class="form-inline">
                                <div class="form-group mr-3">
                                    <label for="start_date" class="mr-2">از تاریخ:</label>
                                    <input type="text"
                                           class="form-control"
                                           id="start_date"
                                           name="start_date"
                                           value="{{ $startDate }}"
                                           placeholder="1403/01/01"
                                           dir="rtl"
                                           required>
                                </div>
                                <div class="form-group mr-3">
                                    <label for="end_date" class="mr-2">تا تاریخ:</label>
                                    <input type="text"
                                           class="form-control"
                                           id="end_date"
                                           name="end_date"
                                           value="{{ $endDate }}"
                                           placeholder="1403/01/01"
                                           dir="rtl"
                                           required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search mr-1"></i>
                                    نمایش گزارش
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 text-left">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success" onclick="exportToExcel()">
                                    <i class="fas fa-file-excel mr-1"></i>
                                    خروجی Excel
                                </button>
                                <a href="{{ route('panel.projects.attendance.report.print', $project) }}?start_date={{ $startDate }}&end_date={{ $endDate }}"
                                   class="btn btn-info" target="_blank">
                                    <i class="fas fa-print mr-1"></i>
                                    چاپ گزارش
                                </a>
                            </div>
                        </div>
                    </div>

                    @if(count($statistics) > 0)
                        <!-- Summary Statistics -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-chart-pie mr-2"></i>
                                            خلاصه آمار دوره {{ $startDate }} تا {{ $endDate }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-primary">
                                                        <i class="fas fa-users"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">تعداد کارمندان</span>
                                                        <span class="info-box-number">{{ count($statistics) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-success">
                                                        <i class="fas fa-calendar-check"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">روزهای کاری</span>
                                                        <span class="info-box-number">{{ $statistics->first()['total_days'] ?? 0 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-info">
                                                        <i class="fas fa-clock"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">میانگین حضور</span>
                                                        <span class="info-box-number">
                                                            {{ round($statistics->avg('attendance_rate'), 1) }}%
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-warning">
                                                        <i class="fas fa-chart-line"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">مجموع ساعات کاری</span>
                                                        <span class="info-box-number">
                                                            {{ round($statistics->sum('total_working_hours') / 60, 1) }} ساعت
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Statistics Table -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-table mr-2"></i>
                                            آمار تفصیلی کارمندان
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover" id="attendanceReportTable">
                                                <thead>
                                                    <tr>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">نام و نام خانوادگی</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">کد پرسنلی</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">روزهای حاضر</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">روزهای غایب</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">تأخیر</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">نیم روز</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">مرخصی</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">درصد حضور</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">مجموع ساعات</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">میانگین ساعات</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">مجموع اضافه کاری</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">میانگین اضافه کاری</th>
                                                        <th style="background-color: #2c3e50; color: white; font-weight: bold;">عملیات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($statistics as $stat)
                                                        <tr>
                                                            <td><strong>{{ $stat['employee']->full_name }}</strong></td>
                                                            <td><span class="badge badge-info" style="font-size: 0.9em; padding: 8px 12px;">{{ $stat['employee']->employee_code }}</span></td>
                                                            <td>
                                                                <span class="badge badge-success" style="font-size: 0.9em; padding: 8px 12px;">
                                                                    {{ $stat['present_days'] }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-danger" style="font-size: 0.9em; padding: 8px 12px;">
                                                                    {{ $stat['absent_days'] }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-warning" style="font-size: 0.9em; padding: 8px 12px;">
                                                                    {{ $stat['late_days'] }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-info" style="font-size: 0.9em; padding: 8px 12px;">
                                                                    {{ $stat['half_days'] }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-primary" style="font-size: 0.9em; padding: 8px 12px;">
                                                                    {{ $stat['vacation_days'] + $stat['sick_leave_days'] }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge {{ $stat['attendance_rate'] >= 90 ? 'badge-success' : ($stat['attendance_rate'] >= 70 ? 'badge-warning' : 'badge-danger') }}" style="font-size: 0.9em; padding: 8px 12px;">
                                                                    {{ $stat['attendance_rate'] }}%
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-primary" style="font-size: 0.9em; padding: 8px 12px;">
                                                                    {{ round($stat['total_working_hours'] / 60, 1) }} ساعت
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-info" style="font-size: 0.9em; padding: 8px 12px;">
                                                                    {{ round($stat['average_working_hours'] / 60, 1) }} ساعت
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-warning" style="font-size: 0.9em; padding: 8px 12px;">
                                                                    {{ round($stat['total_overtime_hours'], 1) }} ساعت
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-secondary" style="font-size: 0.9em; padding: 8px 12px;">
                                                                    {{ round($stat['average_overtime_hours'], 1) }} ساعت
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm btn-outline-primary" onclick="showEmployeeDetails({{ $stat['employee']->id }})">
                                                                    <i class="fas fa-eye"></i>
                                                                    جزئیات
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Details Modal -->
                        <div class="modal fade" id="employeeDetailsModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">جزئیات حضور و غیاب</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="employeeDetailsContent">
                                            <!-- Content will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            برای بازه زمانی انتخاب شده هیچ اطلاعاتی یافت نشد.
                        </div>
                    @endif
                </div>
            </div>
        </div>
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
    .form-control {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 8px 12px;
    }

    .form-control:focus {
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

<script>
function showEmployeeDetails(employeeId) {
    // This would load employee details via AJAX
    $('#employeeDetailsModal').modal('show');
}

function exportToExcel() {
    // This would export the table to Excel
    alert('قابلیت خروجی Excel در حال توسعه است.');
}

</script>
@endsection
