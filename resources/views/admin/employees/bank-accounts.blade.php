@extends('admin.layout')

@section('title', 'حساب‌های بانکی - ' . $employee->full_name)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">حساب‌های بانکی</h1>
            <p class="page-subtitle">مدیریت حساب‌های بانکی {{ $employee->full_name }} - {{ $employee->employee_code }}</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="showAddAccountModal()">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                افزودن حساب بانکی
            </button>
            <a href="{{ route('admin.settings.banks') }}" class="btn btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                مدیریت بانک‌ها
            </a>
            <a href="{{ route('employees.index') }}" class="btn btn-light">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                بازگشت
            </a>
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

<!-- Bank Accounts Grid -->
<div class="bank-accounts-grid">
    @forelse($bankAccounts as $account)
    <div class="bank-card {{ $account->is_default ? 'default-account' : '' }}">
        <!-- Bank Card Design -->
        <div class="card-front {{ $account->is_default ? 'default-account' : '' }}">
            <!-- Bank Header -->
            <div class="bank-header">
                <div class="bank-logo-section">
                    <div class="bank-logo">
                        @if($account->bank->logo)
                            <img src="{{ asset('storage/' . $account->bank->logo) }}" alt="{{ $account->bank->name }}">
                        @else
                            <div class="bank-logo-placeholder">
                                <i class="fas fa-university"></i>
                            </div>
                        @endif
                    </div>
                    <div class="bank-name-section">
                        <div class="bank-name-persian">{{ $account->bank->name }}</div>
                        <div class="bank-name-english">Bank Card</div>
                    </div>
                </div>
                @if($account->is_default)
                    <span class="card-type-badge">حساب اصلی</span>
                @endif
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <div class="card-number-section">
                    @if($account->card_number)
                    <div class="card-number">{{ formatCardNumber($account->card_number) }}</div>
                    @else
                    <div class="card-number-placeholder">**** **** **** ****</div>
                    @endif
                </div>

                <div class="card-footer">
                    <div class="card-holder">
                        <div class="card-holder-label">صاحب حساب</div>
                        <div class="card-holder-name">{{ $account->account_holder_name }}</div>
                    </div>
                    <div class="card-expiry">
                        <div class="card-expiry-label">بانک</div>
                        <div class="card-expiry-value">{{ $account->bank->name }}</div>
                    </div>
                </div>
            </div>

            <div class="card-status">
                @if($account->is_active)
                    <span class="status-indicator active"></span>
                    <span class="status-text">فعال</span>
                @else
                    <span class="status-indicator inactive"></span>
                    <span class="status-text">غیرفعال</span>
                @endif
            </div>
        </div>

        <!-- Card Back - Additional Info -->
        <div class="card-back">
            <div class="card-back-header">
                <h4>اطلاعات حساب</h4>
            </div>

            <div class="card-back-details">
                @if($account->account_number)
                <div class="back-detail-item">
                    <span class="back-detail-label">شماره حساب</span>
                    <span class="back-detail-value">{{ $account->account_number }}</span>
                </div>
                @endif

                @if($account->iban)
                <div class="back-detail-item">
                    <span class="back-detail-label">شماره IBAN</span>
                    <span class="back-detail-value iban-text">{{ $account->iban }}</span>
                </div>
                @endif

                @if($account->sheba_number)
                <div class="back-detail-item">
                    <span class="back-detail-label">شماره شبا</span>
                    <span class="back-detail-value sheba-text">{{ formatShebaNumber($account->sheba_number) }}</span>
                </div>
                @endif

                @if($account->notes)
                <div class="back-detail-item full-width">
                    <span class="back-detail-label">یادداشت</span>
                    <span class="back-detail-value notes-text">{{ $account->notes }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Card Actions -->
        <div class="card-actions">
            @if(!$account->is_default)
            <button class="action-btn primary" onclick="setAsDefault({{ $account->id }})" title="تنظیم به عنوان اصلی">
                <i class="fas fa-star"></i>
            </button>
            @endif

            <button class="action-btn edit" onclick="editAccount({{ $account->id }})" title="ویرایش">
                <i class="fas fa-edit"></i>
            </button>

            <button class="action-btn delete" onclick="confirmDeleteAccount({{ $account->id }}, '{{ $account->bank->name }}')" title="حذف">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
        </div>
        <h3>هنوز حساب بانکی ای ثبت نشده</h3>
        <p>برای افزودن حساب بانکی جدید روی دکمه "افزودن حساب بانکی" کلیک کنید.</p>
        <button class="btn btn-primary" onclick="showAddAccountModal()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            افزودن اولین حساب بانکی
        </button>
    </div>
    @endforelse
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
                                    <a href="{{ route('admin.settings.banks') }}" class="btn btn-primary btn-sm">
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
                    <input type="text" id="card_number" name="card_number" class="form-input" placeholder="1234-5678-9012-3456" maxlength="19">
                </div>

                <div class="form-group">
                    <label for="iban" class="form-label">شماره IBAN</label>
                    <input type="text" id="iban" name="iban" class="form-input" placeholder="IR123456789012345678901234" maxlength="26">
                </div>

                <div class="form-group">
                    <label for="sheba_number" class="form-label">شماره شبا</label>
                    <input type="text" id="sheba_number" name="sheba_number" class="form-input" placeholder="IR12 3456 7890 1234 5678 90" maxlength="26">
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

/* Bank Cards Grid */
.bank-accounts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
    perspective: 1000px;
}

/* Bank Card Design */
.bank-card {
    position: relative;
    width: 100%;
    height: 220px;
    transform-style: preserve-3d;
    transition: transform 0.6s ease;
    cursor: default;
}

.bank-card:hover {
    transform: rotateY(10deg) rotateX(5deg);
}

.bank-card.default-account {
    transform: scale(1.02);
}

.bank-card.default-account:hover {
    transform: scale(1.05) rotateY(10deg) rotateX(5deg);
}

.bank-card.flipped {
    transform: rotateY(180deg);
}

.bank-card.flipped.default-account {
    transform: scale(1.02) rotateY(180deg);
}

/* Card Front - Real Bank Card Style */
.card-front {
    position: absolute;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 0;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    backface-visibility: hidden;
    display: flex;
    flex-direction: column;
    color: #212529;
    position: relative;
    overflow: hidden;
    border: 1px solid #dee2e6;
}

/* Bank Header Section */
.bank-header {
    background: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e9ecef;
}

.bank-logo-section {
    display: flex;
    align-items: center;
    gap: 10px;
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

.bank-name-section {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.bank-name-persian {
    font-size: 14px;
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.bank-name-english {
    font-size: 12px;
    color: #6c757d;
    margin: 0;
}

.card-type-badge {
    background: #dc3545;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
}

/* Card Body */
.card-body {
    flex: 1;
    background: linear-gradient(135deg, #fff5f5 0%, #ffe8e8 100%);
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
}

.card-body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #dc3545;
}

/* Card Number Section */
.card-number-section {
    text-align: center;
    margin: 20px 0;
    position: relative;
}

.card-number {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: 4px;
    font-family: 'Courier New', monospace;
    color: #212529;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.card-number-placeholder {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: 4px;
    font-family: 'Courier New', monospace;
    color: #6c757d;
}

/* Card Footer */
.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-top: auto;
}

.card-holder, .card-expiry {
    display: flex;
    flex-direction: column;
}

.card-holder-label, .card-expiry-label {
    font-size: 10px;
    color: #6c757d;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.card-holder-name, .card-expiry-value {
    font-size: 14px;
    font-weight: 600;
    color: #212529;
}

/* Card Status */
.card-status {
    position: absolute;
    bottom: 20px;
    left: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.status-indicator.active {
    background: #28a745;
    box-shadow: 0 0 8px rgba(40, 167, 69, 0.5);
}

.status-indicator.inactive {
    background: #dc3545;
    box-shadow: 0 0 8px rgba(220, 53, 69, 0.5);
}

.status-text {
    font-size: 12px;
    font-weight: 600;
    color: #6c757d;
}

/* Default Account Styling */
.card-front.default-account {
    background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
}

.card-front.default-account .card-body {
    background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
}

.card-front.default-account::after {
    content: '⭐';
    position: absolute;
    top: 15px;
    left: 15px;
    font-size: 20px;
    color: #ff9800;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Remove old styles - they are replaced above */

/* Card Back */
.card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    backface-visibility: hidden;
    transform: rotateY(180deg);
    display: flex;
    flex-direction: column;
    color: #374151;
}

.card-back-header {
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 15px;
    margin-bottom: 20px;
}

.card-back-header h4 {
    margin: 0;
    color: #1f2937;
    font-size: 18px;
    font-weight: 700;
}

.card-back-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.back-detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
}

.back-detail-item.full-width {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
}

.back-detail-label {
    font-size: 12px;
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.back-detail-value {
    font-size: 14px;
    color: #1f2937;
    font-weight: 600;
    font-family: 'Courier New', monospace;
}

.iban-text, .sheba-text {
    direction: ltr;
    text-align: left;
    background: #f8fafc;
    padding: 4px 8px;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
}

.notes-text {
    font-family: inherit;
    line-height: 1.4;
    background: #f8fafc;
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

/* Card Actions */
.card-actions {
    position: absolute;
    bottom: -15px;
    right: 20px;
    display: flex;
    gap: 8px;
    z-index: 10;
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    font-size: 14px;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
}

.action-btn.primary {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.action-btn.edit {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
}

.action-btn.delete {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.account-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.bank-name {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 4px;
}

.account-holder {
    font-size: 14px;
    color: #6b7280;
}

.account-badges {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-align: center;
    white-space: nowrap;
}

.badge-primary {
    background: #dbeafe;
    color: #1d4ed8;
}

.badge-success {
    background: #dcfce7;
    color: #15803d;
}

.badge-inactive {
    background: #f3f4f6;
    color: #6b7280;
}

.account-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 24px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-label {
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
}

.detail-value {
    font-size: 14px;
    color: #1f2937;
    font-weight: 500;
    font-family: 'Courier New', monospace;
}

.card-number,
.iban-number,
.sheba-number {
    direction: ltr;
    text-align: left;
    background: #f9fafb;
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
}

.account-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
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
    .bank-accounts-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .bank-card {
        height: 200px;
    }

    .bank-header {
        padding: 12px 15px;
    }

    .bank-logo {
        width: 35px;
        height: 35px;
        font-size: 16px;
    }

    .bank-name-persian {
        font-size: 12px;
    }

    .bank-name-english {
        font-size: 10px;
    }

    .card-body {
        padding: 15px;
    }

    .card-number, .card-number-placeholder {
        font-size: 20px;
        letter-spacing: 3px;
    }

    .card-holder-name, .card-expiry-value {
        font-size: 12px;
    }

    .card-actions {
        bottom: -10px;
        right: 15px;
    }

    .action-btn {
        width: 35px;
        height: 35px;
        font-size: 12px;
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
    .bank-card {
        height: 180px;
    }

    .bank-header {
        padding: 10px 12px;
    }

    .bank-logo {
        width: 30px;
        height: 30px;
        font-size: 14px;
    }

    .bank-name-persian {
        font-size: 11px;
    }

    .bank-name-english {
        font-size: 9px;
    }

    .card-body {
        padding: 12px;
    }

    .card-number, .card-number-placeholder {
        font-size: 18px;
        letter-spacing: 2px;
    }

    .card-holder-name, .card-expiry-value {
        font-size: 11px;
    }

    .card-holder-label, .card-expiry-label {
        font-size: 9px;
    }

    .card-actions {
        bottom: -8px;
        right: 12px;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        font-size: 11px;
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
    // In a real implementation, you would fetch the account data via AJAX
    // For now, we'll just show the modal with the title changed
    document.getElementById('modalTitle').textContent = 'ویرایش حساب بانکی';
    document.getElementById('accountId').value = accountId;
    document.getElementById('accountModal').style.display = 'flex';

    // TODO: Populate form with account data
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
        url = `/employee-bank-accounts/${accountId}`;
        formData.append('_method', 'PUT');
        method = 'POST';
    } else {
        url = '/employees/{{ $employee->id }}/bank-accounts';
        method = 'POST';
    }

    fetch(url, {
        method: method,
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);

        if (!response.ok) {
            if (response.status === 422) {
                return response.json().then(data => {
                    throw new Error('خطا در اعتبارسنجی: ' + JSON.stringify(data.errors));
                });
            }
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return response.json();
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
        alert('خطا در ذخیره اطلاعات: ' + error.message);
    });
}

// Set account as default
function setAsDefault(accountId) {
    const form = document.getElementById('setDefaultForm');
    form.action = `/employees/{{ $employee->id }}/bank-accounts/${accountId}/set-default`;
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
        form.action = `/employees/{{ $employee->id }}/bank-accounts/${currentAccountId}`;
        form.submit();
    }
}

// Format card number input
document.getElementById('card_number').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{4})(?=\d)/g, '$1-');
    if (value.length > 19) value = value.substr(0, 19);
    e.target.value = value;
});

// Format SHEBA number input
document.getElementById('sheba_number').addEventListener('input', function(e) {
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

// Bank card flip functionality - DISABLED
// Cards no longer flip on click to prevent position changes
document.addEventListener('DOMContentLoaded', function() {
    const bankCards = document.querySelectorAll('.bank-card');

    bankCards.forEach(card => {
        // Remove click event listener to prevent card flipping
        // card.addEventListener('click', function() {
        //     this.classList.toggle('flipped');
        // });

        // Action buttons work independently
        const actionButtons = card.querySelectorAll('.action-btn');
        actionButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });
});
</script>
@endpush
