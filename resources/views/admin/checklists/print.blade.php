<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گزارش چک لیست - {{ $checklist->title }}</title>

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
            <a href="{{ route('panel.checklists.show', $checklist) }}" class="back-btn">
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
                    <label for="itemSpacing">فاصله آیتم‌ها:</label>
                    <select id="itemSpacing">
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
                <div class="setting-item">
                    <label for="showCompletedOnly">فقط کارهای انجام شده:</label>
                    <input type="checkbox" id="showCompletedOnly">
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
                    <div class="logo-placeholder">
                        <span>لوگو شرکت</span>
                    </div>
                </div>
                <div class="title-area">
                    <h1 class="main-title">گزارش چک لیست</h1>
                    <h2 class="project-title">{{ $checklist->title }}</h2>
                </div>
                <div class="logo-area">
                    <div class="logo-placeholder">
                        <span>لوگو داروگ</span>
                    </div>
                </div>
            </div>

            <!-- Checklist Info Table -->
            <div class="checklist-info">
                <table class="info-table">
                    <tr>
                        <td class="info-label">دسته‌بندی:</td>
                        <td class="info-value">{{ $checklist->category ? $checklist->category->name : 'بدون دسته‌بندی' }}</td>
                        <td class="info-label">تاریخ تهیه گزارش:</td>
                        <td class="info-value">{{ \App\Services\PersianDateService::getCurrentPersianDate() }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">اولویت:</td>
                        <td class="info-value">{{ $checklist->formatted_priority }}</td>
                        <td class="info-label">وضعیت:</td>
                        <td class="info-value">{{ $checklist->formatted_status }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">تاریخ ایجاد:</td>
                        <td class="info-value">{{ \App\Services\PersianDateService::carbonToPersianDateTime($checklist->created_at) }}</td>
                        <td class="info-label">تاریخ سررسید:</td>
                        <td class="info-value">{{ $checklist->due_date ? \App\Services\PersianDateService::carbonToPersianDateTime($checklist->due_date) : 'تعیین نشده' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Progress Summary -->
            <div class="progress-summary no-break">
                <h3 class="summary-title">خلاصه پیشرفت</h3>
                <div class="progress-info">
                    <div class="progress-bar-container">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $checklist->progress_percentage }}"></div>
                        </div>
                        <div class="progress-text">{{ $checklist->progress_percentage }}</div>
                    </div>
                    <div class="progress-stats">
                        <div class="stat-item">
                            <span class="stat-number">{{ $checklist->completed_items_count }}</span>
                            <span class="stat-label">انجام شده</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $checklist->total_items_count }}</span>
                            <span class="stat-label">کل آیتم‌ها</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $checklist->total_items_count - $checklist->completed_items_count }}</span>
                            <span class="stat-label">باقی‌مانده</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checklist Items -->
            <div class="checklist-items">
                <h3 class="items-title">فهرست کارها</h3>
                @if($checklist->items->count() > 0)
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th style="width: 5%">ردیف</th>
                                <th style="width: 8%">وضعیت</th>
                                <th style="width: 50%">شرح کار</th>
                                <th style="width: 12%">اولویت</th>
                                <th style="width: 15%">تاریخ سررسید</th>
                                <th style="width: 10%">تاریخ تکمیل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checklist->items as $index => $item)
                                <tr class="item-row {{ $item->is_completed ? 'completed' : '' }}">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        @if($item->is_completed)
                                            <span class="status-badge completed">✓</span>
                                        @else
                                            <span class="status-badge pending">○</span>
                                        @endif
                                    </td>
                                    <td class="item-description">
                                        <div class="item-title">{{ $item->title }}</div>
                                        @if($item->description)
                                            <div class="item-desc">{{ $item->description }}</div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->priority !== 'normal')
                                            <span class="priority-badge priority-{{ $item->priority }}">
                                                {{ $item->formatted_priority }}
                                            </span>
                                        @else
                                            <span class="priority-badge normal">عادی</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->due_date)
                                            {{ \App\Services\PersianDateService::carbonToPersianDateTime($item->due_date) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->is_completed && $item->completed_at)
                                            {{ \App\Services\PersianDateService::carbonToPersianDateTime($item->completed_at) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-items">
                        <p>هیچ آیتمی برای این چک لیست تعریف نشده است.</p>
                    </div>
                @endif
            </div>

            <!-- Checklist Description -->
            @if($checklist->description)
                <div class="checklist-description no-break">
                    <h3 class="desc-title">توضیحات چک لیست</h3>
                    <div class="desc-content">
                        <p>{{ $checklist->description }}</p>
                    </div>
                </div>
            @endif

            <!-- Summary Notes -->
            <div class="summary-notes no-break">
                <h3 class="notes-title">خلاصه و یادداشت‌ها</h3>
                <div class="notes-content">
                    <div class="note-item">
                        <p><strong>نرخ تکمیل:</strong> {{ $checklist->progress_percentage }}% از کارها انجام شده است.</p>
                    </div>
                    @if($checklist->completed_items_count > 0)
                        <div class="note-item">
                            <p><strong>آخرین فعالیت:</strong> {{ $checklist->items->where('is_completed', true)->sortByDesc('completed_at')->first()->title ?? 'نامشخص' }}</p>
                        </div>
                    @endif
                    @if($checklist->due_date)
                        <div class="note-item">
                            <p><strong>تاریخ سررسید:</strong> {{ \App\Services\PersianDateService::carbonToPersianDateTime($checklist->due_date) }}</p>
                        </div>
                    @endif
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
                    <p>سیستم مدیریت پروژه داروگ</p>
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

        .checklist-items {
            page-break-inside: avoid;
            margin-bottom: 15px;
        }

        .progress-summary {
            page-break-inside: avoid;
        }

        .page-footer {
            page-break-inside: avoid;
        }

        /* Force page breaks for major sections */
        .checklist-items {
            page-break-before: auto;
        }

        .summary-notes {
            page-break-before: auto;
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

        .page-header .checklist-info {
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

        /* Screen display styles for page header */
        .page-header .main-title {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .page-header .project-title {
            font-size: 14px;
        }

        .page-header .logo {
            max-width: 100px;
            max-height: 70px;
        }

        .page-header .logo-label {
            font-size: 10px;
        }

        .page-header .info-table {
            font-size: 10px;
        }

        .page-header .info-table td {
            padding: 6px 8px;
        }

        /* Print styles override */
        @media print {
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

            .page-header .info-table {
                font-size: 7px;
            }

            .page-header .info-table td {
                padding: 2px 4px;
            }
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

        /* Screen display styles for page footer */
        .page-footer .signatures {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .page-footer .signature-box {
            width: 180px;
            font-size: 10px;
        }

        .page-footer .signature-line {
            height: 30px;
            margin: 8px 0;
        }

        .page-footer .footer-note {
            font-size: 10px;
        }

        /* Print styles override for footer */
        @media print {
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

    .checklist-info {
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

    /* Progress Summary */
    .progress-summary {
        margin-bottom: 30px;
        page-break-inside: avoid;
    }

    .summary-title {
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 15px;
        border: 2px solid #333;
        padding: 8px;
        background-color: #f5f5f5;
    }

    .progress-info {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 15px;
        border: 1px solid #333;
        background-color: #f9f9f9;
    }

    .progress-bar-container {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .progress-bar {
        flex: 1;
        height: 20px;
        background-color: #e5e5e5;
        border: 1px solid #333;
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background-color: #10b981;
        transition: width 0.3s ease;
    }

    .progress-text {
        font-weight: bold;
        font-size: 14px;
        min-width: 40px;
        text-align: center;
    }

    .progress-stats {
        display: flex;
        gap: 20px;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .stat-label {
        font-size: 10px;
        color: #666;
    }

    /* Checklist Items */
    .checklist-items {
        margin-bottom: 30px;
        page-break-inside: avoid;
    }

    .items-title {
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 15px;
        border: 2px solid #333;
        padding: 8px;
        background-color: #f5f5f5;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
        font-size: 10px;
    }

    .items-table th, .items-table td {
        border: 1px solid #333;
        padding: 4px 3px;
        text-align: center;
        vertical-align: top;
    }

    .items-table th {
        background-color: #f5f5f5;
        font-weight: bold;
        font-size: 9px;
    }

    .item-row.completed {
        background-color: #f0f9ff;
        opacity: 0.8;
    }

    .item-row.completed .item-title {
        text-decoration: line-through;
    }

    .item-description {
        text-align: right !important;
    }

    .item-title {
        font-weight: bold;
        margin-bottom: 2px;
    }

    .item-desc {
        font-size: 8px;
        color: #666;
        font-style: italic;
    }

    .status-badge {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        text-align: center;
        line-height: 20px;
        font-weight: bold;
        font-size: 12px;
    }

    .status-badge.completed {
        background-color: #10b981;
        color: white;
    }

    .status-badge.pending {
        background-color: #e5e5e5;
        color: #666;
        border: 1px solid #ccc;
    }

    .priority-badge {
        display: inline-block;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 8px;
        font-weight: bold;
    }

    .priority-badge.priority-urgent {
        background-color: #dc2626;
        color: white;
    }

    .priority-badge.priority-high {
        background-color: #f59e0b;
        color: white;
    }

    .priority-badge.priority-normal {
        background-color: #6b7280;
        color: white;
    }

    .priority-badge.priority-low {
        background-color: #10b981;
        color: white;
    }

    .no-items {
        text-align: center;
        font-style: italic;
        color: #666;
        padding: 20px;
        border: 1px dashed #ccc;
    }

    /* Checklist Description */
    .checklist-description {
        margin-bottom: 30px;
        page-break-inside: avoid;
    }

    .desc-title {
        font-size: 12px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
        border: 2px solid #333;
        padding: 6px;
        background-color: #f5f5f5;
    }

    .desc-content {
        padding: 10px;
        border: 1px solid #333;
        background-color: #f9f9f9;
        font-size: 10px;
        line-height: 1.4;
        text-align: right;
    }

    /* Summary Notes */
    .summary-notes {
        margin-top: 30px;
        page-break-inside: avoid;
    }

    .notes-title {
        font-size: 12px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
        border: 2px solid #333;
        padding: 6px;
        background-color: #f5f5f5;
    }

    .notes-content {
        padding: 10px;
        border: 1px solid #333;
        background-color: #f9f9f9;
        font-size: 10px;
        line-height: 1.4;
        text-align: right;
    }

    .note-item {
        margin-bottom: 8px;
        padding-bottom: 8px;
        border-bottom: 1px solid #ddd;
    }

    .note-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .note-item p {
        margin: 0;
        white-space: pre-wrap;
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

        .items-table {
            font-size: 8px;
        }

        .items-table th, .items-table td {
            padding: 3px 2px;
        }

        .checklist-items {
            page-break-inside: avoid;
            margin-bottom: 15px;
        }

        .progress-summary {
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

        .notes-content {
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

    .landscape-mode .items-table {
        font-size: 11px;
    }

    .landscape-mode .items-table th,
    .landscape-mode .items-table td {
        padding: 5px;
    }

    /* Dynamic Print Settings */
    :root {
        --print-font-size: 9px;
    }

    .compact-mode .items-table {
        font-size: 8px;
    }

    .compact-mode .items-table th,
    .compact-mode .items-table td {
        padding: 2px 1px;
    }

    .compact-mode .summary-title,
    .compact-mode .items-title,
    .compact-mode .desc-title,
    .compact-mode .notes-title {
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

    .compact-mode .notes-content {
        font-size: 8px;
    }

    .compact-mode .footer-note {
        font-size: 8px;
    }

    /* Item Spacing Classes */
    .items-table.compact th,
    .items-table.compact td {
        padding: 2px 1px;
    }

    .items-table.normal th,
    .items-table.normal td {
        padding: 4px 3px;
    }

    .items-table.spacious th,
    .items-table.spacious td {
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

    /* Show completed only */
    .show-completed-only .item-row:not(.completed) {
        display: none;
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
        const progressSummary = document.querySelector('.progress-summary');
        const checklistItems = document.querySelector('.checklist-items');
        const checklistDescription = document.querySelector('.checklist-description');
        const summaryNotes = document.querySelector('.summary-notes');

        let breakdownHTML = '<div class="page-item"><strong>تجزیه محتوا:</strong></div>';

        if (progressSummary) {
            breakdownHTML += '<div class="page-item">• خلاصه پیشرفت: 1 بخش</div>';
        }

        if (checklistItems) {
            const itemCount = document.querySelectorAll('.item-row').length;
            breakdownHTML += `<div class="page-item">• فهرست کارها: ${itemCount} آیتم</div>`;
        }

        if (checklistDescription) {
            breakdownHTML += '<div class="page-item">• توضیحات چک لیست: 1 بخش</div>';
        }

        if (summaryNotes) {
            breakdownHTML += '<div class="page-item">• خلاصه و یادداشت‌ها: 1 بخش</div>';
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
        const itemSpacing = document.getElementById('itemSpacing').value;
        const showPageNumbers = document.getElementById('showPageNumbers').checked;
        const compactMode = document.getElementById('compactMode').checked;
        const showCompletedOnly = document.getElementById('showCompletedOnly').checked;

        // اعمال تنظیمات فونت
        document.documentElement.style.setProperty('--print-font-size', fontSize + 'px');

        // اعمال تنظیمات فاصله آیتم‌ها
        const tables = document.querySelectorAll('.items-table');
        tables.forEach(table => {
            table.classList.remove('compact', 'normal', 'spacious');
            table.classList.add(itemSpacing);
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

        // اعمال نمایش فقط کارهای انجام شده
        if (showCompletedOnly) {
            document.body.classList.add('show-completed-only');
        } else {
            document.body.classList.remove('show-completed-only');
        }

        // محاسبه مجدد صفحه‌بندی
        if (document.getElementById('pagePreview').style.display !== 'none') {
            calculatePageBreakdown();
        }

        alert('تنظیمات اعمال شد!');
    }

    function resetPrintSettings() {
        document.getElementById('fontSize').value = '9';
        document.getElementById('itemSpacing').value = 'compact';
        document.getElementById('showPageNumbers').checked = true;
        document.getElementById('compactMode').checked = false;
        document.getElementById('showCompletedOnly').checked = false;

        // بازنشانی استایل‌ها
        document.documentElement.style.removeProperty('--print-font-size');
        document.body.classList.remove('compact-mode', 'show-page-numbers', 'show-completed-only');

        const tables = document.querySelectorAll('.items-table');
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
