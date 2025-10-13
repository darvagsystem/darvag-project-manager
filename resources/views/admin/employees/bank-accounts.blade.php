@extends('admin.layout')

@section('title', 'حساب‌های بانکی - ' . $employee->full_name)

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <div class="breadcrumb">
                <a href="{{ route('panel.employees.index') }}" class="breadcrumb-link">مدیریت پرسنل</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">حساب‌های بانکی</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-credit-card"></i>
                حساب‌های بانکی
            </h1>
            <p class="page-subtitle">
                <i class="fas fa-user"></i>
                {{ $employee->full_name }}
                <span class="employee-code">({{ $employee->employee_code }})</span>
            </p>
        </div>
        <div class="header-actions">
            <button class="btn btn-primary btn-lg" onclick="showAddAccountModal()">
                <i class="fas fa-plus"></i>
                افزودن حساب بانکی
            </button>
            <div class="action-group">
                <a href="{{ route('panel.settings.banks.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-university"></i>
                    مدیریت بانک‌ها
                </a>
                <a href="{{ route('panel.employees.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-right"></i>
                    بازگشت
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Employee Info Card -->
<div class="employee-info-card">
    <div class="employee-main-info">
        <div class="employee-avatar">
            @if($employee->avatar && $employee->avatar !== 'default-avatar.png' && file_exists(public_path('storage/' . $employee->avatar)))
                <img src="{{ asset('storage/' . $employee->avatar) }}" alt="{{ $employee->full_name }}">
            @else
                <div class="no-avatar">
                    <i class="fas fa-user"></i>
                </div>
            @endif
        </div>
        <div class="employee-details">
            <h2 class="employee-name">{{ $employee->full_name }}</h2>
            <p class="employee-code">کد پرسنلی: {{ $employee->employee_code }}</p>
            <p class="employee-national">کد ملی: {{ $employee->national_code }}</p>
        </div>
    </div>
    <div class="employee-meta">
        <span class="employee-status status-{{ $employee->status }}">{{ $employee->formatted_status }}</span>
    </div>
</div>

<!-- Bank Accounts Table -->
<div class="bank-accounts-container">
    @if($bankAccounts->count() > 0)
    <div class="table-responsive">
        <table class="bank-accounts-table">
            <thead>
                <tr>
                    <th>بانک</th>
                    <th>نام صاحب حساب</th>
                    <th>شماره حساب</th>
                    <th>شماره کارت</th>
                    <th>شماره شبا (IBAN)</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bankAccounts as $account)
                <tr class="{{ $account->is_default ? 'default-account' : '' }}">
                    <td>
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
                    </td>
                    <td>
                        <div class="account-holder">{{ $account->account_holder_name }}</div>
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
                        <div class="status-cell">
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
                    </td>
                    <td>
                        <div class="action-buttons">
                            @if(!$account->is_default)
                            <button class="btn btn-sm btn-outline-warning" onclick="setAsDefault({{ $account->id }})" title="تنظیم به عنوان اصلی">
                                <i class="fas fa-star"></i>
                            </button>
                            @endif
                            <a href="{{ route('panel.employee-bank-accounts.edit', $account->id) }}" class="btn btn-sm btn-outline-primary" title="ویرایش">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteAccount({{ $account->id }}, '{{ $account->bank->name }}')" title="حذف">
                                <i class="fas fa-trash"></i>
                            </button>
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
        <h3>هنوز حساب بانکی ای ثبت نشده</h3>
        <p>برای افزودن حساب بانکی جدید روی دکمه "افزودن حساب بانکی" کلیک کنید.</p>
        <button class="btn btn-primary" onclick="showAddAccountModal()">
            <i class="fas fa-plus"></i>
            افزودن اولین حساب بانکی
        </button>
    </div>
    @endif
</div>

<!-- Add/Edit Account Modal -->
<div id="accountModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">افزودن حساب بانکی جدید</h2>
            <button class="modal-close" onclick="closeAccountModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="accountForm" class="modal-body">
            <input type="hidden" id="accountId" name="id">
            <input type="hidden" name="employee_id" value="{{ $employee->id }}">

            <div class="form-grid">
                <div class="form-group">
                    <label for="bank_id" class="form-label">بانک *</label>
                    @if($banks->count() > 0)
                        <select id="bank_id" name="bank_id" class="form-select" required>
                            <option value="">انتخاب بانک</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <div class="no-banks-warning">
                            <div class="warning-content">
                                <i class="fas fa-exclamation-triangle"></i>
                                <div>
                                    <h4>هیچ بانکی تعریف نشده</h4>
                                    <p>برای افزودن حساب بانکی، ابتدا باید بانک‌ها را تعریف کنید.</p>
                                    <a href="{{ route('panel.settings.banks.index') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i>
                                        مدیریت بانک‌ها
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="account_holder_name" class="form-label">نام صاحب حساب *</label>
                    <input type="text" id="account_holder_name" name="account_holder_name" class="form-input" required placeholder="نام کامل صاحب حساب">
                </div>

                <div class="form-group">
                    <label for="account_number" class="form-label">شماره حساب</label>
                    <input type="text" id="account_number" name="account_number" class="form-input" placeholder="1234567890">
                </div>

                <div class="form-group">
                    <label for="card_number" class="form-label">شماره کارت</label>
                    <div class="input-group">
                        <input type="text" id="card_number" name="card_number" class="form-input" placeholder="1234-5678-9012-3456" maxlength="19">
                        <button type="button" id="getBankInfoBtn" class="btn btn-outline-primary" onclick="getBankInfoFromCard()">
                            <i class="fas fa-search"></i>
                            دریافت اطلاعات
                        </button>
                    </div>
                    <div id="cardInfoLoading" class="loading-indicator" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                        در حال دریافت اطلاعات...
                    </div>
                </div>

                <div class="form-group">
                    <label for="iban" class="form-label">شماره شبا (IBAN)</label>
                    <input type="text" id="iban" name="iban" class="form-input" placeholder="IR123456789012345678901234" maxlength="26">
                    <small class="form-text text-muted" style="color: #6c757d; font-size: 12px;">شماره شبا همان IBAN است</small>
                </div>

                <div class="form-group full-width">
                    <label for="notes" class="form-label">یادداشت</label>
                    <textarea id="notes" name="notes" class="form-textarea" rows="3" placeholder="توضیحات اضافی"></textarea>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="is_default" name="is_default" value="1">
                            <span class="checkmark"></span>
                            تنظیم به عنوان حساب اصلی
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <span class="checkmark"></span>
                            حساب فعال
                        </label>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="saveAccount()">ذخیره حساب</button>
            <button type="button" class="btn btn-light" onclick="closeAccountModal()">انصراف</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-container modal-sm">
        <div class="modal-header">
            <h2 class="modal-title">تأیید حذف</h2>
            <button class="modal-close" onclick="closeDeleteModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="delete-warning">
                <div class="warning-icon">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3>آیا از حذف این حساب بانکی اطمینان دارید؟</h3>
                <p id="deleteBankName"></p>
                <p class="warning-text">این عمل قابل بازگشت نیست.</p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger" onclick="deleteAccount()">حذف حساب</button>
            <button class="btn btn-light" onclick="closeDeleteModal()">انصراف</button>
        </div>
    </div>
</div>

<!-- Hidden forms for operations -->
<form id="setDefaultForm" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

<form id="deleteAccountForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@php
function formatCardNumber($cardNumber) {
    return chunk_split($cardNumber, 4, '-');
}

function formatShebaNumber($sheba) {
    if (strpos($sheba, 'IR') !== 0) {
        $sheba = 'IR' . $sheba;
    }
    return $sheba;
}
@endphp

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
    display: flex;
    align-items: center;
    gap: 8px;
}

.employee-code {
    background: rgba(255,255,255,0.2);
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
}

.header-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    align-items: flex-end;
}

.action-group {
    display: flex;
    gap: 8px;
}

.btn-lg {
    padding: 12px 24px;
    font-size: 16px;
    font-weight: 600;
}

.btn-outline-secondary {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
}

.btn-outline-secondary:hover {
    background: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.5);
    color: white;
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

/* Page Layout */
.employee-info-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.employee-main-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.employee-avatar {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #e5e7eb;
}

.employee-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-avatar {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f9fafb;
    color: #9ca3af;
    font-size: 20px;
}

.employee-name {
    font-size: 20px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 4px;
}

.employee-code,
.employee-national {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 2px;
}

.employee-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
}

/* Bank Accounts Table */
.bank-accounts-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 30px;
}

.table-responsive {
    overflow-x: auto;
}

.bank-accounts-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

.bank-accounts-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.bank-accounts-table th {
    padding: 16px 20px;
    text-align: right;
    font-weight: 600;
    font-size: 14px;
    border: none;
    white-space: nowrap;
}

.bank-accounts-table tbody tr {
    border-bottom: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.bank-accounts-table tbody tr:hover {
    background: #f8fafc;
}

.bank-accounts-table tbody tr.default-account {
    background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
    border-left: 4px solid #f59e0b;
}

.bank-accounts-table tbody tr.default-account:hover {
    background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
}

.bank-accounts-table td {
    padding: 16px 20px;
    vertical-align: middle;
    border: none;
}

/* Bank Info Cell */
.bank-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.bank-logo {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #007bff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 18px;
    flex-shrink: 0;
}

.bank-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 8px;
}

.bank-logo-placeholder {
    color: white;
    font-size: 20px;
}

.bank-details {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.bank-name {
    font-size: 14px;
    font-weight: 600;
    color: #1f2937;
}

.default-badge {
    background: #f59e0b;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
    width: fit-content;
}

/* Account Info */
.account-holder {
    font-size: 14px;
    font-weight: 500;
    color: #1f2937;
}

.account-number, .card-number, .iban-number {
    font-family: 'Courier New', monospace;
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    background: #f8fafc;
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #e5e7eb;
    display: inline-block;
}

.card-number {
    direction: ltr;
    text-align: left;
}

.iban-number {
    direction: ltr;
    text-align: left;
    font-size: 12px;
}

.text-muted {
    color: #9ca3af;
    font-style: italic;
}

/* Status Cell */
.status-cell {
    display: flex;
    align-items: center;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.status-active {
    background: #dcfce7;
    color: #15803d;
}

.status-badge.status-inactive {
    background: #fef2f2;
    color: #dc2626;
}

.status-badge i {
    font-size: 14px;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
}

.action-buttons .btn {
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid;
}

.action-buttons .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.action-buttons .btn-outline-warning {
    color: #f59e0b;
    border-color: #f59e0b;
}

.action-buttons .btn-outline-warning:hover {
    background: #f59e0b;
    color: white;
}

.action-buttons .btn-outline-primary {
    color: #3b82f6;
    border-color: #3b82f6;
}

.action-buttons .btn-outline-primary:hover {
    background: #3b82f6;
    color: white;
}

.action-buttons .btn-outline-danger {
    color: #ef4444;
    border-color: #ef4444;
}

.action-buttons .btn-outline-danger:hover {
    background: #ef4444;
    color: white;
}


/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 16px;
    border: 2px dashed #d1d5db;
}

.empty-icon {
    margin: 0 auto 24px;
    width: 80px;
    height: 80px;
    background: #f3f4f6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
}

.empty-state h3 {
    font-size: 18px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 24px;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.modal-container {
    background: white;
    border-radius: 16px;
    max-width: 600px;
    width: 100%;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    animation: modalSlideIn 0.3s ease-out;
}

.modal-container.modal-sm {
    max-width: 400px;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal-header {
    padding: 24px 30px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f9fafb;
}

.modal-title {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.modal-close {
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: #fee2e2;
    color: #dc2626;
}

.modal-body {
    padding: 30px;
    max-height: 60vh;
    overflow-y: auto;
}

.modal-footer {
    padding: 20px 30px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    background: #f9fafb;
}

/* Form Styles */
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

/* Input Group Styles */
.input-group {
    display: flex;
    gap: 8px;
    align-items: stretch;
}

.input-group .form-input {
    flex: 1;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    white-space: nowrap;
    padding: 12px 16px;
}

/* Loading Indicator */
.loading-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    color: #3b82f6;
    font-size: 14px;
}

.loading-indicator i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Notification Styles */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    padding: 16px 20px;
    z-index: 9999;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    border-right: 4px solid #3b82f6;
    min-width: 300px;
}

.notification.show {
    transform: translateX(0);
}

.notification-success {
    border-right-color: #10b981;
}

.notification-error {
    border-right-color: #ef4444;
}

.notification-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.notification-content i {
    font-size: 18px;
}

.notification-success .notification-content i {
    color: #10b981;
}

.notification-error .notification-content i {
    color: #ef4444;
}

.notification-content span {
    font-size: 14px;
    font-weight: 500;
    color: #374151;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-input,
.form-select,
.form-textarea {
    padding: 12px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 14px;
    color: #374151;
}

.checkbox-label input[type="checkbox"] {
    margin: 0;
}

/* Button Styles */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
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

.btn-edit {
    background: #f59e0b;
    color: white;
}

.btn-edit:hover {
    background: #d97706;
}

.btn-delete {
    background: #ef4444;
    color: white;
}

.btn-delete:hover {
    background: #dc2626;
}

.btn-light {
    background: #f8fafc;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-light:hover {
    background: #f1f5f9;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

/* Status styles */
.status-active {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.status-vacation {
    background: rgba(251, 191, 36, 0.1);
    color: #f59e0b;
}

.status-inactive {
    background: rgba(156, 163, 175, 0.1);
    color: #9ca3af;
}

.status-terminated {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

/* Delete Warning */
.delete-warning {
    text-align: center;
    padding: 20px;
}

.warning-icon {
    margin: 0 auto 20px;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #fef2f2;
    color: #ef4444;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-warning h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 12px;
}

.delete-warning p {
    color: #6b7280;
    margin-bottom: 8px;
}

.warning-text {
    font-size: 14px;
    color: #ef4444;
    font-weight: 500;
}

/* No Banks Warning */
.no-banks-warning {
    background: #fef3c7;
    border: 1px solid #f59e0b;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
}

.warning-content {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.warning-content i {
    color: #f59e0b;
    font-size: 20px;
    margin-top: 2px;
}

.warning-content h4 {
    color: #92400e;
    font-size: 14px;
    font-weight: 600;
    margin: 0 0 4px 0;
}

.warning-content p {
    color: #92400e;
    font-size: 12px;
    margin: 0 0 12px 0;
    line-height: 1.4;
}

.warning-content .btn {
    font-size: 12px;
    padding: 6px 12px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .bank-accounts-table {
        font-size: 12px;
    }

    .bank-accounts-table th,
    .bank-accounts-table td {
        padding: 12px 8px;
    }

    .bank-logo {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }

    .bank-name {
        font-size: 12px;
    }

    .default-badge {
        font-size: 9px;
        padding: 1px 6px;
    }

    .account-number, .card-number, .iban-number {
        font-size: 11px;
        padding: 3px 6px;
    }

    .status-badge {
        font-size: 10px;
        padding: 4px 8px;
    }

    .action-buttons {
        flex-direction: column;
        gap: 4px;
    }

    .action-buttons .btn {
        padding: 4px 8px;
        font-size: 10px;
    }

    .employee-info-card {
        flex-direction: column;
        text-align: center;
    }

    .modal-container {
        margin: 10px;
        max-height: 95vh;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .modal-footer {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .bank-accounts-table th,
    .bank-accounts-table td {
        padding: 8px 4px;
    }

    .bank-logo {
        width: 28px;
        height: 28px;
        font-size: 12px;
    }

    .bank-name {
        font-size: 11px;
    }

    .account-holder {
        font-size: 12px;
    }

    .account-number, .card-number, .iban-number {
        font-size: 10px;
        padding: 2px 4px;
    }

    .status-badge {
        font-size: 9px;
        padding: 3px 6px;
    }

    .action-buttons .btn {
        padding: 3px 6px;
        font-size: 9px;
    }
}
</style>
@endpush

@push('scripts')
<script>
let currentAccountId = null;

// Show add account modal
function showAddAccountModal() {
    document.getElementById('modalTitle').textContent = 'افزودن حساب بانکی جدید';
    document.getElementById('accountForm').reset();
    document.getElementById('accountId').value = '';
    document.getElementById('accountModal').style.display = 'flex';
}

// Edit account
function editAccount(accountId) {
    document.getElementById('modalTitle').textContent = 'ویرایش حساب بانکی';
    document.getElementById('accountId').value = accountId;
    document.getElementById('accountModal').style.display = 'flex';

    // Show loading state
    const form = document.getElementById('accountForm');
    form.style.opacity = '0.5';
    form.style.pointerEvents = 'none';

    // Fetch account data
    console.log('Fetching account data for ID:', accountId);
    fetch(`{{ url('/panel/employee-bank-accounts') }}/${accountId}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                const account = data.data;

                // Populate form fields
                document.getElementById('bank_id').value = account.bank_id || '';
                document.getElementById('account_holder_name').value = account.account_holder_name || '';
                document.getElementById('account_number').value = account.account_number || '';
                document.getElementById('card_number').value = account.card_number || '';
                document.getElementById('iban').value = account.iban || '';
                document.getElementById('notes').value = account.notes || '';

                // Set checkboxes
                document.getElementById('is_default').checked = account.is_default || false;
                document.getElementById('is_active').checked = account.is_active !== false;

                showNotification('اطلاعات حساب بارگذاری شد', 'success');
            } else {
                showNotification('خطا در بارگذاری اطلاعات: ' + (data.message || 'خطای نامشخص'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('خطا در ارتباط با سرور', 'error');
        })
        .finally(() => {
            // Remove loading state
            form.style.opacity = '1';
            form.style.pointerEvents = 'auto';
        });
}

// Close account modal
function closeAccountModal() {
    document.getElementById('accountModal').style.display = 'none';
}

// Save account
function saveAccount() {
    const form = document.getElementById('accountForm');
    const formData = new FormData(form);
    const accountId = document.getElementById('accountId').value;

    // Add CSRF token
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    let url, method;
    if (accountId) {
        url = `{{ url('/panel/employee-bank-accounts') }}/${accountId}`;
        formData.append('_method', 'PUT');
        method = 'POST';
    } else {
        url = '{{ route("panel.employees.bank-accounts.store", $employee->id) }}';
        method = 'POST';
    }

    console.log('Sending request to:', url, 'Method:', method);
    fetch(url, {
        method: method,
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);

        if (!response.ok) {
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json().then(data => {
                    throw new Error('خطا در اعتبارسنجی: ' + JSON.stringify(data.errors || data));
                });
            } else {
                // If not JSON, get text content
                return response.text().then(text => {
                    console.log('Response text:', text);
                    throw new Error(`خطای سرور (${response.status}): پاسخ غیرمنتظره دریافت شد`);
                });
            }
        }

        // Check if response is JSON before parsing
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            return response.text().then(text => {
                console.log('Response text:', text);
                throw new Error('پاسخ غیرمنتظره از سرور دریافت شد');
            });
        }
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            alert('حساب بانکی با موفقیت ذخیره شد');
            window.location.reload();
        } else {
            alert('خطا در ذخیره اطلاعات: ' + (data.message || 'خطای نامشخص'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        console.error('Error message:', error.message);
        console.error('Error stack:', error.stack);

        let errorMessage = 'خطا در ذخیره اطلاعات';
        if (error.message) {
            errorMessage += ': ' + error.message;
        }

        showNotification(errorMessage, 'error');
    });
}

// Set account as default
function setAsDefault(accountId) {
    const form = document.getElementById('setDefaultForm');
    form.action = `/panel/employees/{{ $employee->id }}/bank-accounts/${accountId}/set-default`;
    form.submit();
}

// Confirm delete account
function confirmDeleteAccount(accountId, bankName) {
    currentAccountId = accountId;
    document.getElementById('deleteBankName').textContent = `بانک: ${bankName}`;
    document.getElementById('deleteModal').style.display = 'flex';
}

// Close delete modal
function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    currentAccountId = null;
}

// Delete account
function deleteAccount() {
    if (currentAccountId) {
        const form = document.getElementById('deleteAccountForm');
        form.action = `/panel/employees/{{ $employee->id }}/bank-accounts/${currentAccountId}`;
        form.submit();
    }
}

// Format card number input
document.getElementById('card_number').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{4})(?=\d)/g, '$1-');
    if (value.length > 19) value = value.substr(0, 19);
    e.target.value = value;

    // Enable/disable get info button based on card number length
    const getInfoBtn = document.getElementById('getBankInfoBtn');
    const cardNumber = value.replace(/\D/g, '');
    getInfoBtn.disabled = cardNumber.length !== 16;
});

// Get bank info from card number
function getBankInfoFromCard() {
    const cardNumber = document.getElementById('card_number').value.replace(/\D/g, '');
    const loadingIndicator = document.getElementById('cardInfoLoading');
    const getInfoBtn = document.getElementById('getBankInfoBtn');

    if (cardNumber.length !== 16) {
        alert('لطفاً شماره کارت 16 رقمی وارد کنید');
        return;
    }

    // Show loading
    loadingIndicator.style.display = 'flex';
    getInfoBtn.disabled = true;
    getInfoBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال دریافت...';

    // Make API request
    fetch('{{ route("panel.get-bank-info-from-card") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            card_number: cardNumber
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Fill form fields with received data
            if (data.data.bank_id) {
                document.getElementById('bank_id').value = data.data.bank_id;
            }
            if (data.data.account_holder_name) {
                document.getElementById('account_holder_name').value = data.data.account_holder_name;
            }
            if (data.data.account_number) {
                document.getElementById('account_number').value = data.data.account_number;
            }
            if (data.data.iban) {
                document.getElementById('iban').value = data.data.iban;
            }

            // Show success message
            showNotification('اطلاعات بانک با موفقیت دریافت شد', 'success');
        } else {
            showNotification(data.message || 'خطا در دریافت اطلاعات', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('خطا در ارتباط با سرور', 'error');
    })
    .finally(() => {
        // Hide loading
        loadingIndicator.style.display = 'none';
        getInfoBtn.disabled = false;
        getInfoBtn.innerHTML = '<i class="fas fa-search"></i> دریافت اطلاعات';
    });
}

// Show notification
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;

    // Add to page
    document.body.appendChild(notification);

    // Show notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);

    // Remove after 5 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}

// Format IBAN input
document.getElementById('iban').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^0-9]/g, '');
    if (value.length > 22) value = value.substr(0, 22);

    // Add IR prefix if not present
    if (value.length > 0 && !e.target.value.startsWith('IR')) {
        e.target.value = 'IR' + value;
    }
});

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        closeAccountModal();
        closeDeleteModal();
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAccountModal();
        closeDeleteModal();
    }
});

// Initialize table functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add any table-specific functionality here if needed
    console.log('Bank accounts table initialized');
});
</script>
@endpush
