@extends('admin.layout')

@section('title', 'خلاصه حساب‌های بانکی')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <div class="breadcrumb">
                <a href="{{ route('panel.employees.index') }}" class="breadcrumb-link">مدیریت پرسنل</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('panel.employees.reports.index') }}" class="breadcrumb-link">گزارش‌ها</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">خلاصه حساب‌های بانکی</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-chart-pie"></i>
                خلاصه حساب‌های بانکی
            </h1>
            <p class="page-subtitle">
                گزارش کامل حساب‌های بانکی پرسنل
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('panel.employees.reports.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-right"></i>
                بازگشت
            </a>
            <a href="{{ route('panel.employees.reports.bank-accounts-summary', ['format' => 'print']) }}" target="_blank" class="btn btn-outline-light">
                <i class="fas fa-print"></i>
                پرینت
            </a>
            <a href="{{ route('panel.employees.reports.export', ['type' => 'bank_accounts_summary', 'format' => 'csv']) }}" class="btn btn-outline-light">
                <i class="fas fa-download"></i>
                دانلود CSV
            </a>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-credit-card"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $bankAccounts->count() }}</div>
            <div class="stat-label">کل حساب‌های بانکی</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $bankAccounts->where('is_active', true)->count() }}</div>
            <div class="stat-label">حساب‌های فعال</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $bankAccounts->where('is_default', true)->count() }}</div>
            <div class="stat-label">حساب‌های اصلی</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-university"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $groupedByBank->count() }}</div>
            <div class="stat-label">بانک‌های مختلف</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card-box">
    <form method="GET" class="filters-form">
        <div class="filters-grid">
            <div class="form-group">
                <label for="bank_id" class="form-label">بانک</label>
                <select id="bank_id" name="bank_id" class="form-select">
                    <option value="">همه بانک‌ها</option>
                    @foreach(\App\Models\Bank::active()->get() as $bank)
                        <option value="{{ $bank->id }}" {{ request('bank_id') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="is_active" class="form-label">وضعیت</label>
                <select id="is_active" name="is_active" class="form-select">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>فعال</option>
                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>غیرفعال</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="is_default" class="form-label">نوع حساب</label>
                <select id="is_default" name="is_default" class="form-select">
                    <option value="">همه انواع</option>
                    <option value="1" {{ request('is_default') == '1' ? 'selected' : '' }}>حساب اصلی</option>
                    <option value="0" {{ request('is_default') == '0' ? 'selected' : '' }}>حساب عادی</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    فیلتر
                </button>
                <a href="{{ route('panel.employees.reports.bank-accounts-summary') }}" class="btn btn-light">
                    <i class="fas fa-times"></i>
                    پاک کردن
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Bank Summary -->
@if($groupedByBank->count() > 0)
<div class="card-box">
    <h3 class="section-title">خلاصه بر اساس بانک</h3>
    <div class="bank-summary-grid">
        @foreach($groupedByBank as $bankName => $accounts)
        <div class="bank-summary-card">
            <div class="bank-header">
                <div class="bank-icon">
                    @if($accounts->first()->bank->logo)
                        <img src="{{ asset('storage/' . $accounts->first()->bank->logo) }}" alt="{{ $bankName }}">
                    @else
                        <i class="fas fa-university"></i>
                    @endif
                </div>
                <div class="bank-info">
                    <h4>{{ $bankName }}</h4>
                    <p>{{ $accounts->count() }} حساب</p>
                </div>
            </div>
            <div class="bank-stats">
                <div class="stat-item">
                    <span class="stat-value">{{ $accounts->where('is_active', true)->count() }}</span>
                    <span class="stat-label">فعال</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $accounts->where('is_default', true)->count() }}</span>
                    <span class="stat-label">اصلی</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Detailed Table -->
<div class="card-box">
    <div class="table-header">
        <h3>جزئیات حساب‌های بانکی</h3>
        <div class="table-info">
            <span class="result-count">{{ $bankAccounts->count() }} حساب یافت شد</span>
        </div>
    </div>
    
    @if($bankAccounts->count() > 0)
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>نام کارمند</th>
                    <th>کد پرسنلی</th>
                    <th>بانک</th>
                    <th>نام صاحب حساب</th>
                    <th>شماره حساب</th>
                    <th>شماره کارت</th>
                    <th>شماره شبا</th>
                    <th>وضعیت</th>
                    <th>نوع</th>
                    <th>تاریخ ایجاد</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bankAccounts as $account)
                <tr>
                    <td>
                        <div class="employee-info">
                            <div class="employee-avatar">
                                @if($account->employee->avatar)
                                    <img src="{{ asset('storage/' . $account->employee->avatar) }}" alt="{{ $account->employee->full_name }}">
                                @else
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="employee-details">
                                <div class="employee-name">{{ $account->employee->full_name }}</div>
                                <div class="employee-email">{{ $account->employee->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="employee-code">{{ $account->employee->employee_code }}</span>
                    </td>
                    <td>
                        <div class="bank-info">
                            @if($account->bank->logo)
                                <img src="{{ asset('storage/' . $account->bank->logo) }}" alt="{{ $account->bank->name }}" class="bank-logo">
                            @else
                                <div class="bank-logo-placeholder">
                                    <i class="fas fa-university"></i>
                                </div>
                            @endif
                            <span class="bank-name">{{ $account->bank->name }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="account-holder">{{ $account->account_holder_name }}</span>
                    </td>
                    <td>
                        @if($account->account_number)
                            <span class="account-number">{{ $account->account_number }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($account->card_number)
                            <span class="card-number">{{ formatCardNumber($account->card_number) }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($account->iban)
                            <span class="iban-number">{{ formatShebaNumber($account->iban) }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($account->is_active)
                            <span class="status-badge status-active">
                                <i class="fas fa-check-circle"></i>
                                فعال
                            </span>
                        @else
                            <span class="status-badge status-inactive">
                                <i class="fas fa-times-circle"></i>
                                غیرفعال
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($account->is_default)
                            <span class="type-badge type-default">
                                <i class="fas fa-star"></i>
                                اصلی
                            </span>
                        @else
                            <span class="type-badge type-normal">
                                <i class="fas fa-circle"></i>
                                عادی
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="created-date">{{ \Morilog\Jalali\Jalalian::fromCarbon($account->created_at)->format('Y/m/d') }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-credit-card"></i>
        </div>
        <h3>هیچ حسابی یافت نشد</h3>
        <p>با فیلترهای انتخابی هیچ حساب بانکی یافت نشد.</p>
    </div>
    @endif
</div>

@endsection

@push('styles')
<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 16px;
    margin-bottom: 30px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 30px;
}

.header-info {
    flex: 1;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    font-size: 14px;
    opacity: 0.9;
}

.breadcrumb-link {
    color: white;
    text-decoration: none;
    transition: opacity 0.3s ease;
}

.breadcrumb-link:hover {
    opacity: 0.8;
}

.breadcrumb-separator {
    opacity: 0.6;
}

.breadcrumb-current {
    opacity: 0.8;
    font-weight: 500;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 8px 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-title i {
    font-size: 24px;
    opacity: 0.9;
}

.page-subtitle {
    font-size: 16px;
    margin: 0;
    opacity: 0.9;
}

.header-actions {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

.btn-outline-light {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
}

.btn-outline-light:hover {
    background: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.5);
    color: white;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
}

/* Card Box */
.card-box {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

/* Filters */
.filters-form {
    margin-bottom: 0;
}

.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    align-items: end;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-input,
.form-select {
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Section Title */
.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #e5e7eb;
}

/* Bank Summary Grid */
.bank-summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.bank-summary-card {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    transition: all 0.3s ease;
}

.bank-summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.bank-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
}

.bank-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    font-size: 18px;
    overflow: hidden;
}

.bank-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.bank-info h4 {
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 4px 0;
}

.bank-info p {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.bank-stats {
    display: flex;
    gap: 20px;
}

.stat-item {
    text-align: center;
}

.stat-value {
    display: block;
    font-size: 18px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 12px;
    color: #6b7280;
}

/* Table */
.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e5e7eb;
}

.table-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.table-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.result-count {
    font-size: 14px;
    color: #6b7280;
    background: #f3f4f6;
    padding: 6px 12px;
    border-radius: 6px;
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.data-table th {
    background: #f8fafc;
    color: #374151;
    font-weight: 600;
    padding: 12px 8px;
    text-align: center;
    border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
}

.data-table td {
    padding: 12px 8px;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
    text-align: center;
}

.data-table tr:hover {
    background: #f9fafb;
}

/* Employee Info */
.employee-info {
    display: flex;
    align-items: center;
    gap: 8px;
}

.employee-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.employee-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 12px;
}

.employee-details {
    flex: 1;
    text-align: right;
}

.employee-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 12px;
    margin-bottom: 2px;
}

.employee-email {
    font-size: 10px;
    color: #6b7280;
}

.employee-code {
    font-family: 'Courier New', monospace;
    background: #f3f4f6;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 600;
}

/* Bank Info */
.bank-info {
    display: flex;
    align-items: center;
    gap: 6px;
    justify-content: center;
}

.bank-logo {
    width: 20px;
    height: 20px;
    border-radius: 4px;
    object-fit: cover;
}

.bank-logo-placeholder {
    width: 20px;
    height: 20px;
    background: #e5e7eb;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 10px;
}

.bank-name {
    font-size: 12px;
    font-weight: 500;
    color: #1f2937;
}

.account-holder {
    font-size: 12px;
    color: #1f2937;
    font-weight: 500;
}

.account-number,
.card-number,
.iban-number {
    font-family: 'Courier New', monospace;
    font-size: 11px;
    color: #6b7280;
}

.text-muted {
    color: #9ca3af;
    font-style: italic;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 6px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 500;
}

.status-badge i {
    font-size: 8px;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
}

.status-inactive {
    background: #fee2e2;
    color: #991b1b;
}

/* Type Badge */
.type-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 6px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 500;
}

.type-badge i {
    font-size: 8px;
}

.type-default {
    background: #fef3c7;
    color: #92400e;
}

.type-normal {
    background: #e5e7eb;
    color: #6b7280;
}

.created-date {
    font-size: 11px;
    color: #6b7280;
}

/* Action Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    justify-content: center;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-light {
    background: #f8fafc;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-light:hover {
    background: #f1f5f9;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 18px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 14px;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
    }

    .header-actions {
        width: 100%;
        justify-content: center;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .filters-grid {
        grid-template-columns: 1fr;
    }

    .bank-summary-grid {
        grid-template-columns: 1fr;
    }

    .table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .data-table {
        font-size: 11px;
    }

    .data-table th,
    .data-table td {
        padding: 8px 4px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Helper functions for formatting
function formatCardNumber(cardNumber) {
    if (!cardNumber) return '';
    return cardNumber.replace(/\D/g, '').replace(/(\d{4})(?=\d)/g, '$1-');
}

function formatShebaNumber(sheba) {
    if (!sheba) return '';
    let value = sheba.replace(/[^0-9]/g, '');
    if (value.length > 0 && !value.startsWith('IR')) {
        value = 'IR' + value;
    }
    return value;
}
</script>
@endpush
