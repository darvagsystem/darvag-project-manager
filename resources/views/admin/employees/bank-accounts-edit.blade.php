@extends('admin.layout')

@section('title', 'ویرایش حساب بانکی - ' . $employee->full_name)

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <div class="breadcrumb">
                <a href="{{ route('panel.employees.index') }}" class="breadcrumb-link">مدیریت پرسنل</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('panel.employees.bank-accounts', $employee->id) }}" class="breadcrumb-link">حساب‌های بانکی</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">ویرایش حساب</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-edit"></i>
                ویرایش حساب بانکی
            </h1>
            <p class="page-subtitle">
                <i class="fas fa-user"></i>
                {{ $employee->full_name }}
                <span class="employee-code">({{ $employee->employee_code }})</span>
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('panel.employees.bank-accounts', $employee->id) }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-right"></i>
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

<!-- Edit Form -->
<div class="edit-form-container">
    <div class="form-card">
        <div class="form-header">
            <h3>ویرایش اطلاعات حساب بانکی</h3>
            <p>اطلاعات حساب بانکی {{ $bankAccount->bank->name }} را ویرایش کنید</p>
        </div>

        <form id="editAccountForm" method="POST" action="{{ route('panel.employee-bank-accounts.update', $bankAccount->id) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="employee_id" value="{{ $employee->id }}">

            <div class="form-grid">
                <div class="form-group">
                    <label for="bank_id" class="form-label">بانک *</label>
                    @if($banks->count() > 0)
                        <select id="bank_id" name="bank_id" class="form-select" required>
                            <option value="">انتخاب بانک</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ $bankAccount->bank_id == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <div class="no-banks-warning">
                            <div class="warning-content">
                                <i class="fas fa-exclamation-triangle"></i>
                                <div>
                                    <h4>هیچ بانکی تعریف نشده</h4>
                                    <p>برای ویرایش حساب بانکی، ابتدا باید بانک‌ها را تعریف کنید.</p>
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
                    <input type="text" id="account_holder_name" name="account_holder_name" class="form-input" required
                           value="{{ old('account_holder_name', $bankAccount->account_holder_name) }}"
                           placeholder="نام کامل صاحب حساب">
                </div>

                <div class="form-group">
                    <label for="account_number" class="form-label">شماره حساب</label>
                    <input type="text" id="account_number" name="account_number" class="form-input"
                           value="{{ old('account_number', $bankAccount->account_number) }}"
                           placeholder="1234567890">
                </div>

                <div class="form-group">
                    <label for="card_number" class="form-label">شماره کارت</label>
                    <div class="input-group">
                        <input type="text" id="card_number" name="card_number" class="form-input"
                               value="{{ old('card_number', $bankAccount->card_number) }}"
                               placeholder="1234-5678-9012-3456" maxlength="19">
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
                    <input type="text" id="iban" name="iban" class="form-input"
                           value="{{ old('iban', $bankAccount->iban) }}"
                           placeholder="IR123456789012345678901234" maxlength="26">
                    <small class="form-text text-muted">شماره شبا همان IBAN است</small>
                </div>

                <div class="form-group full-width">
                    <label for="notes" class="form-label">یادداشت</label>
                    <textarea id="notes" name="notes" class="form-textarea" rows="3"
                              placeholder="توضیحات اضافی">{{ old('notes', $bankAccount->notes) }}</textarea>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="is_default" name="is_default" value="1"
                                   {{ old('is_default', $bankAccount->is_default) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            تنظیم به عنوان حساب اصلی
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $bankAccount->is_active) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            حساب فعال
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i>
                    ذخیره تغییرات
                </button>
                <a href="{{ route('panel.employees.bank-accounts', $employee->id) }}" class="btn btn-light btn-lg">
                    <i class="fas fa-times"></i>
                    انصراف
                </a>
            </div>
        </form>
    </div>
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

/* Employee Info Card */
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

/* Edit Form Container */
.edit-form-container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.form-card {
    padding: 0;
}

.form-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 30px;
    border-bottom: 1px solid #e5e7eb;
}

.form-header h3 {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 8px 0;
}

.form-header p {
    color: #6b7280;
    margin: 0;
    font-size: 16px;
}

/* Form Styles */
#editAccountForm {
    padding: 30px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 30px;
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

.form-text {
    font-size: 12px;
    color: #6b7280;
    margin-top: 4px;
}

/* Input Group */
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

/* Checkbox Group */
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

/* Form Actions */
.form-actions {
    display: flex;
    gap: 16px;
    justify-content: flex-end;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    justify-content: center;
}

.btn-lg {
    padding: 16px 32px;
    font-size: 16px;
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

.btn-outline-primary {
    background: transparent;
    color: #3b82f6;
    border: 1px solid #3b82f6;
}

.btn-outline-primary:hover {
    background: #3b82f6;
    color: white;
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

/* Responsive Design */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .form-actions {
        flex-direction: column;
    }

    .employee-info-card {
        flex-direction: column;
        text-align: center;
    }

    .header-content {
        flex-direction: column;
        text-align: center;
    }

    .header-actions {
        align-items: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
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

// Format IBAN input
document.getElementById('iban').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^0-9]/g, '');
    if (value.length > 22) value = value.substr(0, 22);

    // Add IR prefix if not present
    if (value.length > 0 && !e.target.value.startsWith('IR')) {
        e.target.value = 'IR' + value;
    }
});

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

// Form submission
document.getElementById('editAccountForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال ذخیره...';
    submitBtn.disabled = true;

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);

        if (response.ok) {
            return response.json();
        } else {
            return response.text().then(text => {
                console.log('Error response text:', text);
                throw new Error('خطا در سرور: ' + response.status);
            });
        }
    })
    .then(data => {
        if (data.success) {
            showNotification('حساب بانکی با موفقیت به‌روزرسانی شد', 'success');
            setTimeout(() => {
                window.location.href = '{{ route("panel.employees.bank-accounts", $employee->id) }}';
            }, 1500);
        } else {
            showNotification('خطا در ذخیره اطلاعات: ' + (data.message || 'خطای نامشخص'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('خطا در ذخیره اطلاعات: ' + error.message, 'error');
    })
    .finally(() => {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>

<style>
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
</style>
@endpush
