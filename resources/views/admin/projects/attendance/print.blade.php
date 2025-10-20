<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گزارش حضور و غیاب - {{ $project->name }}</title>
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
            width: 25%;
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
            <h1>گزارش حضور و غیاب</h1>
            <h2>{{ $project->name }}</h2>
            <div class="date-range">
                از تاریخ: {{ $startDate }} تا {{ $endDate }}
            </div>
        </div>

        @if(count($statistics) > 0)
            <!-- Summary Section -->
            <div class="summary-section">
                <div class="summary-title">خلاصه آمار دوره</div>
                <div class="summary-grid">
                    <div class="summary-row">
                        <div class="summary-item">
                            <div class="label">تعداد کارمندان</div>
                            <div class="value">{{ count($statistics) }}</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">روزهای کاری</div>
                            <div class="value">{{ $statistics->first()['total_days'] ?? 0 }}</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">میانگین حضور</div>
                            <div class="value">{{ round($statistics->avg('attendance_rate'), 1) }}%</div>
                        </div>
                        <div class="summary-item">
                            <div class="label">مجموع ساعات کاری</div>
                            <div class="value">{{ round($statistics->sum('total_working_hours') / 60, 1) }} ساعت</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Statistics Table -->
            <div class="table-section">
                <div class="table-title">خلاصه آمار کارمندان</div>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th style="width: 20%;">نام و نام خانوادگی</th>
                            <th style="width: 10%;">کد پرسنلی</th>
                            <th style="width: 8%;">حاضر</th>
                            <th style="width: 8%;">غایب</th>
                            <th style="width: 8%;">تأخیر</th>
                            <th style="width: 8%;">نیم روز</th>
                            <th style="width: 8%;">مرخصی</th>
                            <th style="width: 10%;">درصد حضور</th>
                            <th style="width: 10%;">مجموع ساعات</th>
                            <th style="width: 10%;">میانگین ساعات</th>
                            <th style="width: 10%;">مجموع اضافه کاری</th>
                            <th style="width: 10%;">میانگین اضافه کاری</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statistics as $stat)
                            <tr>
                                <td style="text-align: right; font-weight: bold;">{{ $stat['employee']->full_name }}</td>
                                <td>{{ $stat['employee']->employee_code }}</td>
                                <td class="status-present">{{ $stat['present_days'] }}</td>
                                <td class="status-absent">{{ $stat['absent_days'] }}</td>
                                <td class="status-late">{{ $stat['late_days'] }}</td>
                                <td class="status-half">{{ $stat['half_days'] }}</td>
                                <td class="status-vacation">{{ $stat['vacation_days'] + $stat['sick_leave_days'] }}</td>
                                <td>
                                    @if($stat['attendance_rate'] >= 90)
                                        <span class="status-present">{{ $stat['attendance_rate'] }}%</span>
                                    @elseif($stat['attendance_rate'] >= 70)
                                        <span class="status-late">{{ $stat['attendance_rate'] }}%</span>
                                    @else
                                        <span class="status-absent">{{ $stat['attendance_rate'] }}%</span>
                                    @endif
                                </td>
                                <td>{{ round($stat['total_working_hours'] / 60, 1) }} ساعت</td>
                                <td>{{ round($stat['average_working_hours'] / 60, 1) }} ساعت</td>
                                <td>{{ round($stat['total_overtime_hours'], 1) }} ساعت</td>
                                <td>{{ round($stat['average_overtime_hours'], 1) }} ساعت</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <div class="no-data">
                <p>برای بازه زمانی انتخاب شده هیچ اطلاعاتی یافت نشد.</p>
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
