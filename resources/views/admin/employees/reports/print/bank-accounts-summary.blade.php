<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خلاصه حساب‌های بانکی - {{ now()->format('Y/m/d H:i') }}</title>
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

        .bank-summary-section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ddd;
        }

        .bank-summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .bank-summary-card {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .bank-name {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }

        .bank-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }

        .bank-stat-item {
            text-align: center;
        }

        .bank-stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            display: block;
        }

        .bank-stat-label {
            font-size: 10px;
            color: #666;
        }

        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .print-table th {
            background: #333;
            color: white;
            padding: 10px 6px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            border: 1px solid #333;
        }

        .print-table td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 9px;
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
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 8px;
        }

        .bank-name {
            font-weight: bold;
            color: #333;
        }

        .account-holder {
            font-weight: bold;
        }

        .account-number,
        .card-number,
        .iban-number {
            font-family: 'Courier New', monospace;
            font-size: 8px;
        }

        .status-active {
            color: #28a745;
            font-weight: bold;
        }

        .status-inactive {
            color: #dc3545;
            font-weight: bold;
        }

        .type-default {
            background: #fbbf24;
            color: #92400e;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .type-normal {
            color: #666;
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
            <h1 class="print-title">خلاصه حساب‌های بانکی</h1>
            <p class="print-subtitle">گزارش کامل حساب‌های بانکی پرسنل</p>
            <div class="print-info">
                <span class="print-date">تاریخ: {{ \Morilog\Jalali\Jalalian::fromCarbon(now())->format('Y/m/d H:i') }}</span>
                <span>تعداد کل: {{ $bankAccounts->count() }} حساب</span>
            </div>
        </div>

        <!-- Statistics -->
        <div class="print-stats">
            <div class="stat-item">
                <span class="stat-number">{{ $bankAccounts->count() }}</span>
                <div class="stat-label">کل حساب‌های بانکی</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $bankAccounts->where('is_active', true)->count() }}</span>
                <div class="stat-label">حساب‌های فعال</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $bankAccounts->where('is_default', true)->count() }}</span>
                <div class="stat-label">حساب‌های اصلی</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $groupedByBank->count() }}</span>
                <div class="stat-label">بانک‌های مختلف</div>
            </div>
        </div>

        <!-- Bank Summary -->
        @if($groupedByBank->count() > 0)
        <div class="bank-summary-section">
            <h2 class="section-title">خلاصه بر اساس بانک</h2>
            <div class="bank-summary-grid">
                @foreach($groupedByBank as $bankName => $accounts)
                <div class="bank-summary-card">
                    <div class="bank-name">{{ $bankName }}</div>
                    <div class="bank-stats">
                        <div class="bank-stat-item">
                            <span class="bank-stat-value">{{ $accounts->count() }}</span>
                            <div class="bank-stat-label">کل حساب</div>
                        </div>
                        <div class="bank-stat-item">
                            <span class="bank-stat-value">{{ $accounts->where('is_active', true)->count() }}</span>
                            <div class="bank-stat-label">فعال</div>
                        </div>
                        <div class="bank-stat-item">
                            <span class="bank-stat-value">{{ $accounts->where('is_default', true)->count() }}</span>
                            <div class="bank-stat-label">اصلی</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Detailed Table -->
        <h2 class="section-title">جزئیات حساب‌های بانکی</h2>
        <table class="print-table">
            <thead>
                <tr>
                    <th style="width: 3%;">ردیف</th>
                    <th style="width: 12%;">نام کارمند</th>
                    <th style="width: 8%;">کد پرسنلی</th>
                    <th style="width: 10%;">بانک</th>
                    <th style="width: 12%;">نام صاحب حساب</th>
                    <th style="width: 10%;">شماره حساب</th>
                    <th style="width: 12%;">شماره کارت</th>
                    <th style="width: 15%;">شماره شبا</th>
                    <th style="width: 6%;">وضعیت</th>
                    <th style="width: 6%;">نوع</th>
                    <th style="width: 6%;">تاریخ ایجاد</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bankAccounts as $index => $account)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="employee-name">{{ $account->employee->full_name }}</td>
                    <td>
                        <span class="employee-code">{{ $account->employee->employee_code }}</span>
                    </td>
                    <td class="bank-name">{{ $account->bank->name }}</td>
                    <td class="account-holder">{{ $account->account_holder_name }}</td>
                    <td class="account-number">{{ $account->account_number ?? '-' }}</td>
                    <td class="card-number">{{ $account->card_number ? formatCardNumber($account->card_number) : '-' }}</td>
                    <td class="iban-number">{{ $account->iban ? formatShebaNumber($account->iban) : '-' }}</td>
                    <td class="status-{{ $account->is_active ? 'active' : 'inactive' }}">
                        {{ $account->is_active ? 'فعال' : 'غیرفعال' }}
                    </td>
                    <td>
                        @if($account->is_default)
                            <span class="type-default">اصلی</span>
                        @else
                            <span class="type-normal">عادی</span>
                        @endif
                    </td>
                    <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($account->created_at)->format('Y/m/d') }}</td>
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
