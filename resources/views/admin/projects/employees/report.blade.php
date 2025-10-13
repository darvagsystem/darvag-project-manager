<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گزارش کارمندان پروژه - {{ $project->name }}</title>

    <!-- فونت فارسی Vazir -->
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v30.1.0/dist/font-face.css" rel="stylesheet">
</head>
<body>
    <!-- Screen Controls -->
    <div class="screen-only">
        <div class="controls">
            <button onclick="toggleOrientation()" class="orientation-btn" id="orientationBtn">
                حالت افقی
            </button>
            <button onclick="window.print()" class="print-btn">
                چاپ گزارش
            </button>
            <button onclick="togglePagePreview()" class="preview-btn" id="previewBtn">
                پیش‌نمایش صفحه‌بندی
            </button>
            <button onclick="togglePrintSettings()" class="settings-btn" id="settingsBtn">
                تنظیمات چاپ
            </button>
            <a href="{{ route('panel.projects.employees.index', $project) }}" class="back-btn">
                بازگشت
            </a>
        </div>

        <!-- Page Preview -->
        <div id="pagePreview" class="page-preview" style="display: none;">
            <h3>پیش‌نمایش صفحه‌بندی</h3>
            <div id="pageCount">تعداد صفحات: در حال محاسبه...</div>
            <div id="pageBreakdown"></div>
        </div>

        <!-- Print Settings -->
        <div id="printSettings" class="print-settings" style="display: none;">
            <h3>تنظیمات چاپ</h3>
            <div class="settings-grid">
                <div class="setting-item">
                    <label for="fontSize">اندازه فونت:</label>
                    <select id="fontSize">
                        <option value="8">8px (خیلی کوچک)</option>
                        <option value="9" selected>9px (کوچک)</option>
                        <option value="10">10px (متوسط)</option>
                        <option value="11">11px (بزرگ)</option>
                        <option value="12">12px (خیلی بزرگ)</option>
                    </select>
                </div>
                <div class="setting-item">
                    <label for="tableSpacing">فاصله جداول:</label>
                    <select id="tableSpacing">
                        <option value="compact" selected>فشرده</option>
                        <option value="normal">عادی</option>
                        <option value="spacious">گسترده</option>
                    </select>
                </div>
                <div class="setting-item">
                    <label for="showPageNumbers">نمایش شماره صفحه:</label>
                    <input type="checkbox" id="showPageNumbers" checked>
                </div>
                <div class="setting-item">
                    <label for="compactMode">حالت فشرده:</label>
                    <input type="checkbox" id="compactMode">
                </div>
            </div>
            <div class="settings-actions">
                <button onclick="applyPrintSettings()" class="apply-btn">اعمال تنظیمات</button>
                <button onclick="resetPrintSettings()" class="reset-btn">بازنشانی</button>
            </div>
        </div>
    </div>

    <!-- Print Content -->
    <div class="print-container">
        <!-- Page Header (repeated on each page) -->
        <div class="page-header">
            <!-- Logo Area -->
            <div class="header-top">
                <div class="logo-area">
                    @if($project->client && $project->client->logo)
                        <img src="{{ asset('storage/' . $project->client->logo) }}" alt="لوگو کارفرما" class="logo">
                        <span class="logo-label">کارفرما</span>
                    @else
                        <div class="logo-placeholder">
                            <span>لوگو کارفرما</span>
                        </div>
                    @endif
                </div>
                <div class="title-area">
                    <h1 class="main-title">گزارش کارمندان پروژه</h1>
                    <h2 class="project-title">{{ $project->name }}</h2>
                </div>
                <div class="logo-area">
                    <div class="logo-placeholder">
                        <span>لوگو پیمانکار</span>
                    </div>
                </div>
            </div>

            <!-- Project Info Table -->
            <div class="project-info">
                <table class="info-table">
                    <tr>
                        <td class="info-label">کد پروژه:</td>
                        <td class="info-value">{{ $project->contract_number ?? '-' }}</td>
                        <td class="info-label">تاریخ تهیه گزارش:</td>
                        <td class="info-value">{{ \App\Services\PersianDateService::getCurrentPersianDate() }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">کارفرما:</td>
                        <td class="info-value">{{ $project->client->name ?? '-' }}</td>
                        <td class="info-label">محل اجرا:</td>
                        <td class="info-value">{{ $project->location ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">وضعیت پروژه:</td>
                        <td class="info-value">
                            @switch($project->status)
                                @case('planning')
                                    در حال برنامه‌ریزی
                                    @break
                                @case('in_progress')
                                    در حال اجرا
                                    @break
                                @case('completed')
                                    تکمیل شده
                                    @break
                                @case('paused')
                                    متوقف شده
                                    @break
                                @case('cancelled')
                                    لغو شده
                                    @break
                                @default
                                    نامشخص
                            @endswitch
                        </td>
                        <td class="info-label">تعداد کل کارمندان:</td>
                        <td class="info-value">{{ $statistics['total_employees'] }} نفر</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Statistics Summary -->
            <div class="statistics-summary no-break">
                <h3 class="summary-title">خلاصه آمار کارمندان</h3>
                
                <table class="summary-table">
                    <tbody>
                        <tr>
                            <td class="desc-col">تعداد کل کارمندان:</td>
                            <td class="amount-col">{{ number_format($statistics['total_employees']) }}</td>
                            <td class="unit-col">نفر</td>
                        </tr>
                        <tr class="subtotal-row">
                            <td class="desc-col"><strong>کارمندان فعال:</strong></td>
                            <td class="amount-col"><strong>{{ number_format($statistics['active_employees']) }}</strong></td>
                            <td class="unit-col"><strong>نفر</strong></td>
                        </tr>
                        <tr>
                            <td class="desc-col">کارمندان غیرفعال:</td>
                            <td class="amount-col">{{ number_format($statistics['inactive_employees']) }}</td>
                            <td class="unit-col">نفر</td>
                        </tr>
                        <tr>
                            <td class="desc-col">کارمندان با حقوق ماهیانه:</td>
                            <td class="amount-col">{{ number_format($statistics['monthly_employees_count']) }}</td>
                            <td class="unit-col">نفر</td>
                        </tr>
                        <tr>
                            <td class="desc-col">کارمندان با حقوق روزانه:</td>
                            <td class="amount-col">{{ number_format($statistics['daily_employees_count']) }}</td>
                            <td class="unit-col">نفر</td>
                        </tr>
                        <tr class="total-row">
                            <td class="desc-col"><strong>مجموع حقوق:</strong></td>
                            <td class="amount-col"><strong>{{ number_format($statistics['total_salary']) }}</strong></td>
                            <td class="unit-col"><strong>تومان</strong></td>
                        </tr>
                        <tr>
                            <td class="desc-col">میانگین روزهای کاری ماه:</td>
                            <td class="amount-col">{{ number_format($statistics['average_working_days'], 1) }}</td>
                            <td class="unit-col">روز</td>
                        </tr>
                        <tr>
                            <td class="desc-col">میانگین درصد کسر غیبت:</td>
                            <td class="amount-col">{{ number_format($statistics['average_absence_deduction'], 1) }}</td>
                            <td class="unit-col">درصد</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Monthly Salary Employees -->
            @if($monthlyEmployees->count() > 0)
            <div class="section-table no-break">
                <h3 class="section-title">1. کارمندان با حقوق ماهیانه</h3>
                
                <table class="employees-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">ردیف</th>
                            <th style="width: 25%">نام و نام خانوادگی</th>
                            <th style="width: 15%">کد پرسنلی</th>
                            <th style="width: 15%">مبلغ حقوق (تومان)</th>
                            <th style="width: 10%">روزهای کاری</th>
                            <th style="width: 10%">کسر غیبت (%)</th>
                            <th style="width: 10%">تاریخ شروع</th>
                            <th style="width: 10%">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyEmployees as $index => $projectEmployee)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $projectEmployee->employee->full_name }}</td>
                            <td class="text-center">{{ $projectEmployee->employee->employee_code }}</td>
                            <td class="text-left">{{ number_format($projectEmployee->salary_amount) }}</td>
                            <td class="text-center">{{ $projectEmployee->working_days_per_month }}</td>
                            <td class="text-center">{{ number_format($projectEmployee->absence_deduction_rate, 1) }}</td>
                            <td class="text-center">{{ $projectEmployee->formatted_start_date }}</td>
                            <td class="text-center">
                                <span class="status-badge {{ $projectEmployee->is_active ? 'active' : 'inactive' }}">
                                    {{ $projectEmployee->is_active ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="3" class="text-left font-bold">جمع کل حقوق ماهیانه:</td>
                            <td class="text-left font-bold">{{ number_format($statistics['total_monthly_salary']) }}</td>
                            <td colspan="4" class="text-center">تومان</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif

            <!-- Daily Salary Employees -->
            @if($dailyEmployees->count() > 0)
            <div class="section-table no-break">
                <h3 class="section-title">2. کارمندان با حقوق روزانه</h3>
                
                <table class="employees-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">ردیف</th>
                            <th style="width: 25%">نام و نام خانوادگی</th>
                            <th style="width: 15%">کد پرسنلی</th>
                            <th style="width: 15%">مبلغ حقوق روزانه (تومان)</th>
                            <th style="width: 10%">روزهای کاری</th>
                            <th style="width: 10%">کسر غیبت (%)</th>
                            <th style="width: 10%">تاریخ شروع</th>
                            <th style="width: 10%">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyEmployees as $index => $projectEmployee)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $projectEmployee->employee->full_name }}</td>
                            <td class="text-center">{{ $projectEmployee->employee->employee_code }}</td>
                            <td class="text-left">{{ number_format($projectEmployee->daily_salary) }}</td>
                            <td class="text-center">{{ $projectEmployee->working_days_per_month }}</td>
                            <td class="text-center">{{ number_format($projectEmployee->absence_deduction_rate, 1) }}</td>
                            <td class="text-center">{{ $projectEmployee->formatted_start_date }}</td>
                            <td class="text-center">
                                <span class="status-badge {{ $projectEmployee->is_active ? 'active' : 'inactive' }}">
                                    {{ $projectEmployee->is_active ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="3" class="text-left font-bold">جمع کل حقوق روزانه:</td>
                            <td class="text-left font-bold">{{ number_format($statistics['total_daily_salary']) }}</td>
                            <td colspan="4" class="text-center">تومان</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif

            <!-- Detailed Employee Information -->
            @if($projectEmployees->count() > 0)
            <div class="section-table no-break">
                <h3 class="section-title">3. جزئیات کامل کارمندان</h3>
                
                <table class="detailed-table">
                    <thead>
                        <tr>
                            <th style="width: 4%">ردیف</th>
                            <th style="width: 20%">نام و نام خانوادگی</th>
                            <th style="width: 12%">کد پرسنلی</th>
                            <th style="width: 10%">نوع حقوق</th>
                            <th style="width: 12%">مبلغ حقوق</th>
                            <th style="width: 8%">روزهای کاری</th>
                            <th style="width: 8%">کسر غیبت</th>
                            <th style="width: 10%">تاریخ شروع</th>
                            <th style="width: 10%">تاریخ پایان</th>
                            <th style="width: 6%">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projectEmployees as $index => $projectEmployee)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $projectEmployee->employee->full_name }}</td>
                            <td class="text-center">{{ $projectEmployee->employee->employee_code }}</td>
                            <td class="text-center">{{ $projectEmployee->salary_type_text }}</td>
                            <td class="text-left">{{ $projectEmployee->salary_amount_formatted }}</td>
                            <td class="text-center">{{ $projectEmployee->working_days_per_month }}</td>
                            <td class="text-center">{{ number_format($projectEmployee->absence_deduction_rate, 1) }}%</td>
                            <td class="text-center">{{ $projectEmployee->formatted_start_date }}</td>
                            <td class="text-center">{{ $projectEmployee->formatted_end_date ?? '-' }}</td>
                            <td class="text-center">
                                <span class="status-badge {{ $projectEmployee->is_active ? 'active' : 'inactive' }}">
                                    {{ $projectEmployee->is_active ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                        </tr>
                        @if($projectEmployee->notes)
                        <tr class="notes-row">
                            <td colspan="10" class="notes-cell">
                                <strong>یادداشت:</strong> {{ $projectEmployee->notes }}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Financial Analysis -->
            <div class="financial-analysis no-break">
                <h3 class="analysis-title">تحلیل مالی کارمندان</h3>
                
                <div class="analysis-grid">
                    <div class="analysis-item">
                        <h4>حقوق ماهیانه</h4>
                        <div class="analysis-content">
                            <p><strong>تعداد:</strong> {{ $statistics['monthly_employees_count'] }} نفر</p>
                            <p><strong>مجموع:</strong> {{ number_format($statistics['total_monthly_salary']) }} تومان</p>
                            <p><strong>میانگین:</strong> {{ $statistics['monthly_employees_count'] > 0 ? number_format($statistics['total_monthly_salary'] / $statistics['monthly_employees_count']) : 0 }} تومان</p>
                        </div>
                    </div>
                    
                    <div class="analysis-item">
                        <h4>حقوق روزانه</h4>
                        <div class="analysis-content">
                            <p><strong>تعداد:</strong> {{ $statistics['daily_employees_count'] }} نفر</p>
                            <p><strong>مجموع:</strong> {{ number_format($statistics['total_daily_salary']) }} تومان</p>
                            <p><strong>میانگین:</strong> {{ $statistics['daily_employees_count'] > 0 ? number_format($statistics['total_daily_salary'] / $statistics['daily_employees_count']) : 0 }} تومان</p>
                        </div>
                    </div>
                    
                    <div class="analysis-item">
                        <h4>آمار کلی</h4>
                        <div class="analysis-content">
                            <p><strong>مجموع کل:</strong> {{ number_format($statistics['total_salary']) }} تومان</p>
                            <p><strong>میانگین روزهای کاری:</strong> {{ number_format($statistics['average_working_days'], 1) }} روز</p>
                            <p><strong>میانگین کسر غیبت:</strong> {{ number_format($statistics['average_absence_deduction'], 1) }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Footer (repeated on each page) -->
        <div class="page-footer">
            <div class="footer-content">
                <div class="signatures">
                    <div class="signature-box">
                        <p>تهیه کننده:</p>
                        <div class="signature-line"></div>
                        <p>تاریخ: {{ \App\Services\PersianDateService::getCurrentPersianDate() }}</p>
                    </div>
                    <div class="signature-box">
                        <p>تأیید کننده:</p>
                        <div class="signature-line"></div>
                        <p>تاریخ: ......./......./......</p>
                    </div>
                </div>
                <div class="footer-note">
                    <p>شرکت کاخ سازان داروگ</p>
                    <p>تاریخ و ساعت تولید: {{ \App\Services\PersianDateService::getCurrentPersianDateTime() }}</p>
                </div>
            </div>
        </div>
    </div>

<!-- Styles -->
<style>
    * {
        font-family: 'Vazir', 'Tahoma', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f5f5f5;
        font-size: 12px;
        line-height: 1.3;
        color: #000;
    }

    /* Print Media Queries */
    @media print {
        @page {
            size: A4;
            margin: 3cm 1.5cm 4cm 1.5cm;
        }

        body {
            font-size: 10px;
            line-height: 1.2;
            counter-reset: page;
        }

        .screen-only {
            display: none !important;
        }

        .print-container {
            max-width: none;
            margin: 0;
            padding: 0;
            box-shadow: none;
            min-height: auto;
        }

        .page-break {
            page-break-before: always;
        }

        .no-break {
            page-break-inside: avoid;
        }

        .section-table {
            page-break-inside: avoid;
            margin-bottom: 15px;
        }

        .statistics-summary {
            page-break-inside: avoid;
        }

        .financial-analysis {
            page-break-inside: avoid;
        }

        .page-footer {
            page-break-inside: avoid;
        }

        /* Force page breaks for major sections */
        .financial-analysis {
            page-break-before: always;
        }

        /* Header for each page */
        .page-header {
            position: running(page-header);
            width: 100%;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
            margin-bottom: 15px;
            background: white;
        }

        .page-header .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .page-header .project-info {
            margin-top: 8px;
        }

        .page-header .info-table {
            font-size: 7px;
        }

        .page-header .info-table td {
            padding: 2px 4px;
        }

        .page-header .main-title {
            font-size: 12px;
            margin-bottom: 4px;
        }

        .page-header .project-title {
            font-size: 10px;
        }

        .page-header .logo {
            max-width: 60px;
            max-height: 40px;
        }

        .page-header .logo-label {
            font-size: 8px;
        }

        /* Footer for each page */
        .page-footer {
            position: running(page-footer);
            width: 100%;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            margin-top: 15px;
            text-align: center;
            font-size: 7px;
            color: #666;
            background: white;
        }

        .page-footer .signatures {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .page-footer .signature-box {
            width: 120px;
            font-size: 7px;
        }

        .page-footer .signature-line {
            height: 20px;
            margin: 4px 0;
        }

        .page-footer .footer-note {
            font-size: 7px;
        }

        /* Use running elements in page margins */
        @page {
            @top-center {
                content: element(page-header);
            }
            @bottom-center {
                content: element(page-footer);
            }
        }

        /* Page content */
        .page-content {
            margin-top: 20px;
        }

        /* Force page breaks */
        .force-page-break {
            page-break-before: always;
        }

        .avoid-page-break {
            page-break-inside: avoid;
        }
    }

    /* Screen Only Elements */
    .screen-only {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1000;
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .controls {
        display: flex;
        gap: 10px;
    }

    .print-btn, .back-btn, .orientation-btn, .preview-btn, .settings-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        font-weight: bold;
        margin: 2px;
    }

    .orientation-btn {
        background: #10b981;
        color: white;
    }

    .print-btn {
        background: #3b82f6;
        color: white;
    }

    .preview-btn {
        background: #8b5cf6;
        color: white;
    }

    .settings-btn {
        background: #f59e0b;
        color: white;
    }

    .back-btn {
        background: #6b7280;
        color: white;
    }

    /* Page Preview */
    .page-preview {
        position: fixed;
        top: 80px;
        left: 20px;
        width: 300px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1001;
        max-height: 400px;
        overflow-y: auto;
    }

    .page-preview h3 {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 14px;
    }

    #pageCount {
        font-weight: bold;
        color: #2563eb;
        margin-bottom: 10px;
    }

    #pageBreakdown {
        font-size: 12px;
        line-height: 1.4;
    }

    .page-item {
        padding: 5px 0;
        border-bottom: 1px solid #eee;
    }

    .page-item:last-child {
        border-bottom: none;
    }

    /* Print Settings */
    .print-settings {
        position: fixed;
        top: 80px;
        right: 20px;
        width: 350px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1001;
        max-height: 500px;
        overflow-y: auto;
    }

    .print-settings h3 {
        margin: 0 0 15px 0;
        color: #333;
        font-size: 14px;
    }

    .settings-grid {
        display: grid;
        gap: 15px;
    }

    .setting-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .setting-item label {
        font-weight: bold;
        font-size: 12px;
        color: #555;
    }

    .setting-item select,
    .setting-item input[type="checkbox"] {
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 12px;
    }

    .settings-actions {
        margin-top: 20px;
        display: flex;
        gap: 10px;
    }

    .apply-btn, .reset-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
    }

    .apply-btn {
        background: #10b981;
        color: white;
    }

    .reset-btn {
        background: #ef4444;
        color: white;
    }

    /* Print Container */
    .print-container {
        max-width: 21cm;
        margin: 40px auto;
        background: white;
        padding: 1.5cm;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        min-height: 29.7cm;
    }

    /* Header Styles */
    .page-header {
        margin-bottom: 30px;
        border-bottom: 3px solid #000;
        padding-bottom: 20px;
    }

    .header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .logo-area {
        width: 120px;
        height: 80px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .logo {
        max-width: 100px;
        max-height: 70px;
        width: auto;
        height: auto;
        object-fit: contain;
    }

    .logo-label {
        font-size: 10px;
        color: #666;
        margin-top: 3px;
        text-align: center;
    }

    .logo-placeholder {
        width: 100px;
        height: 70px;
        border: 2px dashed #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: #666;
        text-align: center;
    }

    .title-area {
        text-align: center;
        flex: 1;
    }

    .main-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .project-title {
        font-size: 14px;
        font-weight: normal;
        color: #333;
    }

    .project-info {
        margin-top: 20px;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-table td {
        padding: 6px 8px;
        border: 1px solid #333;
        font-size: 10px;
    }

    .info-label {
        background-color: #f5f5f5;
        font-weight: bold;
        width: 20%;
    }

    .info-value {
        width: 30%;
    }

    /* Section Tables */
    .section-table {
        margin-bottom: 15px;
        page-break-inside: avoid;
    }

    .section-title {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 5px;
        border-bottom: 1px solid #333;
        padding-bottom: 3px;
    }

    .summary-title, .analysis-title {
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 15px;
        border: 2px solid #333;
        padding: 8px;
        background-color: #f5f5f5;
    }

    .employees-table, .detailed-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
        font-size: 10px;
    }

    .employees-table th, .employees-table td,
    .detailed-table th, .detailed-table td {
        border: 1px solid #333;
        padding: 3px 2px;
        text-align: center;
        vertical-align: top;
    }

    .employees-table th, .detailed-table th {
        background-color: #f5f5f5;
        font-weight: bold;
        font-size: 9px;
    }

    .employees-table td:nth-child(2),
    .detailed-table td:nth-child(2) {
        text-align: right;
        font-size: 9px;
    }

    .employees-table td:nth-child(4),
    .employees-table td:nth-child(5),
    .detailed-table td:nth-child(5) {
        text-align: left;
        font-family: monospace;
        font-size: 9px;
    }

    .total-row {
        background-color: #f9f9f9;
        font-weight: bold;
    }

    .notes-row {
        background-color: #f8f9fa;
    }

    .notes-cell {
        text-align: right;
        font-size: 9px;
        font-style: italic;
        color: #666;
    }

    .status-badge {
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 8px;
        font-weight: bold;
    }

    .status-badge.active {
        background-color: #d1fae5;
        color: #059669;
    }

    .status-badge.inactive {
        background-color: #f3f4f6;
        color: #6b7280;
    }

    /* Summary Table */
    .summary-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
        font-size: 10px;
    }

    .summary-table td {
        border: 1px solid #333;
        padding: 4px 3px;
        vertical-align: top;
    }

    .desc-col {
        width: 60%;
        text-align: right;
    }

    .amount-col {
        width: 30%;
        text-align: left;
        font-family: monospace;
    }

    .unit-col {
        width: 10%;
        text-align: center;
    }

    .subtotal-row {
        background-color: #f0f0f0;
        border-top: 2px solid #333;
        border-bottom: 2px solid #333;
    }

    .total-row {
        background-color: #e5e5e5;
        font-weight: bold;
        border-top: 3px solid #000;
        border-bottom: 3px solid #000;
    }

    /* Financial Analysis */
    .financial-analysis {
        margin-top: 30px;
        page-break-inside: avoid;
    }

    .analysis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 15px;
    }

    .analysis-item {
        border: 1px solid #333;
        padding: 15px;
        background-color: #f9f9f9;
    }

    .analysis-item h4 {
        margin-bottom: 10px;
        font-size: 12px;
        font-weight: bold;
        text-align: center;
        border-bottom: 1px solid #333;
        padding-bottom: 5px;
    }

    .analysis-content p {
        margin-bottom: 5px;
        font-size: 10px;
    }

    /* Footer */
    .page-footer {
        margin-top: 30px;
        page-break-inside: avoid;
        border-top: 2px solid #333;
        padding-top: 15px;
    }

    .signatures {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .signature-box {
        text-align: center;
        width: 180px;
        font-size: 10px;
    }

    .signature-line {
        border-bottom: 1px solid #333;
        height: 30px;
        margin: 8px 0;
    }

    .footer-note {
        text-align: center;
        font-size: 10px;
        color: #666;
        border-top: 1px solid #ddd;
        padding-top: 20px;
    }

    /* Utility Classes */
    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .text-right { text-align: right; }
    .font-bold { font-weight: bold; }

    /* Print Styles */
    @media print {
        .screen-only {
            display: none !important;
        }

        body {
            background: white !important;
            font-size: 9px;
        }

        .print-container {
            max-width: none;
            margin: 0;
            padding: 0;
            box-shadow: none;
            min-height: auto;
        }

        .employees-table, .detailed-table, .summary-table {
            font-size: 8px;
        }

        .employees-table th, .employees-table td,
        .detailed-table th, .detailed-table td,
        .summary-table td {
            padding: 3px 2px;
        }

        .section-table {
            page-break-inside: avoid;
            margin-bottom: 15px;
        }

        .statistics-summary {
            page-break-before: auto;
        }

        .financial-analysis {
            page-break-before: auto;
        }

        .page-footer {
            page-break-inside: avoid;
            margin-top: 20px;
        }

        .info-table td {
            font-size: 8px;
            padding: 4px 6px;
        }

        .analysis-content p {
            font-size: 8px;
        }

        .footer-note {
            font-size: 8px;
        }

        /* Force borders and backgrounds to print */
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
    }

    @page {
        size: A4 portrait;
        margin: 1.5cm;
    }

    @page landscape {
        size: A4 landscape;
        margin: 1.5cm;
    }

    .landscape-mode {
        page: landscape;
    }

    .landscape-mode .print-container {
        max-width: 29.7cm;
    }

    .landscape-mode .employees-table,
    .landscape-mode .detailed-table {
        font-size: 11px;
    }

    .landscape-mode .employees-table th,
    .landscape-mode .employees-table td,
    .landscape-mode .detailed-table th,
    .landscape-mode .detailed-table td {
        padding: 5px;
    }

    /* Dynamic Print Settings */
    :root {
        --print-font-size: 9px;
    }

    .compact-mode .employees-table,
    .compact-mode .detailed-table {
        font-size: 8px;
    }

    .compact-mode .employees-table th,
    .compact-mode .employees-table td,
    .compact-mode .detailed-table th,
    .compact-mode .detailed-table td {
        padding: 2px 1px;
    }

    .compact-mode .summary-table {
        font-size: 8px;
    }

    .compact-mode .summary-table td {
        padding: 3px 2px;
    }

    .compact-mode .section-title {
        font-size: 9px;
        margin-bottom: 3px;
    }

    .compact-mode .main-title {
        font-size: 14px;
    }

    .compact-mode .project-title {
        font-size: 12px;
    }

    .compact-mode .info-table td {
        font-size: 8px;
        padding: 4px 6px;
    }

    .compact-mode .analysis-content p {
        font-size: 8px;
    }

    .compact-mode .footer-note {
        font-size: 8px;
    }

    /* Table Spacing Classes */
    .employees-table.compact th,
    .employees-table.compact td,
    .detailed-table.compact th,
    .detailed-table.compact td {
        padding: 2px 1px;
    }

    .employees-table.normal th,
    .employees-table.normal td,
    .detailed-table.normal th,
    .detailed-table.normal td {
        padding: 4px 3px;
    }

    .employees-table.spacious th,
    .employees-table.spacious td,
    .detailed-table.spacious th,
    .detailed-table.spacious td {
        padding: 6px 4px;
    }

    .summary-table.compact td {
        padding: 3px 2px;
    }

    .summary-table.normal td {
        padding: 4px 3px;
    }

    .summary-table.spacious td {
        padding: 6px 4px;
    }

    /* Page Numbers */
    .show-page-numbers .print-container::after {
        content: "صفحه " counter(page);
        position: fixed;
        bottom: 1cm;
        right: 1cm;
        font-size: 10px;
        color: #666;
    }

    @media print {
        .show-page-numbers .print-container::after {
            content: "صفحه " counter(page);
        }
    }
</style>

<script>
    let isLandscape = false;

    function toggleOrientation() {
        const container = document.querySelector('.print-container');
        const btn = document.getElementById('orientationBtn');

        if (isLandscape) {
            container.classList.remove('landscape-mode');
            btn.textContent = 'حالت افقی';
            isLandscape = false;
        } else {
            container.classList.add('landscape-mode');
            btn.textContent = 'حالت عمودی';
            isLandscape = true;
        }
    }

    // Page Preview Functions
    function togglePagePreview() {
        const preview = document.getElementById('pagePreview');
        const btn = document.getElementById('previewBtn');

        if (preview.style.display === 'none') {
            preview.style.display = 'block';
            btn.textContent = 'بستن پیش‌نمایش';
            calculatePageBreakdown();
        } else {
            preview.style.display = 'none';
            btn.textContent = 'پیش‌نمایش صفحه‌بندی';
        }
    }

    function togglePrintSettings() {
        const settings = document.getElementById('printSettings');
        const btn = document.getElementById('settingsBtn');

        if (settings.style.display === 'none') {
            settings.style.display = 'block';
            btn.textContent = 'بستن تنظیمات';
        } else {
            settings.style.display = 'none';
            btn.textContent = 'تنظیمات چاپ';
        }
    }

    function calculatePageBreakdown() {
        const pageCount = document.getElementById('pageCount');
        const breakdown = document.getElementById('pageBreakdown');

        // محاسبه تقریبی تعداد صفحات
        const content = document.querySelector('.page-content');
        const contentHeight = content.offsetHeight;
        const pageHeight = 29.7 * 37.8; // A4 height in pixels (29.7cm * 37.8px/cm)
        const headerHeight = 120; // ارتفاع هدر
        const footerHeight = 80; // ارتفاع فوت‌ر
        const availableHeight = pageHeight - headerHeight - footerHeight;
        const estimatedPages = Math.ceil(contentHeight / availableHeight);

        pageCount.textContent = `تعداد صفحات: ${estimatedPages}`;

        // تجزیه محتوا
        const sections = document.querySelectorAll('.section-table');
        const statisticsSummary = document.querySelector('.statistics-summary');
        const financialAnalysis = document.querySelector('.financial-analysis');

        let breakdownHTML = '<div class="page-item"><strong>تجزیه محتوا:</strong></div>';

        if (statisticsSummary) {
            breakdownHTML += '<div class="page-item">• خلاصه آمار: 1 بخش</div>';
        }

        if (sections.length > 0) {
            breakdownHTML += `<div class="page-item">• جداول کارمندان: ${sections.length} بخش</div>`;
        }

        if (financialAnalysis) {
            breakdownHTML += '<div class="page-item">• تحلیل مالی: 1 بخش</div>';
        }

        breakdownHTML += '<div class="page-item">• هدر و فوت‌ر: در هر صفحه</div>';

        if (estimatedPages > 3) {
            breakdownHTML += '<div class="page-item"><strong>توصیه:</strong> گزارش طولانی است، از حالت فشرده استفاده کنید</div>';
        } else if (estimatedPages > 1) {
            breakdownHTML += '<div class="page-item"><strong>توصیه:</strong> گزارش چند صفحه‌ای است، هدر و فوت‌ر در هر صفحه نمایش داده می‌شود</div>';
        } else {
            breakdownHTML += '<div class="page-item"><strong>توصیه:</strong> گزارش مناسب است</div>';
        }

        breakdown.innerHTML = breakdownHTML;
    }

    function applyPrintSettings() {
        const fontSize = document.getElementById('fontSize').value;
        const tableSpacing = document.getElementById('tableSpacing').value;
        const showPageNumbers = document.getElementById('showPageNumbers').checked;
        const compactMode = document.getElementById('compactMode').checked;

        // اعمال تنظیمات فونت
        document.documentElement.style.setProperty('--print-font-size', fontSize + 'px');

        // اعمال تنظیمات فاصله جداول
        const tables = document.querySelectorAll('.employees-table, .detailed-table, .summary-table');
        tables.forEach(table => {
            table.classList.remove('compact', 'normal', 'spacious');
            table.classList.add(tableSpacing);
        });

        // اعمال حالت فشرده
        if (compactMode) {
            document.body.classList.add('compact-mode');
        } else {
            document.body.classList.remove('compact-mode');
        }

        // اعمال شماره صفحه
        if (showPageNumbers) {
            document.body.classList.add('show-page-numbers');
        } else {
            document.body.classList.remove('show-page-numbers');
        }

        // محاسبه مجدد صفحه‌بندی
        if (document.getElementById('pagePreview').style.display !== 'none') {
            calculatePageBreakdown();
        }

        alert('تنظیمات اعمال شد!');
    }

    function resetPrintSettings() {
        document.getElementById('fontSize').value = '9';
        document.getElementById('tableSpacing').value = 'compact';
        document.getElementById('showPageNumbers').checked = true;
        document.getElementById('compactMode').checked = false;

        // بازنشانی استایل‌ها
        document.documentElement.style.removeProperty('--print-font-size');
        document.body.classList.remove('compact-mode', 'show-page-numbers');

        const tables = document.querySelectorAll('.employees-table, .detailed-table, .summary-table');
        tables.forEach(table => {
            table.classList.remove('compact', 'normal', 'spacious');
            table.classList.add('compact');
        });

        if (document.getElementById('pagePreview').style.display !== 'none') {
            calculatePageBreakdown();
        }

        alert('تنظیمات بازنشانی شد!');
    }
</script>
</body>
</html>
