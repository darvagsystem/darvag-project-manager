@extends('admin.layout')

@section('title', 'گزارش تفصیلی - ' . $employee->full_name)

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <div class="breadcrumb">
                <a href="{{ route('panel.employees.index') }}" class="breadcrumb-link">مدیریت پرسنل</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('panel.employees.reports.index') }}" class="breadcrumb-link">گزارش‌ها</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">گزارش تفصیلی</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-chart-line"></i>
                گزارش تفصیلی
            </h1>
            <p class="page-subtitle">
                {{ $employee->full_name }} - {{ $employee->employee_code }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('panel.employees.reports.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-right"></i>
                بازگشت
            </a>
            <a href="{{ route('panel.employees.reports.employee-detail', ['employee' => $employee->id, 'format' => 'print']) }}" target="_blank" class="btn btn-outline-light">
                <i class="fas fa-print"></i>
                پرینت
            </a>
        </div>
    </div>
</div>

<!-- Employee Info Card -->
<div class="card-box">
    <div class="employee-header">
        <div class="employee-avatar">
            @if($employee->avatar)
                <img src="{{ asset('storage/' . $employee->avatar) }}" alt="{{ $employee->full_name }}">
            @else
                <div class="avatar-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            @endif
        </div>
        <div class="employee-info">
            <h2>{{ $employee->full_name }}</h2>
            <p class="employee-code">کد پرسنلی: {{ $employee->employee_code }}</p>
            <div class="employee-details">
                <div class="detail-item">
                    <i class="fas fa-envelope"></i>
                    <span>{{ $employee->email }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-id-card"></i>
                    <span>{{ $employee->national_code }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-building"></i>
                    <span>{{ $employee->department ?? 'نامشخص' }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-calendar"></i>
                    <span>{{ $employee->hire_date ? \Morilog\Jalali\Jalalian::fromCarbon($employee->hire_date)->format('Y/m/d') : 'نامشخص' }}</span>
                </div>
            </div>
        </div>
        <div class="employee-status">
            <span class="status-badge status-{{ $employee->status }}">
                <i class="fas fa-circle"></i>
                {{ $employee->formatted_status }}
            </span>
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
            <div class="stat-number">{{ $employee->bankAccounts->count() }}</div>
            <div class="stat-label">حساب‌های بانکی</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $employee->bankAccounts->where('is_active', true)->count() }}</div>
            <div class="stat-label">حساب‌های فعال</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $employee->bankAccounts->where('is_default', true)->count() }}</div>
            <div class="stat-label">حساب اصلی</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-university"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $employee->bankAccounts->pluck('bank_id')->unique()->count() }}</div>
            <div class="stat-label">بانک‌های مختلف</div>
        </div>
    </div>
</div>

<!-- Bank Accounts -->
<div class="card-box">
    <div class="section-header">
        <h3>حساب‌های بانکی</h3>
        <a href="{{ route('panel.employees.bank-accounts', $employee->id) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit"></i>
            مدیریت حساب‌ها
        </a>
    </div>
    
    @if($employee->bankAccounts->count() > 0)
    <div class="bank-accounts-grid">
        @foreach($employee->bankAccounts as $account)
        <div class="bank-account-card {{ $account->is_default ? 'default-account' : '' }}">
            <div class="account-header">
                <div class="bank-info">
                    @if($account->bank->logo)
                        <img src="{{ asset('storage/' . $account->bank->logo) }}" alt="{{ $account->bank->name }}" class="bank-logo">
                    @else
                        <div class="bank-logo-placeholder">
                            <i class="fas fa-university"></i>
                        </div>
                    @endif
                    <div class="bank-details">
                        <h4>{{ $account->bank->name }}</h4>
                        @if($account->is_default)
                            <span class="default-badge">حساب اصلی</span>
                        @endif
                    </div>
                </div>
                <div class="account-status">
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
                </div>
            </div>
            
            <div class="account-details">
                <div class="detail-row">
                    <label>نام صاحب حساب:</label>
                    <span>{{ $account->account_holder_name }}</span>
                </div>
                
                @if($account->account_number)
                <div class="detail-row">
                    <label>شماره حساب:</label>
                    <span class="account-number">{{ $account->account_number }}</span>
                </div>
                @endif
                
                @if($account->card_number)
                <div class="detail-row">
                    <label>شماره کارت:</label>
                    <span class="card-number">{{ formatCardNumber($account->card_number) }}</span>
                </div>
                @endif
                
                @if($account->iban)
                <div class="detail-row">
                    <label>شماره شبا:</label>
                    <span class="iban-number">{{ formatShebaNumber($account->iban) }}</span>
                </div>
                @endif
                
                @if($account->notes)
                <div class="detail-row">
                    <label>یادداشت:</label>
                    <span class="notes">{{ $account->notes }}</span>
                </div>
                @endif
                
                <div class="detail-row">
                    <label>تاریخ ایجاد:</label>
                    <span>{{ \Morilog\Jalali\Jalalian::fromCarbon($account->created_at)->format('Y/m/d H:i') }}</span>
                </div>
            </div>
            
            <div class="account-actions">
                <a href="{{ route('panel.employee-bank-accounts.edit', $account->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    ویرایش
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-credit-card"></i>
        </div>
        <h3>هیچ حساب بانکی ثبت نشده</h3>
        <p>این پرسنل هنوز حساب بانکی ثبت نکرده است.</p>
        <a href="{{ route('panel.employees.bank-accounts', $employee->id) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            افزودن حساب بانکی
        </a>
    </div>
    @endif
</div>

<!-- Bank Summary -->
@if($employee->bankAccounts->count() > 0)
<div class="card-box">
    <h3 class="section-title">خلاصه بر اساس بانک</h3>
    <div class="bank-summary-list">
        @foreach($employee->bankAccounts->groupBy('bank.name') as $bankName => $accounts)
        <div class="bank-summary-item">
            <div class="bank-info">
                @if($accounts->first()->bank->logo)
                    <img src="{{ asset('storage/' . $accounts->first()->bank->logo) }}" alt="{{ $bankName }}" class="bank-logo">
                @else
                    <div class="bank-logo-placeholder">
                        <i class="fas fa-university"></i>
                    </div>
                @endif
                <div class="bank-details">
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

/* Employee Header */
.employee-header {
    display: flex;
    align-items: center;
    gap: 24px;
    padding: 24px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.employee-avatar {
    width: 80px;
    height: 80px;
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
    font-size: 32px;
}

.employee-info {
    flex: 1;
}

.employee-info h2 {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 8px 0;
}

.employee-code {
    font-size: 16px;
    color: #6b7280;
    margin: 0 0 16px 0;
    font-family: 'Courier New', monospace;
}

.employee-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #6b7280;
}

.detail-item i {
    color: #9ca3af;
    width: 16px;
}

.employee-status {
    display: flex;
    align-items: center;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
}

.status-badge i {
    font-size: 10px;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
}

.status-inactive {
    background: #fee2e2;
    color: #991b1b;
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

/* Section Header */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e5e7eb;
}

.section-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #e5e7eb;
}

/* Bank Accounts Grid */
.bank-accounts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 20px;
}

.bank-account-card {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    transition: all 0.3s ease;
}

.bank-account-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.bank-account-card.default-account {
    border-color: #fbbf24;
    background: #fffbeb;
}

.account-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.bank-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.bank-logo {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    object-fit: cover;
}

.bank-logo-placeholder {
    width: 40px;
    height: 40px;
    background: #e5e7eb;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 18px;
}

.bank-details h4 {
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 4px 0;
}

.default-badge {
    background: #fbbf24;
    color: #92400e;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 500;
}

.account-details {
    margin-bottom: 16px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f3f4f6;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row label {
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
}

.detail-row span {
    font-size: 13px;
    color: #1f2937;
    font-weight: 500;
}

.account-number,
.card-number,
.iban-number {
    font-family: 'Courier New', monospace;
}

.notes {
    font-style: italic;
    color: #6b7280;
}

.account-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

/* Bank Summary List */
.bank-summary-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.bank-summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
}

.bank-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.bank-logo {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    object-fit: cover;
}

.bank-logo-placeholder {
    width: 32px;
    height: 32px;
    background: #e5e7eb;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 14px;
}

.bank-details h4 {
    font-size: 14px;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 2px 0;
}

.bank-details p {
    font-size: 12px;
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
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 2px;
}

.stat-label {
    font-size: 10px;
    color: #6b7280;
}

/* Action Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    justify-content: center;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-outline-primary {
    background: transparent;
    color: #3b82f6;
    border: 1px solid #3b82f6;
}

.btn-outline-primary:hover {
    background: #3b82f6;
    color: white;
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
    margin: 0 0 20px 0;
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

    .employee-header {
        flex-direction: column;
        text-align: center;
    }

    .employee-details {
        grid-template-columns: 1fr;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .bank-accounts-grid {
        grid-template-columns: 1fr;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .bank-summary-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .bank-stats {
        width: 100%;
        justify-content: space-around;
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
