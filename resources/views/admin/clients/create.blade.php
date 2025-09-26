@extends('admin.layout')

@section('title', 'افزودن کارفرمای جدید')

@section('content')
<div class="page-header">
    <h1 class="page-title">افزودن کارفرمای جدید</h1>
    <p class="page-subtitle">اطلاعات کارفرما یا مشتری جدید را وارد کنید</p>
</div>

<!-- اضافه کردن action به form -->
<form class="client-form" method="POST" action="{{ route('clients.store') }}" enctype="multipart/form-data">
    @csrf

    <!-- نمایش خطاهای validation -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-sections">
        <!-- Basic Information Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات پایه</h3>
                <p class="section-subtitle">اطلاعات اساسی کارفرما</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">نام شرکت *</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">وضعیت *</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="">انتخاب کنید</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>فعال</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="description" class="form-label">درباره شرکت</label>
                    <textarea id="description" name="description" class="form-textarea" rows="4" placeholder="توضیحات کوتاه در مورد شرکت...">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Logo Upload Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">لوگو شرکت</h3>
                <p class="section-subtitle">لوگو یا تصویر شرکت را آپلود کنید</p>
            </div>

            <div class="logo-upload-container">
                <div class="logo-preview">
                    <div class="logo-placeholder">
                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>پیش‌نمایش لوگو</span>
                    </div>
                    <img id="logo-preview" src="" alt="پیش‌نمایش لوگو" style="display: none;">
                </div>

                <div class="logo-upload">
                    <input type="file" id="logo" name="logo" accept="image/*" class="file-input">
                    <label for="logo" class="file-label">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        انتخاب فایل
                    </label>
                    <p class="file-info">فرمت‌های مجاز: PNG, JPG, SVG - حداکثر 2MB</p>
                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات تماس</h3>
                <p class="section-subtitle">راه‌های ارتباط با شرکت</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="email" class="form-label">ایمیل</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">تلفن</label>
                    <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <label for="website" class="form-label">وب‌سایت</label>
                    <input type="url" id="website" name="website" class="form-input" value="{{ old('website') }}" placeholder="https://example.com">
                </div>

                <div class="form-group full-width">
                    <label for="address" class="form-label">آدرس</label>
                    <textarea id="address" name="address" class="form-textarea" rows="3" placeholder="آدرس کامل شرکت...">{{ old('address') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <button type="button" id="fillTestData" class="btn btn-warning">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
            پر کردن با داده تست
        </button>
        <button type="submit" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            ایجاد کارفرما
        </button>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            انصراف
        </a>
    </div>
</form>
@endsection

@push('styles')
<style>
.client-form {
    max-width: 1000px;
    margin: 0 auto;
}

/* اضافه کردن استایل برای نمایش خطاها */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 8px;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.alert li {
    margin-bottom: 5px;
}

.form-sections {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.form-section {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: var(--shadow-light);
}

.section-header {
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--border-light);
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.section-subtitle {
    font-size: 14px;
    color: var(--text-light);
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
    color: var(--text-dark);
    margin-bottom: 8px;
}

.form-input,
.form-select,
.form-textarea {
    padding: 12px 16px;
    border: 1px solid var(--border-light);
    border-radius: 8px;
    font-family: inherit;
    font-size: 14px;
    transition: var(--transition);
    background: white;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.form-textarea {
    resize: vertical;
    min-height: 80px;
}

.logo-upload-container {
    display: flex;
    gap: 20px;
    align-items: flex-start;
}

.logo-preview {
    width: 120px;
    height: 120px;
    border-radius: 12px;
    border: 2px dashed var(--border-light);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-light);
    overflow: hidden;
}

.logo-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    color: var(--text-light);
    font-size: 12px;
    text-align: center;
}

#logo-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.logo-upload {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.file-input {
    display: none;
}

.file-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: var(--primary-light);
    color: var(--primary-color);
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    border: 1px solid var(--primary-color);
    text-decoration: none;
}

.file-label:hover {
    background: var(--primary-color);
    color: white;
}

.file-info {
    font-size: 12px;
    color: var(--text-light);
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--border-light);
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: var(--transition);
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.btn-secondary {
    background: var(--bg-light);
    color: var(--text-dark);
    border: 1px solid var(--border-light);
}

.btn-secondary:hover {
    background: var(--border-light);
}

.btn-warning {
    background: #f59e0b;
    color: white;
}

.btn-warning:hover {
    background: #d97706;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .logo-upload-container {
        flex-direction: column;
        align-items: center;
    }

    .form-actions {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logo-preview');
    const logoPlaceholder = document.querySelector('.logo-placeholder');

    logoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                logoPreview.src = e.target.result;
                logoPreview.style.display = 'block';
                logoPlaceholder.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });

    // اصلاح JavaScript - حذف preventDefault و اجازه submit طبیعی
    const form = document.querySelector('.client-form');
    form.addEventListener('submit', function(e) {
        // بررسی validation در سمت client
        const requiredFields = form.querySelectorAll('[required]');
        let hasError = false;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = '#ef4444';
                hasError = true;
            } else {
                field.style.borderColor = '#d1d5db';
            }
        });

        // اگر خطا داشت، جلوگیری از submit
        if (hasError) {
            e.preventDefault();
            alert('لطفاً تمام فیلدهای الزامی را پر کنید.');
            return false;
        }

        // اگر خطا نداشت، اجازه submit دادن به backend
        // هیچ preventDefault نمی‌زنیم تا فرم به backend ارسال شود
    });

    // Fill test data button
    const fillTestDataBtn = document.getElementById('fillTestData');
    if (fillTestDataBtn) {
        fillTestDataBtn.addEventListener('click', function() {
            document.getElementById('name').value = 'شرکت تست';
            document.getElementById('email').value = 'test@company.com';
            document.getElementById('phone').value = '021-12345678';
            document.getElementById('website').value = 'https://test-company.com';
            document.getElementById('address').value = 'تهران، خیابان ولیعصر، پلاک 123';
            document.getElementById('description').value = 'این یک شرکت تست برای آزمایش فرم است.';
            document.getElementById('status').value = 'active';

            alert('فرم با داده‌های تست پر شد.');
        });
    }
});
</script>
@endpush
