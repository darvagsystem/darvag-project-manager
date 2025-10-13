@extends('admin.layout')

@section('title', 'تنظیمات شرکت')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">تنظیمات شرکت</h1>
            <p class="page-subtitle">مدیریت اطلاعات کلی شرکت و تنظیمات سیستم</p>
        </div>
        <a href="{{ route('panel.settings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i>
            بازگشت به تنظیمات
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>خطا در ذخیره اطلاعات:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="settings-container">
    <form action="{{ route('panel.settings.company.update') }}" method="POST" enctype="multipart/form-data" class="settings-form">
        @csrf

        <!-- Company Basic Information -->
        <div class="form-section">
            <div class="section-header">
                <h2><i class="fas fa-building"></i> اطلاعات کلی شرکت</h2>
                <p>اطلاعات اصلی و هویت شرکت</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="company_name">نام شرکت *</label>
                    <input type="text" id="company_name" name="company_name"
                           value="{{ old('company_name', $settings->company_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="ceo_name">نام مدیرعامل</label>
                    <input type="text" id="ceo_name" name="ceo_name"
                           value="{{ old('ceo_name', $settings->ceo_name) }}">
                </div>

                <div class="form-group">
                    <label for="national_id">شناسه ملی</label>
                    <input type="text" id="national_id" name="national_id"
                           value="{{ old('national_id', $settings->national_id) }}"
                           maxlength="11" pattern="[0-9]{10,11}">
                </div>

                <div class="form-group">
                    <label for="economic_id">شناسه اقتصادی</label>
                    <input type="text" id="economic_id" name="economic_id"
                           value="{{ old('economic_id', $settings->economic_id) }}">
                </div>
            </div>

            <div class="form-group full-width">
                <label for="description">توضیحات شرکت</label>
                <textarea id="description" name="description" rows="3">{{ old('description', $settings->description) }}</textarea>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="form-section">
            <div class="section-header">
                <h2><i class="fas fa-map-marker-alt"></i> اطلاعات تماس و آدرس</h2>
                <p>اطلاعات تماس و موقعیت شرکت</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="phone">تلفن تماس</label>
                    <input type="text" id="phone" name="phone"
                           value="{{ old('phone', $settings->phone) }}">
                </div>

                <div class="form-group">
                    <label for="email">ایمیل</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $settings->email) }}">
                </div>

                <div class="form-group">
                    <label for="website">وب‌سایت</label>
                    <input type="text" id="website" name="website"
                           value="{{ old('website', $settings->website) }}">
                </div>

                <div class="form-group">
                    <label for="postal_code">کد پستی</label>
                    <input type="text" id="postal_code" name="postal_code"
                           value="{{ old('postal_code', $settings->postal_code) }}"
                           maxlength="10" pattern="[0-9]{10}">
                </div>
            </div>

            <div class="form-group full-width">
                <label for="company_address">آدرس کامل</label>
                <textarea id="company_address" name="company_address" rows="3">{{ old('company_address', $settings->company_address) }}</textarea>
            </div>
        </div>

        <!-- Logo Upload -->
        <div class="form-section">
            <div class="section-header">
                <h2><i class="fas fa-image"></i> لوگو شرکت</h2>
                <p>آپلود و مدیریت لوگو شرکت</p>
            </div>

            <div class="logo-upload-section">
                <div class="current-logo">
                    @if($settings->company_logo)
                        <img src="{{ asset('storage/' . $settings->company_logo) }}" alt="لوگو شرکت" id="logoPreview">
                    @else
                        <div class="no-logo" id="logoPreview">
                            <i class="fas fa-building"></i>
                            <span>لوگو آپلود نشده</span>
                        </div>
                    @endif
                </div>

                <div class="logo-upload-controls">
                    <input type="file" id="company_logo" name="company_logo" accept="image/*" style="display: none;">
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('company_logo').click();">
                        <i class="fas fa-upload"></i>
                        انتخاب لوگو جدید
                    </button>
                    <small>فرمت‌های مجاز: JPG, PNG, GIF - حداکثر 2MB</small>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                ذخیره تنظیمات
            </button>
            <a href="{{ route('panel.settings.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                انصراف
            </a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
/* Base styles */
* {
    box-sizing: border-box;
}

body {
    direction: rtl;
    font-family: 'Vazirmatn', 'Tahoma', Arial, sans-serif;
}

.settings-container {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 0;
}

.settings-form {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 0;
}

.form-section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    width: 100%;
}

.section-header {
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f5f9;
    width: 100%;
}

.section-header h2 {
    font-size: 20px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-header h2 i {
    color: #3b82f6;
}

.section-header p {
    color: #64748b;
    font-size: 14px;
    margin: 0;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
    width: 100%;
}

.form-group {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.form-group.full-width {
    grid-column: 1 / -1;
    width: 100%;
}

.form-group label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 14px;
    text-align: right;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    font-family: inherit;
    direction: rtl;
    text-align: right;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.logo-upload-section {
    display: flex;
    gap: 30px;
    align-items: flex-start;
    width: 100%;
    flex-wrap: wrap;
}

.current-logo {
    flex-shrink: 0;
}

.current-logo img {
    width: 120px;
    height: 120px;
    object-fit: contain;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 10px;
    background: #f9fafb;
}

.no-logo {
    width: 120px;
    height: 120px;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    background: #f9fafb;
}

.no-logo i {
    font-size: 24px;
    margin-bottom: 8px;
}

.no-logo span {
    font-size: 12px;
}

.logo-upload-controls {
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex: 1;
    min-width: 200px;
}

.logo-upload-controls small {
    color: #6b7280;
    font-size: 12px;
}

.form-actions {
    display: flex;
    gap: 15px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
    margin-top: 30px;
    width: 100%;
    justify-content: flex-start;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: none;
    min-width: 140px;
    justify-content: center;
}

.btn-primary {
    background-color: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background-color: #2563eb;
}

.btn-secondary {
    background-color: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background-color: #4b5563;
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    width: 100%;
}

.alert i {
    margin-top: 2px;
    flex-shrink: 0;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.alert-error {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.alert ul {
    margin: 5px 0 0 0;
    padding-right: 20px;
}

.alert li {
    margin-bottom: 5px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .form-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
}

@media (max-width: 992px) {
    .form-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }

    .logo-upload-section {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-section {
        padding: 20px;
        margin-bottom: 20px;
    }

    .form-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }

    .settings-container {
        padding: 0 10px;
    }
}

@media (max-width: 576px) {
    .section-header h2 {
        font-size: 18px;
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }

    .form-group input,
    .form-group textarea {
        padding: 10px 12px;
        font-size: 16px; /* Prevents zoom on iOS */
    }

    .logo-upload-section {
        gap: 20px;
    }

    .current-logo img,
    .no-logo {
        width: 100px;
        height: 100px;
    }
}

/* Fix for RTL layout */
.form-group input[type="email"],
.form-group input[type="url"] {
    direction: ltr;
    text-align: left;
}

.form-group input[type="tel"] {
    direction: ltr;
    text-align: left;
}

/* Ensure full width utilization */
.page-header,
.alert,
.settings-container,
.settings-form,
.form-section {
    box-sizing: border-box;
}
</style>
@endpush

@push('scripts')
<script>
// Logo preview functionality
document.getElementById('company_logo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('logoPreview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="پیش‌نمایش لوگو" style="width: 120px; height: 120px; object-fit: contain; border: 2px solid #e5e7eb; border-radius: 12px; padding: 10px; background: #f9fafb;">`;
        };
        reader.readAsDataURL(file);
    }
});

// Form validation
document.querySelector('.settings-form').addEventListener('submit', function(e) {
    const companyName = document.getElementById('company_name').value.trim();

    if (!companyName) {
        e.preventDefault();
        alert('نام شرکت الزامی است');
        document.getElementById('company_name').focus();
        return;
    }

    // Validate national ID
    const nationalId = document.getElementById('national_id').value.trim();
    if (nationalId && !/^\d{10,11}$/.test(nationalId)) {
        e.preventDefault();
        alert('شناسه ملی باید 10 یا 11 رقم باشد');
        document.getElementById('national_id').focus();
        return;
    }

    // Validate postal code
    const postalCode = document.getElementById('postal_code').value.trim();
    if (postalCode && !/^\d{10}$/.test(postalCode)) {
        e.preventDefault();
        alert('کد پستی باید 10 رقم باشد');
        document.getElementById('postal_code').focus();
        return;
    }
});

// Auto-format fields
document.getElementById('national_id').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

document.getElementById('postal_code').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Ensure proper RTL behavior for number inputs
document.addEventListener('DOMContentLoaded', function() {
    const numberInputs = document.querySelectorAll('input[type="text"][pattern*="[0-9]"]');
    numberInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            // Keep cursor at the right position for RTL number inputs
            const start = this.selectionStart;
            const end = this.selectionEnd;

            // Clean non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');

            // Restore cursor position
            this.setSelectionRange(start, end);
        });
    });
});
</script>
@endpush
