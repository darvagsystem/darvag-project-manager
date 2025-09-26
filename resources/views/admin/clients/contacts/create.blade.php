@extends('admin.layout')

@section('title', 'افزودن مخاطب جدید - ' . $client->name)

@section('content')
<div class="page-header">
    <div>
        <div class="breadcrumb-trail">
            <a href="{{ route('clients.index') }}" class="breadcrumb-link">کارفرمایان</a>
            <span class="breadcrumb-separator">←</span>
            <a href="{{ route('clients.contacts.index', $client->id) }}" class="breadcrumb-link">دفترچه تلفن</a>
            <span class="breadcrumb-separator">←</span>
            <span class="breadcrumb-current">افزودن مخاطب</span>
        </div>
        <h1 class="page-title">افزودن مخاطب جدید</h1>
        <p class="page-subtitle">افزودن مخاطب جدید به دفترچه تلفن {{ $client->name }}</p>
    </div>
</div>

<!-- Client Info Card -->
<div class="client-info-card">
    <div class="client-avatar">
        <img src="data:image/svg+xml;base64,{{ base64_encode('<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="50" height="50" rx="10" fill="#e3f2fd"/><text x="25" y="32" font-family="Arial, sans-serif" font-size="16" font-weight="bold" fill="#1976d2" text-anchor="middle">'. substr($client->name, 0, 2) .'</text></svg>') }}" alt="{{ $client->name }}">
    </div>
    <div class="client-details">
        <h3 class="client-name">{{ $client->name }}</h3>
        <p class="client-subtitle">افزودن مخاطب جدید به دفترچه تلفن</p>
    </div>
</div>

<form class="contact-form" method="POST">
    @csrf

    <div class="form-sections">
        <!-- Contact Person Information -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات شخص</h3>
                <p class="section-subtitle">اطلاعات شخص مسئول یا مخاطب</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="contact_person" class="form-label">نام و نام خانوادگی *</label>
                    <input type="text" id="contact_person" name="contact_person" class="form-input" required placeholder="مثال: احمد رضایی">
                </div>

                <div class="form-group">
                    <label for="position" class="form-label">سمت *</label>
                    <input type="text" id="position" name="position" class="form-input" required placeholder="مثال: مدیر عامل">
                </div>

                <div class="form-group full-width">
                    <label for="department" class="form-label">واحد / بخش *</label>
                    <input type="text" id="department" name="department" class="form-input" required placeholder="مثال: مدیریت عامل، واحد فنی، واحد مالی">
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات تماس</h3>
                <p class="section-subtitle">شماره تلفن‌ها و ایمیل</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="phone" class="form-label">تلفن ثابت</label>
                    <input type="tel" id="phone" name="phone" class="form-input" placeholder="051-38234567">
                    <small class="form-help">فرمت: کد شهر-شماره تلفن</small>
                </div>

                <div class="form-group">
                    <label for="mobile" class="form-label">موبایل *</label>
                    <input type="tel" id="mobile" name="mobile" class="form-input" required placeholder="09151234567">
                    <small class="form-help">11 رقمی شامل صفر</small>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">ایمیل</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="example@company.com">
                </div>

                <div class="form-group">
                    <label for="extension" class="form-label">داخلی</label>
                    <input type="text" id="extension" name="extension" class="form-input" placeholder="123">
                    <small class="form-help">شماره داخلی در صورت وجود</small>
                </div>
            </div>
        </div>

        <!-- Address & Additional Info -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">آدرس و اطلاعات تکمیلی</h3>
                <p class="section-subtitle">آدرس دفتر کار و یادداشت‌ها</p>
            </div>

            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="address" class="form-label">آدرس دفتر کار</label>
                    <textarea id="address" name="address" class="form-textarea" rows="3" placeholder="آدرس کامل دفتر کار این شخص..."></textarea>
                </div>

                <div class="form-group full-width">
                    <label for="notes" class="form-label">یادداشت‌ها</label>
                    <textarea id="notes" name="notes" class="form-textarea" rows="3" placeholder="توضیحات اضافی، ساعات کاری، نکات مهم..."></textarea>
                </div>
            </div>
        </div>

        <!-- Contact Preferences -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">تنظیمات تماس</h3>
                <p class="section-subtitle">ترجیحات و زمان‌بندی تماس</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="preferred_contact" class="form-label">روش ترجیحی تماس</label>
                    <select id="preferred_contact" name="preferred_contact" class="form-select">
                        <option value="">انتخاب کنید</option>
                        <option value="phone">تلفن ثابت</option>
                        <option value="mobile">موبایل</option>
                        <option value="email">ایمیل</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="availability" class="form-label">ساعات در دسترس</label>
                    <input type="text" id="availability" name="availability" class="form-input" placeholder="شنبه تا چهارشنبه 8 تا 16">
                </div>

                <div class="form-group">
                    <label for="priority" class="form-label">اولویت تماس</label>
                    <select id="priority" name="priority" class="form-select">
                        <option value="normal" selected>عادی</option>
                        <option value="high">بالا</option>
                        <option value="urgent">فوری</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">وضعیت</label>
                    <select id="status" name="status" class="form-select">
                        <option value="active" selected>فعال</option>
                        <option value="inactive">غیرفعال</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            ذخیره مخاطب
        </button>
        <a href="{{ route('clients.contacts.index', $client->id) }}" class="btn btn-secondary">
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
.breadcrumb-trail {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    font-size: 14px;
}

.breadcrumb-link {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb-link:hover {
    text-decoration: underline;
}

.breadcrumb-separator {
    color: var(--text-light);
}

.breadcrumb-current {
    color: var(--text-dark);
    font-weight: 600;
}

.client-info-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: var(--shadow-light);
}

.client-avatar {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
}

.client-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.client-details {
    flex: 1;
}

.client-name {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 3px;
}

.client-subtitle {
    color: var(--text-light);
    font-size: 14px;
}

.contact-form {
    max-width: 1000px;
    margin: 0 auto;
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

.form-help {
    margin-top: 5px;
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

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .client-info-card {
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
document.addEventListener('DOMContentLoaded', function() {
    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    const mobileInput = document.getElementById('mobile');

    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 3) {
                value = value.substring(0, 3) + '-' + value.substring(3);
            }
            e.target.value = value;
        });
    }

    if (mobileInput) {
        mobileInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            e.target.value = value;
        });
    }

    // Form validation
    const form = document.querySelector('.contact-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Basic validation
        const requiredFields = form.querySelectorAll('[required]');
        let hasError = false;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = 'var(--error-color)';
                hasError = true;
            } else {
                field.style.borderColor = 'var(--border-light)';
            }
        });

        // Mobile number validation
        const mobile = mobileInput.value.trim();
        if (mobile && !mobile.match(/^09\d{9}$/)) {
            mobileInput.style.borderColor = 'var(--error-color)';
            alert('شماره موبایل باید 11 رقمی و با 09 شروع شود');
            hasError = true;
        }

        // Email validation
        const emailInput = document.getElementById('email');
        const email = emailInput.value.trim();
        if (email && !email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            emailInput.style.borderColor = 'var(--error-color)';
            alert('فرمت ایمیل صحیح نیست');
            hasError = true;
        }

        if (!hasError) {
            alert('مخاطب جدید با موفقیت اضافه شد!');
            window.location.href = '{{ route("clients.contacts", $client->id) }}';
        }
    });
});
</script>
@endpush
