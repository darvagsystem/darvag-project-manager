<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گزارش حضور و غیاب پرسنل - {{ $employee->full_name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tahoma', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #fff;
            direction: rtl;
        }

        .print-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            border: 2px solid #000;
            background: #f8f9fa;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #000;
        }

        .header h2 {
            font-size: 18px;
            font-weight: normal;
            color: #333;
            margin-bottom: 10px;
        }

        .header .company-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .header .date-range {
            font-size: 14px;
            color: #000;
            font-weight: bold;
        }

        .summary-section {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px solid #000;
            background: #f9f9f9;
        }

        .summary-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            color: #000;
        }

        .summary-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .summary-row {
            display: table-row;
        }

        .summary-item {
            display: table-cell;
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
            background: #fff;
            width: 16.66%;
        }

        .summary-item .label {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
            display: block;
        }

        .summary-item .value {
            font-size: 16px;
            font-weight: bold;
            color: #000;
        }

        .table-section {
            margin-bottom: 20px;
        }

        .table-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            color: #000;
        }

        .print-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            margin-bottom: 20px;
        }

        .print-table th {
            background: #000;
            color: #fff;
            padding: 8px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #000;
        }

        .print-table td {
            padding: 6px 4px;
            text-align: center;
            border: 1px solid #000;
            font-size: 10px;
        }

        .print-table tbody tr:nth-child(even) {
            background: #f5f5f5;
        }

        .status-present { color: #28a745; font-weight: bold; }
        .status-absent { color: #dc3545; font-weight: bold; }
        .status-late { color: #ffc107; font-weight: bold; }
        .status-half { color: #17a2b8; font-weight: bold; }
        .status-vacation { color: #6f42c1; font-weight: bold; }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            font-size: 14px;
            color: #666;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 11px;
            }

            .print-container {
                padding: 10px;
            }

            .no-print {
                display: none !important;
            }

            .print-table {
                page-break-inside: avoid;
            }

            .print-table tbody tr {
                page-break-inside: avoid;
            }
        }

        @page {
            margin: 1cm;
            size: A4;
        }
    </style>
</head>
<body>
    <div class="print-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">شرکت داروگ - سیستم مدیریت پروژه</div>
            <h1>گزارش حضور و غیاب پرسنل</h1>
            <h2>{{ $employee->full_name }} ({{ $employee->employee_code }})</h2>
            <div class="date-range">
                از تاریخ: {{ $startDate }} تا {{ $endDate }}
            </div>
        </div>

        @if($attendanceRecords->count() > 0)
            <!-- Summary Section -->
            <div class="summary-section">
                <div class="summary-title">خلاصه آمار دوره</div>
                <div class="summary-grid">
                    <div class="summary-row">
                        <div class="summary-item">
                            <div class="label">کل روزها</div>
                            <div class="value">{{ $statistics['total_days'] }}</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">حاضر</div>
                            <div class="value">{{ $statistics['present_days'] }}</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">غایب</div>
                            <div class="value">{{ $statistics['absent_days'] }}</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">تأخیر</div>
                            <div class="value">{{ $statistics['late_days'] }}</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">درصد حضور</div>
                            <div class="value">{{ $statistics['attendance_rate'] }}%</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">ساعات کاری</div>
                            <div class="value">{{ round($statistics['total_working_hours'] / 60, 1) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Statistics -->
            <div class="summary-section">
                <div class="summary-title">آمار تفصیلی</div>
                <div class="summary-grid">
                    <div class="summary-row">
                        <div class="summary-item">
                            <div class="label">نیم روز</div>
                            <div class="value">{{ $statistics['half_days'] }}</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">مرخصی</div>
                            <div class="value">{{ $statistics['vacation_days'] }}</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">مرخصی استعلاجی</div>
                            <div class="value">{{ $statistics['sick_leave_days'] }}</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">مجموع ساعات کاری</div>
                            <div class="value">{{ round($statistics['total_working_hours'] / 60, 1) }}</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">مجموع اضافه کاری</div>
                            <div class="value">{{ round($statistics['total_overtime_hours'], 1) }}</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">میانگین روزانه</div>
                            <div class="value">{{ $statistics['total_days'] > 0 ? round($statistics['present_days'] / $statistics['total_days'], 2) : 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Records Table -->
            <div class="table-section">
                <div class="table-title">سوابق تفصیلی حضور و غیاب</div>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th style="width: 12%;">تاریخ</th>
                            <th style="width: 15%;">پروژه</th>
                            <th style="width: 10%;">وضعیت</th>
                            <th style="width: 8%;">ساعت ورود</th>
                            <th style="width: 8%;">ساعت خروج</th>
                            <th style="width: 10%;">ساعات کاری</th>
                            <th style="width: 10%;">اضافه کاری</th>
                            <th style="width: 10%;">ساعات مفید</th>
                            <th style="width: 17%;">یادداشت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendanceRecords as $record)
                            <tr>
                                <td>{{ $record->persian_date }}</td>
                                <td style="text-align: right;">{{ $record->project->name ?? 'نامشخص' }}</td>
                                <td>
                                    @switch($record->status)
                                        @case('present')
                                            <span class="status-present">حاضر</span>
                                            @break
                                        @case('absent')
                                            <span class="status-absent">غایب</span>
                                            @break
                                        @case('late')
                                            <span class="status-late">تأخیر</span>
                                            @break
                                        @case('half_day')
                                            <span class="status-half">نیم روز</span>
                                            @break
                                        @case('vacation')
                                            <span class="status-vacation">مرخصی</span>
                                            @break
                                        @case('sick_leave')
                                            <span class="status-vacation">مرخصی استعلاجی</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $record->check_in_time ? $record->check_in_time->format('H:i') : '-' }}</td>
                                <td>{{ $record->check_out_time ? $record->check_out_time->format('H:i') : '-' }}</td>
                                <td>{{ $record->working_hours ? round($record->working_hours / 60, 1) . ' ساعت' : '-' }}</td>
                                <td>{{ $record->overtime_hours ? round($record->overtime_hours, 1) . ' ساعت' : '-' }}</td>
                                <td>{{ $record->useful_hours ? round($record->useful_hours, 1) . ' ساعت' : '-' }}</td>
                                <td style="text-align: right;">{{ $record->notes ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-data">
                <p>برای بازه زمانی انتخاب شده هیچ سابقه حضور و غیابی یافت نشد.</p>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>تاریخ چاپ: {{ \App\Services\PersianDateService::carbonToPersian(\Carbon\Carbon::now()) }}</p>
            <p>سیستم مدیریت پروژه داروگ</p>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
