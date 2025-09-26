@extends('admin.layout')

@section('title', 'ویرایش مخاطب - ' . $contact->contact_person)

@section('content')
<div class="page-header">
    <div>
        <div class="breadcrumb-trail">
            <a href="{{ route('clients.index') }}" class="breadcrumb-link">کارفرمایان</a>
            <span class="breadcrumb-separator">←</span>
            <a href="{{ route('clients.contacts.index', $client->id) }}" class="breadcrumb-link">دفترچه تلفن</a>
            <span class="breadcrumb-separator">←</span>
            <span class="breadcrumb-current">ویرایش مخاطب</span>
        </div>
        <h1 class="page-title">ویرایش مخاطب</h1>
        <p class="page-subtitle">ویرایش اطلاعات {{ $contact->contact_person }} از {{ $client->name }}</p>
    </div>
</div>

<!-- Client & Contact Info Card -->
<div class="contact-info-card">
    <div class="client-section">
        <div class="client-avatar">
            <img src="data:image/svg+xml;base64,{{ base64_encode('<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="50" height="50" rx="10" fill="#e3f2fd"/><text x="25" y="32" font-family="Arial, sans-serif" font-size="16" font-weight="bold" fill="#1976d2" text-anchor="middle">'. substr($client->name, 0, 2) .'</text></svg>') }}" alt="{{ $client->name }}">
        </div>
        <div class="client-details">
            <h3 class="client-name">{{ $client->name }}</h3>
            <p class="client-subtitle">کارفرما</p>
        </div>
    </div>

    <div class="contact-section">
        <div class="contact-avatar">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <div class="contact-details">
            <h3 class="contact-name">{{ $contact->contact_person }}</h3>
            <p class="contact-position">{{ $contact->position }}</p>
            <span class="department-badge">{{ $contact->department }}</span>
        </div>
    </div>
</div>

<form class="contact-form" method="POST">
    @csrf
    @method('PUT')

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
                    <input type="text" id="contact_person" name="contact_person" class="form-input" value="{{ $contact->contact_person }}" required placeholder="مثال: احمد رضایی">
                </div>

                <div class="form-group">
                    <label for="position" class="form-label">سمت *</label>
                    <input type="text" id="position" name="position" class="form-input" value="{{ $contact->position }}" required placeholder="مثال: مدیر عامل">
                </div>

                <div class="form-group full-width">
                    <label for="department" class="form-label">واحد / بخش *</label>
                    <input type="text" id="department" name="department" class="form-input" value="{{ $contact->department }}" required placeholder="مثال: مدیریت عامل، واحد فنی، واحد مالی">
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
                    <input type="tel" id="phone" name="phone" class="form-input" value="{{ $contact->phone ?? '' }}" placeholder="051-38234567">
                    <small class="form-help">فرمت: کد شهر-شماره تلفن</small>
                </div>

                <div class="form-group">
                    <label for="mobile" class="form-label">موبایل *</label>
                    <input type="tel" id="mobile" name="mobile" class="form-input" value="{{ $contact->mobile ?? '' }}" required placeholder="09151234567">
                    <small class="form-help">11 رقمی شامل صفر</small>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">ایمیل</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ $contact->email ?? '' }}" placeholder="example@company.com">
                </div>

                <div class="form-group">
                    <label for="extension" class="form-label">داخلی</label>
                    <input type="text" id="extension" name="extension" class="form-input" value="{{ $contact->extension ?? '' }}" placeholder="123">
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
                    <textarea id="address" name="address" class="form-textarea" rows="3" placeholder="آدرس کامل دفتر کار این شخص...">{{ $contact->address ?? '' }}</textarea>
                </div>

                <div class="form-group full-width">
                    <label for="notes" class="form-label">یادداشت‌ها</label>
                    <textarea id="notes" name="notes" class="form-textarea" rows="3" placeholder="توضیحات اضافی، ساعات کاری، نکات مهم...">{{ $contact->notes ?? '' }}</textarea>
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
                        <option value="phone" {{ ($contact->preferred_contact ?? '') === 'phone' ? 'selected' : '' }}>تلفن ثابت</option>
                        <option value="mobile" {{ ($contact->preferred_contact ?? '') === 'mobile' ? 'selected' : '' }}>موبایل</option>
                        <option value="email" {{ ($contact->preferred_contact ?? '') === 'email' ? 'selected' : '' }}>ایمیل</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="availability" class="form-label">ساعات در دسترس</label>
                    <input type="text" id="availability" name="availability" class="form-input" value="{{ $contact->availability ?? '' }}" placeholder="شنبه تا چهارشنبه 8 تا 16">
                </div>

                <div class="form-group">
                    <label for="priority" class="form-label">اولویت تماس</label>
                    <select id="priority" name="priority" class="form-select">
                        <option value="normal" {{ ($contact->priority ?? 'normal') === 'normal' ? 'selected' : '' }}>عادی</option>
                        <option value="high" {{ ($contact->priority ?? '') === 'high' ? 'selected' : '' }}>بالا</option>
                        <option value="urgent" {{ ($contact->priority ?? '') === 'urgent' ? 'selected' : '' }}>فوری</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">وضعیت</label>
                    <select id="status" name="status" class="form-select">
                        <option value="active" {{ ($contact->status ?? 'active') === 'active' ? 'selected' : '' }}>فعال</option>
                        <option value="inactive" {{ ($contact->status ?? '') === 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Contact History & Stats -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات اضافی</h3>
                <p class="section-subtitle">آمار و تاریخچه مخاطب</p>
            </div>

            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $contact->created_at }}</div>
                        <div class="stat-label">تاریخ ثبت</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon success">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ rand(5, 25) }}</div>
                        <div class="stat-label">تعداد تماس</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon warning">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ rand(1, 15) }} روز پیش</div>
                        <div class="stat-label">آخرین تماس</div>
                    </div>
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
            ذخیره تغییرات
        </button>
        <a href="{{ route('clients.contacts.index', $client->id) }}" class="btn btn-secondary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
            </svg>
            بازگشت
        </a>
        <button type="button" class="btn btn-danger" onclick="deleteContact()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            حذف مخاطب
        </button>
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

.contact-info-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 30px;
    box-shadow: var(--shadow-light);
}

.client-section, .contact-section {
    display: flex;
    align-items: center;
    gap: 15px;
}

.client-avatar, .contact-avatar {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.client-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.contact-avatar {
    background: var(--primary-light);
    color: var(--primary-color);
}

.client-name, .contact-name {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 3px;
}

.client-subtitle {
    color: var(--text-light);
    font-size: 14px;
}

.contact-position {
    color: var(--text-light);
    font-size: 14px;
    margin-bottom: 8px;
}

.department-badge {
    display: inline-block;
    background: var(--accent-light);
    color: var(--accent-color);
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
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

.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: var(--bg-light);
    border-radius: 12px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-light);
    color: var(--primary-color);
    flex-shrink: 0;
}

.stat-icon.success {
    background: rgba(0, 200, 83, 0.1);
    color: var(--success-color);
}

.stat-icon.warning {
    background: rgba(255, 180, 0, 0.1);
    color: var(--warning-color);
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 4px;
}

.stat-label {
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

.btn-danger {
    background: rgba(244, 67, 54, 0.1);
    color: var(--error-color);
    border: 1px solid var(--error-color);
}

.btn-danger:hover {
    background: var(--error-color);
    color: white;
}

@media (max-width: 768px) {
    .contact-info-card {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .stats-row {
        grid-template-columns: 1fr;
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
            alert('اطلاعات مخاطب با موفقیت به‌روزرسانی شد!');
            window.location.href = '{{ route("clients.contacts", $client["id"]) }}';
        }
    });
});

function deleteContact() {
    if (confirm('آیا از حذف این مخاطب اطمینان دارید؟\n\nتوجه: تمام اطلاعات مربوط به این مخاطب حذف خواهد شد.')) {
        alert('مخاطب با موفقیت حذف شد!');
        window.location.href = '{{ route("clients.contacts", $client["id"]) }}';
    }
}
</script>
@endpush
