@extends('admin.layout')

@section('title', 'افزودن کارمند جدید')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">افزودن کارمند جدید</h1>
        <p class="page-subtitle">ثبت اطلاعات کامل کارمند</p>
    </div>
</div>

<!-- Validation Errors -->
@if($errors->any())
    <div class="alert alert-danger">
        <h4>خطاهای اعتبارسنجی:</h4>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form class="employee-form" method="POST" action="{{ route('panel.employees.store') }}" enctype="multipart/form-data">
    @csrf

    <!-- Personal Information Section -->
    <div class="form-section">
        <div class="section-header">
            <h3 class="section-title">اطلاعات شخصی</h3>
            <p class="section-subtitle">اطلاعات هویتی و شخصی کارمند</p>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="first_name" class="form-label">نام *</label>
                <input type="text" id="first_name" name="first_name" class="form-input @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required placeholder="احمد" autocomplete="given-name">
                @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="last_name" class="form-label">نام خانوادگی *</label>
                <input type="text" id="last_name" name="last_name" class="form-input @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required placeholder="رضایی" autocomplete="family-name">
                @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="national_code" class="form-label">کد ملی *</label>
                <input type="text" id="national_code" name="national_code" class="form-input @error('national_code') is-invalid @enderror" value="{{ old('national_code') }}" required placeholder="1234567890" maxlength="10" autocomplete="off">
                <small class="form-help">کد پرسنلی به صورت خودکار از کد ملی ساخته می‌شود (مثال: DVG0810158116)</small>
                @error('national_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="birth_date" class="form-label">تاریخ تولد</label>
                <input type="text" id="birth_date" name="birth_date" class="form-input @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}" placeholder="1370/05/20">
                @error('birth_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="marital_status" class="form-label">وضعیت تأهل</label>
                <select id="marital_status" name="marital_status" class="form-select @error('marital_status') is-invalid @enderror">
                    <option value="">انتخاب وضعیت</option>
                    <option value="single" {{ old('marital_status') === 'single' ? 'selected' : '' }}>مجرد</option>
                    <option value="married" {{ old('marital_status') === 'married' ? 'selected' : '' }}>متأهل</option>
                    <option value="divorced" {{ old('marital_status') === 'divorced' ? 'selected' : '' }}>مطلقه</option>
                    <option value="widowed" {{ old('marital_status') === 'widowed' ? 'selected' : '' }}>بیوه</option>
                </select>
                @error('marital_status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="education" class="form-label">سطح تحصیلات</label>
                <select id="education" name="education" class="form-select @error('education') is-invalid @enderror">
                    <option value="">انتخاب سطح تحصیلات</option>
                    <option value="illiterate" {{ old('education') === 'illiterate' ? 'selected' : '' }}>بی‌سواد</option>
                    <option value="elementary" {{ old('education') === 'elementary' ? 'selected' : '' }}>ابتدایی</option>
                    <option value="middle_school" {{ old('education') === 'middle_school' ? 'selected' : '' }}>راهنمایی</option>
                    <option value="high_school" {{ old('education') === 'high_school' ? 'selected' : '' }}>دبیرستان</option>
                    <option value="diploma" {{ old('education') === 'diploma' ? 'selected' : '' }}>دیپلم</option>
                    <option value="associate" {{ old('education') === 'associate' ? 'selected' : '' }}>فوق دیپلم</option>
                    <option value="bachelor" {{ old('education') === 'bachelor' ? 'selected' : '' }}>کارشناسی</option>
                    <option value="master" {{ old('education') === 'master' ? 'selected' : '' }}>کارشناسی ارشد</option>
                    <option value="phd" {{ old('education') === 'phd' ? 'selected' : '' }}>دکتری</option>
                </select>
                @error('education')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status" class="form-label">وضعیت کاری</label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="">انتخاب وضعیت</option>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>فعال</option>
                    <option value="vacation" {{ old('status') === 'vacation' ? 'selected' : '' }}>مرخصی</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                    <option value="terminated" {{ old('status') === 'terminated' ? 'selected' : '' }}>خاتمه همکاری</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Contact Information Section -->
    <div class="form-section">
        <div class="section-header">
            <h3 class="section-title">اطلاعات تماس</h3>
            <p class="section-subtitle">شماره تماس و آدرس کارمند</p>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="phone" class="form-label">تلفن ثابت</label>
                <input type="text" id="phone" name="phone" class="form-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="051-38234567">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="mobile" class="form-label">تلفن همراه</label>
                <input type="text" id="mobile" name="mobile" class="form-input @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" placeholder="09151234567">
                @error('mobile')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">ایمیل</label>
                <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="ahmad.rezaei@darvag.com" autocomplete="email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="emergency_contact" class="form-label">تماس اضطراری</label>
                <input type="text" id="emergency_contact" name="emergency_contact" class="form-input @error('emergency_contact') is-invalid @enderror" value="{{ old('emergency_contact') }}" placeholder="نام و شماره تماس">
                @error('emergency_contact')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="address" class="form-label">آدرس</label>
                <textarea id="address" name="address" class="form-textarea @error('address') is-invalid @enderror" rows="4" placeholder="آدرس کامل محل سکونت">{{ old('address') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Avatar Upload Section -->
    <div class="form-section">
        <div class="section-header">
            <h3 class="section-title">تصویر پروفایل</h3>
            <p class="section-subtitle">آپلود تصویر کارمند</p>
        </div>

        <div class="avatar-upload">
            <div class="avatar-preview">
                <div class="avatar-placeholder" id="avatarPlaceholder">
                    <i class="fas fa-user"></i>
                    <span>بدون تصویر</span>
                </div>
            </div>
            <div class="upload-controls">
                <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('avatar').click();">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    انتخاب تصویر
                </button>
                <small>فرمت‌های مجاز: JPG, PNG, GIF - حداکثر 2MB</small>
                @error('avatar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Notes Section -->
    <div class="form-section">
        <div class="section-header">
            <h3 class="section-title">یادداشت‌ها</h3>
            <p class="section-subtitle">نکات و توضیحات اضافی</p>
        </div>

        <div class="form-group">
            <label for="notes" class="form-label">یادداشت‌ها</label>
            <textarea id="notes" name="notes" class="form-textarea @error('notes') is-invalid @enderror" rows="6" placeholder="یادداشت‌ها و توضیحات اضافی">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <button type="submit" class="btn btn-primary" id="submitBtn">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px; margin-left: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="submitText">ثبت کارمند</span>
            <div id="submitSpinner" class="btn-spinner" style="display: none;">
                <div class="spinner-sm"></div>
            </div>
        </button>
        <a href="{{ route('panel.employees.index') }}" class="btn btn-light">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            بازگشت
        </a>
    </div>
</form>
@endsection

@push('styles')
<style>
/* Base styles */
.employee-form {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Alert styles */
.alert {
    padding: 16px 20px;
    border-radius: 8px;
    margin-bottom: 24px;
    border: 1px solid;
}

.alert-danger {
    background-color: #fef2f2;
    border-color: #fecaca;
    color: #dc2626;
}

.alert-success {
    background-color: #f0fdf4;
    border-color: #bbf7d0;
    color: #16a34a;
}

.alert h4 {
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: 600;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

.alert li {
    margin-bottom: 4px;
}

/* Form Sections */
.form-section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 24px;
}

.section-header {
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 2px solid #f1f5f9;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 4px;
}

.section-subtitle {
    font-size: 14px;
    color: #6b7280;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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

/* Validation styles */
.form-input.is-invalid,
.form-select.is-invalid,
.form-textarea.is-invalid {
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.invalid-feedback {
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
    display: block;
}

.form-help {
    color: #6b7280;
    font-size: 12px;
    margin-top: 4px;
    display: block;
}

/* Avatar Upload */
.avatar-upload {
    display: flex;
    align-items: center;
    gap: 24px;
    padding: 20px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.avatar-preview {
    width: 120px;
    height: 120px;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #e5e7eb;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f9fafb;
    color: #9ca3af;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
}

.avatar-placeholder i {
    font-size: 28px;
    margin-bottom: 8px;
}

.avatar-placeholder span {
    font-size: 12px;
}

.upload-controls {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.upload-controls small {
    color: #6b7280;
    font-size: 12px;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

/* Buttons */
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
    min-width: 120px;
    justify-content: center;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover {
    background: #059669;
}

.btn-light {
    background: #f8fafc;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-light:hover {
    background: #f1f5f9;
}

/* Responsive Design */
/* Button loading state */
.btn-spinner {
    display: inline-flex;
    align-items: center;
    margin-left: 8px;
}

.spinner-sm {
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Enhanced form validation styles */
.form-input.is-invalid,
.form-select.is-invalid,
.form-textarea.is-invalid {
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.validation-error {
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
    display: none;
    font-weight: 500;
}

.form-input.is-valid {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

/* Success message styling */
.form-input.is-valid + .validation-success {
    color: #10b981;
    font-size: 12px;
    margin-top: 4px;
    display: block;
    font-weight: 500;
}

/* Loading overlay for form submission */
.form-loading {
    position: relative;
    pointer-events: none;
    opacity: 0.7;
}

.form-loading::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    z-index: 10;
    border-radius: 12px;
}

/* Improved focus styles */
.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

/* Better placeholder styling */
.form-input::placeholder,
.form-textarea::placeholder {
    color: #9ca3af;
    opacity: 1;
}

/* Enhanced button hover effects */
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn:active {
    transform: translateY(0);
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-section {
        padding: 20px;
    }

    .avatar-upload {
        flex-direction: column;
        text-align: center;
    }

    .form-actions {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Avatar preview functionality
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const placeholder = document.getElementById('avatarPlaceholder');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            placeholder.innerHTML = `<img src="${e.target.result}" alt="پیش‌نمایش تصویر" style="width: 100%; height: 100%; object-fit: cover;">`;
        };
        reader.readAsDataURL(file);
    } else {
        placeholder.innerHTML = `
            <i class="fas fa-user"></i>
            <span>بدون تصویر</span>
        `;
    }
});

// Auto-format fields
document.getElementById('national_code').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Set default status to active and add validation
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('status').value = 'active';
    document.getElementById('marital_status').value = 'single';
    document.getElementById('education').value = 'diploma';

    // Add real-time validation
    addFormValidation();
});

// Form validation
function addFormValidation() {
    const form = document.querySelector('.employee-form');
    const nationalCodeInput = document.getElementById('national_code');
    const emailInput = document.getElementById('email');
    const firstNameInput = document.getElementById('first_name');
    const lastNameInput = document.getElementById('last_name');

    // National code validation
    nationalCodeInput.addEventListener('input', function() {
        validateNationalCode(this);
    });

    // Email validation
    emailInput.addEventListener('input', function() {
        validateEmail(this);
    });

    // Name validation
    firstNameInput.addEventListener('input', function() {
        validateName(this, 'نام');
    });

    lastNameInput.addEventListener('input', function() {
        validateName(this, 'نام خانوادگی');
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            showValidationErrors();
        }
    });
}

// Validate national code
function validateNationalCode(input) {
    const value = input.value.trim();
    const errorElement = getOrCreateErrorElement(input);

    if (value.length === 0) {
        showFieldError(input, errorElement, 'کد ملی الزامی است');
        return false;
    }

    if (value.length !== 10) {
        showFieldError(input, errorElement, 'کد ملی باید 10 رقم باشد');
        return false;
    }

    if (!/^\d{10}$/.test(value)) {
        showFieldError(input, errorElement, 'کد ملی باید فقط شامل اعداد باشد');
        return false;
    }

    // Check for valid national code algorithm
    if (!isValidNationalCode(value)) {
        showFieldError(input, errorElement, 'کد ملی معتبر نیست');
        return false;
    }

    hideFieldError(input, errorElement);
    return true;
}

// Validate email
function validateEmail(input) {
    const value = input.value.trim();
    const errorElement = getOrCreateErrorElement(input);

    if (value.length === 0) {
        hideFieldError(input, errorElement);
        return true; // Email is optional
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(value)) {
        showFieldError(input, errorElement, 'فرمت ایمیل صحیح نیست');
        return false;
    }

    hideFieldError(input, errorElement);
    return true;
}

// Validate name fields
function validateName(input, fieldName) {
    const value = input.value.trim();
    const errorElement = getOrCreateErrorElement(input);

    if (value.length === 0) {
        showFieldError(input, errorElement, `${fieldName} الزامی است`);
        return false;
    }

    if (value.length < 2) {
        showFieldError(input, errorElement, `${fieldName} باید حداقل 2 کاراکتر باشد`);
        return false;
    }

    if (!/^[\u0600-\u06FF\s]+$/.test(value)) {
        showFieldError(input, errorElement, `${fieldName} باید فارسی باشد`);
        return false;
    }

    hideFieldError(input, errorElement);
    return true;
}

// Validate entire form
function validateForm() {
    const nationalCode = validateNationalCode(document.getElementById('national_code'));
    const email = validateEmail(document.getElementById('email'));
    const firstName = validateName(document.getElementById('first_name'), 'نام');
    const lastName = validateName(document.getElementById('last_name'), 'نام خانوادگی');

    return nationalCode && email && firstName && lastName;
}

// Show validation errors
function showValidationErrors() {
    const errorAlert = document.createElement('div');
    errorAlert.className = 'alert alert-danger';
    errorAlert.innerHTML = '<h4>خطاهای اعتبارسنجی:</h4><p>لطفاً فیلدهای قرمز را تصحیح کنید.</p>';

    const firstSection = document.querySelector('.form-section');
    firstSection.parentNode.insertBefore(errorAlert, firstSection);

    // Remove after 5 seconds
    setTimeout(() => {
        errorAlert.remove();
    }, 5000);

    // Scroll to top
    window.scrollTo(0, 0);
}

// Utility functions
function getOrCreateErrorElement(input) {
    let errorElement = input.parentNode.querySelector('.validation-error');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'validation-error';
        errorElement.style.cssText = 'color: #dc2626; font-size: 12px; margin-top: 4px; display: none;';
        input.parentNode.appendChild(errorElement);
    }
    return errorElement;
}

function showFieldError(input, errorElement, message) {
    input.classList.add('is-invalid');
    errorElement.textContent = message;
    errorElement.style.display = 'block';
}

function hideFieldError(input, errorElement) {
    input.classList.remove('is-invalid');
    errorElement.style.display = 'none';
}

// Iranian national code validation algorithm
function isValidNationalCode(nationalCode) {
    // Convert to string and remove any non-numeric characters
    nationalCode = nationalCode.toString().replace(/\D/g, '');

    // Check length
    if (nationalCode.length !== 10) {
        return false;
    }

    // Check for repetitive numbers
    if (/^(\d)\1{9}$/.test(nationalCode)) {
        return false;
    }

    // Calculate checksum
    let sum = 0;
    for (let i = 0; i < 9; i++) {
        sum += parseInt(nationalCode[i]) * (10 - i);
    }

    const remainder = sum % 11;
    const checkDigit = parseInt(nationalCode[9]);

    if (remainder < 2) {
        return checkDigit === remainder;
    } else {
        return checkDigit === 11 - remainder;
    }
}
</script>
@endpush
