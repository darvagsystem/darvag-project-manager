@extends('admin.layout')

@section('title', 'پرسنل با حساب بانکی')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <div class="breadcrumb">
                <a href="{{ route('panel.employees.index') }}" class="breadcrumb-link">مدیریت پرسنل</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('panel.employees.reports.index') }}" class="breadcrumb-link">گزارش‌ها</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">پرسنل با حساب بانکی</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-credit-card"></i>
                پرسنل با حساب بانکی
            </h1>
            <p class="page-subtitle">
                لیست پرسنلی که حساب بانکی دارند
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('panel.employees.reports.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-right"></i>
                بازگشت
            </a>
            <a href="{{ route('panel.employees.reports.employees-with-bank-accounts', ['format' => 'print']) }}" target="_blank" class="btn btn-outline-light">
                <i class="fas fa-print"></i>
                پرینت
            </a>
            <a href="{{ route('panel.employees.reports.export', ['type' => 'employees_with_bank_accounts', 'format' => 'csv']) }}" class="btn btn-outline-light">
                <i class="fas fa-download"></i>
                دانلود CSV
            </a>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card-box">
    <form method="GET" class="filters-form">
        <div class="filters-grid">
            <div class="form-group">
                <label for="status" class="form-label">وضعیت</label>
                <select id="status" name="status" class="form-select">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                </select>
            </div>
            
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
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    فیلتر
                </button>
                <a href="{{ route('panel.employees.reports.employees-with-bank-accounts') }}" class="btn btn-light">
                    <i class="fas fa-times"></i>
                    پاک کردن
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Results -->
<div class="card-box">
    <div class="table-header">
        <h3>نتایج جستجو</h3>
        <div class="table-info">
            <span class="result-count">{{ $employees->count() }} نتیجه یافت شد</span>
        </div>
    </div>
    
    @if($employees->count() > 0)
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>نام کامل</th>
                    <th>کد پرسنلی</th>
                    <th>وضعیت</th>
                    <th>تعداد حساب</th>
                    <th>حساب‌های بانکی</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>
                        <div class="employee-info">
                            <div class="employee-avatar">
                                @if($employee->avatar)
                                    <img src="{{ asset('storage/' . $employee->avatar) }}" alt="{{ $employee->full_name }}">
                                @else
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="employee-details">
                                <div class="employee-name">{{ $employee->full_name }}</div>
                                <div class="employee-email">{{ $employee->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="employee-code">{{ $employee->employee_code }}</span>
                    </td>
                    <td>
                        <span class="status-badge status-{{ $employee->status }}">
                            <i class="fas fa-circle"></i>
                            {{ $employee->formatted_status }}
                        </span>
                    </td>
                    <td>
                        <span class="bank-count">{{ $employee->bankAccounts->count() }}</span>
                    </td>
                    <td>
                        <div class="bank-accounts-list">
                            @foreach($employee->bankAccounts as $account)
                                <div class="bank-account-item">
                                    <div class="bank-info">
                                        @if($account->bank->logo)
                                            <img src="{{ asset('storage/' . $account->bank->logo) }}" alt="{{ $account->bank->name }}" class="bank-logo">
                                        @else
                                            <div class="bank-logo-placeholder">
                                                <i class="fas fa-university"></i>
                                            </div>
                                        @endif
                                        <div class="bank-details">
                                            <div class="bank-name">{{ $account->bank->name }}</div>
                                            @if($account->is_default)
                                                <span class="default-badge">حساب اصلی</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="account-details">
                                        @if($account->account_number)
                                            <div class="account-number">
                                                <i class="fas fa-hashtag"></i>
                                                {{ $account->account_number }}
                                            </div>
                                        @endif
                                        @if($account->card_number)
                                            <div class="card-number">
                                                <i class="fas fa-credit-card"></i>
                                                {{ formatCardNumber($account->card_number) }}
                                            </div>
                                        @endif
                                        @if($account->iban)
                                            <div class="iban-number">
                                                <i class="fas fa-barcode"></i>
                                                {{ formatShebaNumber($account->iban) }}
                                            </div>
                                        @endif
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
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('panel.employees.show', $employee->id) }}" class="btn btn-sm btn-outline-primary" title="مشاهده">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('panel.employees.bank-accounts', $employee->id) }}" class="btn btn-sm btn-outline-info" title="حساب‌های بانکی">
                                <i class="fas fa-credit-card"></i>
                            </a>
                            <a href="{{ route('panel.employees.reports.employee-detail', $employee->id) }}" class="btn btn-sm btn-outline-success" title="گزارش تفصیلی">
                                <i class="fas fa-chart-line"></i>
                            </a>
                        </div>
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
        <h3>هیچ پرسنلی یافت نشد</h3>
        <p>با فیلترهای انتخابی هیچ پرسنلی با حساب بانکی یافت نشد.</p>
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
    font-size: 14px;
}

.data-table th {
    background: #f8fafc;
    color: #374151;
    font-weight: 600;
    padding: 12px 16px;
    text-align: right;
    border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
}

.data-table td {
    padding: 16px;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: top;
}

.data-table tr:hover {
    background: #f9fafb;
}

/* Employee Info */
.employee-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.employee-avatar {
    width: 40px;
    height: 40px;
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
    font-size: 16px;
}

.employee-details {
    flex: 1;
}

.employee-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 2px;
}

.employee-email {
    font-size: 12px;
    color: #6b7280;
}

.employee-code {
    font-family: 'Courier New', monospace;
    background: #f3f4f6;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
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

.bank-count {
    background: #3b82f6;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

/* Bank Accounts List */
.bank-accounts-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-width: 400px;
}

.bank-account-item {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 12px;
}

.bank-info {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

.bank-logo {
    width: 24px;
    height: 24px;
    border-radius: 4px;
    object-fit: cover;
}

.bank-logo-placeholder {
    width: 24px;
    height: 24px;
    background: #e5e7eb;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 12px;
}

.bank-details {
    flex: 1;
}

.bank-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 13px;
}

.default-badge {
    background: #fbbf24;
    color: #92400e;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 500;
    margin-top: 2px;
    display: inline-block;
}

.account-details {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-bottom: 8px;
}

.account-number,
.card-number,
.iban-number {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: #6b7280;
}

.account-number i,
.card-number i,
.iban-number i {
    font-size: 10px;
    color: #9ca3af;
}

.account-status {
    text-align: left;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 6px;
}

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

.btn-sm {
    padding: 4px 8px;
    font-size: 11px;
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

.btn-outline-info {
    background: transparent;
    color: #06b6d4;
    border: 1px solid #06b6d4;
}

.btn-outline-info:hover {
    background: #06b6d4;
    color: white;
}

.btn-outline-success {
    background: transparent;
    color: #10b981;
    border: 1px solid #10b981;
}

.btn-outline-success:hover {
    background: #10b981;
    color: white;
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

    .filters-grid {
        grid-template-columns: 1fr;
    }

    .table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .action-buttons {
        flex-direction: column;
    }

    .bank-accounts-list {
        max-width: 100%;
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
