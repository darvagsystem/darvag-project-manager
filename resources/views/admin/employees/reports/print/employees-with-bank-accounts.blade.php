<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پرسنل با حساب بانکی - {{ now()->format('Y/m/d H:i') }}</title>
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
            color: #333;
            background: white;
        }

        .print-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .print-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }

        .print-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .print-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px;
        }

        .print-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #666;
        }

        .print-date {
            font-weight: bold;
        }

        .print-stats {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-around;
            text-align: center;
        }

        .stat-item {
            flex: 1;
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            display: block;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .print-table th {
            background: #333;
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #333;
        }

        .print-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            vertical-align: middle;
        }

        .print-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .print-table tr:hover {
            background: #e9ecef;
        }

        .employee-name {
            font-weight: bold;
            color: #333;
        }

        .employee-code {
            font-family: 'Courier New', monospace;
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }

        .status-active {
            color: #28a745;
            font-weight: bold;
        }

        .status-inactive {
            color: #dc3545;
            font-weight: bold;
        }

        .bank-count {
            background: #007bff;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .bank-info {
            font-size: 9px;
            text-align: right;
        }

        .bank-name {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 2px;
        }

        .account-details {
            color: #666;
        }

        .account-number,
        .card-number,
        .iban-number {
            font-family: 'Courier New', monospace;
            font-size: 8px;
            display: block;
            margin-bottom: 1px;
        }

        .default-badge {
            background: #fbbf24;
            color: #92400e;
            padding: 1px 4px;
            border-radius: 2px;
            font-size: 8px;
            font-weight: bold;
        }

        .print-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .page-break {
            page-break-before: always;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .print-container {
                padding: 0;
            }

            .print-table th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
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
        <div class="print-header">
            <h1 class="print-title">پرسنل با حساب بانکی</h1>
            <p class="print-subtitle">لیست پرسنلی که حساب بانکی دارند</p>
            <div class="print-info">
                <span class="print-date">تاریخ: {{ \Morilog\Jalali\Jalalian::fromCarbon(now())->format('Y/m/d H:i') }}</span>
                <span>تعداد کل: {{ $employees->count() }} نفر</span>
            </div>
        </div>

        <!-- Statistics -->
        <div class="print-stats">
            <div class="stat-item">
                <span class="stat-number">{{ $employees->count() }}</span>
                <div class="stat-label">کل پرسنل</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $employees->where('status', 'active')->count() }}</span>
                <div class="stat-label">پرسنل فعال</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $employees->where('status', 'inactive')->count() }}</span>
                <div class="stat-label">پرسنل غیرفعال</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $employees->sum(function($emp) { return $emp->bankAccounts->count(); }) }}</span>
                <div class="stat-label">کل حساب‌ها</div>
            </div>
        </div>

        <!-- Table -->
        <table class="print-table">
            <thead>
                <tr>
                    <th style="width: 5%;">ردیف</th>
                    <th style="width: 20%;">نام کامل</th>
                    <th style="width: 10%;">کد پرسنلی</th>
                    <th style="width: 8%;">وضعیت</th>
                    <th style="width: 8%;">تعداد حساب</th>
                    <th style="width: 49%;">حساب‌های بانکی</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $index => $employee)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="employee-name">{{ $employee->full_name }}</td>
                    <td>
                        <span class="employee-code">{{ $employee->employee_code }}</span>
                    </td>
                    <td class="status-{{ $employee->status }}">
                        {{ $employee->formatted_status }}
                    </td>
                    <td>
                        <span class="bank-count">{{ $employee->bankAccounts->count() }}</span>
                    </td>
                    <td>
                        <div class="bank-info">
                            @foreach($employee->bankAccounts as $account)
                                <div style="margin-bottom: 8px; padding: 4px; background: #f8f9fa; border-radius: 4px;">
                                    <div class="bank-name">
                                        {{ $account->bank->name }}
                                        @if($account->is_default)
                                            <span class="default-badge">اصلی</span>
                                        @endif
                                    </div>
                                    <div class="account-details">
                                        <div class="account-number">
                                            @if($account->account_number)
                                                حساب: {{ $account->account_number }}
                                            @endif
                                        </div>
                                        <div class="card-number">
                                            @if($account->card_number)
                                                کارت: {{ formatCardNumber($account->card_number) }}
                                            @endif
                                        </div>
                                        <div class="iban-number">
                                            @if($account->iban)
                                                شبا: {{ formatShebaNumber($account->iban) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Footer -->
        <div class="print-footer">
            <p>این گزارش در تاریخ {{ \Morilog\Jalali\Jalalian::fromCarbon(now())->format('Y/m/d H:i') }} تولید شده است.</p>
            <p>سیستم مدیریت پرسنل - شرکت داروگ</p>
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
