<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گزارش تفصیلی - {{ $employee->full_name }} - {{ now()->format('Y/m/d H:i') }}</title>
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

        .employee-info-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .employee-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 32px;
            flex-shrink: 0;
        }

        .employee-details h2 {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }

        .employee-code {
            font-family: 'Courier New', monospace;
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 12px;
        }

        .employee-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #666;
        }

        .info-item i {
            color: #999;
            width: 16px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .stat-icon {
            font-size: 24px;
            color: #666;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 11px;
            color: #666;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #ddd;
        }

        .bank-accounts-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .bank-accounts-table th {
            background: #333;
            color: white;
            padding: 10px 8px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #333;
        }

        .bank-accounts-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            vertical-align: middle;
        }

        .bank-accounts-table tr:nth-child(even) {
            background: #f8f9fa;
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
            font-size: 9px;
        }

        .default-badge {
            background: #fbbf24;
            color: #92400e;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .status-active {
            color: #28a745;
            font-weight: bold;
        }

        .status-inactive {
            color: #dc3545;
            font-weight: bold;
        }

        .bank-summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .bank-summary-table th {
            background: #f8f9fa;
            color: #333;
            padding: 10px 8px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #ddd;
        }

        .bank-summary-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 11px;
        }

        .bank-summary-table tr:nth-child(even) {
            background: #f8f9fa;
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

            .bank-accounts-table th,
            .bank-summary-table th {
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
            <h1 class="print-title">گزارش تفصیلی پرسنل</h1>
            <p class="print-subtitle">{{ $employee->full_name }} - {{ $employee->employee_code }}</p>
            <div class="print-info">
                <span class="print-date">تاریخ: {{ \Morilog\Jalali\Jalalian::fromCarbon(now())->format('Y/m/d H:i') }}</span>
                <span>تعداد حساب‌های بانکی: {{ $employee->bankAccounts->count() }}</span>
            </div>
        </div>

        <!-- Employee Info -->
        <div class="employee-info-section">
            <div class="employee-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="employee-details">
                <h2>{{ $employee->full_name }}</h2>
                <div class="employee-code">کد پرسنلی: {{ $employee->employee_code }}</div>
                <div class="employee-info-grid">
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $employee->email }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-id-card"></i>
                        <span>{{ $employee->national_code }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-building"></i>
                        <span>{{ $employee->department ?? 'نامشخص' }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $employee->hire_date ? \Morilog\Jalali\Jalalian::fromCarbon($employee->hire_date)->format('Y/m/d') : 'نامشخص' }}</span>
                    </div>
                </div>
            </div>
            <div class="status-badge status-{{ $employee->status }}">
                <i class="fas fa-circle"></i>
                {{ $employee->formatted_status }}
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="stat-number">{{ $employee->bankAccounts->count() }}</div>
                <div class="stat-label">حساب‌های بانکی</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">{{ $employee->bankAccounts->where('is_active', true)->count() }}</div>
                <div class="stat-label">حساب‌های فعال</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number">{{ $employee->bankAccounts->where('is_default', true)->count() }}</div>
                <div class="stat-label">حساب اصلی</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-university"></i>
                </div>
                <div class="stat-number">{{ $employee->bankAccounts->pluck('bank_id')->unique()->count() }}</div>
                <div class="stat-label">بانک‌های مختلف</div>
            </div>
        </div>

        @if($employee->bankAccounts->count() > 0)
        <!-- Bank Accounts Details -->
        <h2 class="section-title">جزئیات حساب‌های بانکی</h2>
        <table class="bank-accounts-table">
            <thead>
                <tr>
                    <th style="width: 5%;">ردیف</th>
                    <th style="width: 15%;">بانک</th>
                    <th style="width: 15%;">نام صاحب حساب</th>
                    <th style="width: 12%;">شماره حساب</th>
                    <th style="width: 15%;">شماره کارت</th>
                    <th style="width: 18%;">شماره شبا</th>
                    <th style="width: 8%;">وضعیت</th>
                    <th style="width: 8%;">نوع</th>
                    <th style="width: 4%;">یادداشت</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employee->bankAccounts as $index => $account)
                <tr>
                    <td>{{ $index + 1 }}</td>
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
                            <span class="default-badge">اصلی</span>
                        @else
                            عادی
                        @endif
                    </td>
                    <td>
                        @if($account->notes)
                            <i class="fas fa-sticky-note" title="{{ $account->notes }}"></i>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Bank Summary -->
        @if($employee->bankAccounts->groupBy('bank.name')->count() > 1)
        <h2 class="section-title">خلاصه بر اساس بانک</h2>
        <table class="bank-summary-table">
            <thead>
                <tr>
                    <th style="width: 50%;">نام بانک</th>
                    <th style="width: 15%;">تعداد حساب</th>
                    <th style="width: 15%;">حساب‌های فعال</th>
                    <th style="width: 20%;">حساب‌های اصلی</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employee->bankAccounts->groupBy('bank.name') as $bankName => $accounts)
                <tr>
                    <td class="bank-name">{{ $bankName }}</td>
                    <td>{{ $accounts->count() }}</td>
                    <td>{{ $accounts->where('is_active', true)->count() }}</td>
                    <td>{{ $accounts->where('is_default', true)->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        @else
        <div style="text-align: center; padding: 40px; color: #666;">
            <i class="fas fa-credit-card" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
            <h3 style="font-size: 18px; margin-bottom: 8px;">هیچ حساب بانکی ثبت نشده</h3>
            <p>این پرسنل هنوز حساب بانکی ثبت نکرده است.</p>
        </div>
        @endif

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
