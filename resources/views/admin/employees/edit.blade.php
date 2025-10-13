@extends('admin.layout')

@section('title', 'ویرایش کارمند - ' . $employee['first_name'] . ' ' . $employee['last_name'])

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">ویرایش کارمند</h1>
        <p class="page-subtitle">ویرایش اطلاعات "{{ $employee['first_name'] }} {{ $employee['last_name'] }}" - {{ $employee['employee_code'] }}</p>
    </div>
</div>

<!-- Employee Info Header -->
<div class="employee-info-header">
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
            <p class="employee-info">کد پرسنلی: {{ $employee->employee_code }}</p>
            <div class="employee-meta">
                <span class="employee-code">{{ $employee->national_code }}</span>
                <span class="employee-hire-date">تاریخ ثبت: {{ $employee->created_at->format('Y/m/d') }}</span>
            </div>
        </div>
    </div>

    <div class="employee-stats">
        <div class="stat-item">
            <div class="stat-value">{{ $employee->formatted_education }}</div>
            <div class="stat-label">تحصیلات</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $employee->formatted_status }}</div>
            <div class="stat-label">وضعیت</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $employee->formatted_marital_status }}</div>
            <div class="stat-label">وضعیت تأهل</div>
        </div>
    </div>
</div>

<form class="employee-form" method="POST" action="{{ route('panel.employees.update', $employee->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-sections">
        <!-- Personal Information Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات شخصی</h3>
                <p class="section-subtitle">اطلاعات هویتی و شخصی کارمند</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">کد پرسنلی</label>
                    <div class="form-display">{{ $employee->employee_code }}</div>
                    <small class="form-help">کد پرسنلی به صورت خودکار از کد ملی ساخته می‌شود</small>
                </div>

                <div class="form-group">
                    <label for="first_name" class="form-label">نام *</label>
                    <input type="text" id="first_name" name="first_name" class="form-input" value="{{ $employee->first_name }}" required placeholder="احمد">
                </div>

                <div class="form-group">
                    <label for="last_name" class="form-label">نام خانوادگی *</label>
                    <input type="text" id="last_name" name="last_name" class="form-input" value="{{ $employee->last_name }}" required placeholder="رضایی">
                </div>

                <div class="form-group">
                    <label for="national_code" class="form-label">کد ملی *</label>
                    <input type="text" id="national_code" name="national_code" class="form-input" value="{{ $employee->national_code }}" required placeholder="1234567890" maxlength="10">
                </div>

                <div class="form-group">
                    <label for="birth_date" class="form-label">تاریخ تولد</label>
                    <input type="text" id="birth_date" name="birth_date" class="form-input" value="{{ $employee->birth_date }}" placeholder="1370/05/20">
                </div>

                <div class="form-group">
                    <label for="marital_status" class="form-label">وضعیت تأهل</label>
                    <select id="marital_status" name="marital_status" class="form-select">
                        <option value="">انتخاب وضعیت</option>
                        <option value="single" {{ $employee->marital_status === 'single' ? 'selected' : '' }}>مجرد</option>
                        <option value="married" {{ $employee->marital_status === 'married' ? 'selected' : '' }}>متأهل</option>
                        <option value="divorced" {{ $employee->marital_status === 'divorced' ? 'selected' : '' }}>مطلقه</option>
                        <option value="widowed" {{ $employee->marital_status === 'widowed' ? 'selected' : '' }}>بیوه</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="education" class="form-label">سطح تحصیلات</label>
                    <select id="education" name="education" class="form-select">
                        <option value="">انتخاب سطح تحصیلات</option>
                        <option value="illiterate" {{ $employee->education === 'illiterate' ? 'selected' : '' }}>بی‌سواد</option>
                        <option value="elementary" {{ $employee->education === 'elementary' ? 'selected' : '' }}>ابتدایی</option>
                        <option value="middle_school" {{ $employee->education === 'middle_school' ? 'selected' : '' }}>راهنمایی</option>
                        <option value="high_school" {{ $employee->education === 'high_school' ? 'selected' : '' }}>دبیرستان</option>
                        <option value="diploma" {{ $employee->education === 'diploma' ? 'selected' : '' }}>دیپلم</option>
                        <option value="associate" {{ $employee->education === 'associate' ? 'selected' : '' }}>فوق دیپلم</option>
                        <option value="bachelor" {{ $employee->education === 'bachelor' ? 'selected' : '' }}>کارشناسی</option>
                        <option value="master" {{ $employee->education === 'master' ? 'selected' : '' }}>کارشناسی ارشد</option>
                        <option value="phd" {{ $employee->education === 'phd' ? 'selected' : '' }}>دکتری</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">وضعیت کاری</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">انتخاب وضعیت</option>
                        <option value="active" {{ $employee->status === 'active' ? 'selected' : '' }}>فعال</option>
                        <option value="vacation" {{ $employee->status === 'vacation' ? 'selected' : '' }}>مرخصی</option>
                        <option value="inactive" {{ $employee->status === 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                        <option value="terminated" {{ $employee->status === 'terminated' ? 'selected' : '' }}>خاتمه همکاری</option>
                    </select>
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
                    <input type="text" id="phone" name="phone" class="form-input" value="{{ $employee->phone }}" placeholder="051-38234567">
                </div>

                <div class="form-group">
                    <label for="mobile" class="form-label">تلفن همراه</label>
                    <input type="text" id="mobile" name="mobile" class="form-input" value="{{ $employee->mobile }}" placeholder="09151234567">
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">ایمیل</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ $employee->email }}" placeholder="ahmad.rezaei@darvag.com">
                </div>

                <div class="form-group full-width">
                    <label for="address" class="form-label">آدرس</label>
                    <textarea id="address" name="address" class="form-textarea" rows="3" placeholder="آدرس کامل محل سکونت">{{ $employee->address }}</textarea>
                </div>

                <div class="form-group full-width">
                    <label for="emergency_contact" class="form-label">تماس اضطراری</label>
                    <input type="text" id="emergency_contact" name="emergency_contact" class="form-input" value="{{ $employee->emergency_contact }}" placeholder="نام و شماره تماس">
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
                <div class="current-avatar">
                    @if($employee->avatar && $employee->avatar !== 'default-avatar.png' && file_exists(public_path('storage/' . $employee->avatar)))
                        <img src="{{ asset('storage/' . $employee->avatar) }}" alt="تصویر فعلی" id="avatarPreview">
                    @else
                        <div class="no-avatar" id="avatarPreview">
                            <i class="fas fa-user"></i>
                            <span>بدون تصویر</span>
                        </div>
                    @endif
                </div>
                <div class="upload-controls">
                    <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('avatar').click();">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        انتخاب تصویر جدید
                    </button>
                    <small>فرمت‌های مجاز: JPG, PNG, GIF - حداکثر 2MB</small>
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
                <textarea id="notes" name="notes" class="form-textarea" rows="4" placeholder="یادداشت‌ها و توضیحات اضافی">{{ $employee->notes }}</textarea>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px; margin-left: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            به‌روزرسانی کارمند
        </button>
        <a href="{{ route('panel.employees.index') }}" class="btn btn-secondary">
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

.employee-info-header {
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
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    border: 3px solid #e5e7eb;
}

.employee-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.employee-details {
    flex: 1;
}

.employee-name {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 6px;
}

.employee-info {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 10px;
}

.employee-meta {
    display: flex;
    gap: 20px;
    font-size: 13px;
    color: #9ca3af;
}

.employee-stats {
    display: flex;
    gap: 20px;
}

.stat-item {
    text-align: center;
    padding: 12px 16px;
    background: #f9fafb;
    border-radius: 8px;
    min-width: 80px;
}

.stat-value {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 12px;
    color: #6b7280;
}

.form-sections {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.form-section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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

.form-display {
    padding: 12px 16px;
    background: #f9fafb;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    color: #374151;
    font-weight: 600;
    font-family: monospace;
}

.form-help {
    color: #6b7280;
    font-size: 12px;
    margin-top: 4px;
    display: block;
}

.avatar-upload {
    display: flex;
    align-items: center;
    gap: 24px;
}

.current-avatar {
    width: 100px;
    height: 100px;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #e5e7eb;
}

.current-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.upload-controls {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.upload-controls small {
    color: #6b7280;
    font-size: 12px;
}

.form-actions {
    display: flex;
    gap: 16px;
    justify-content: flex-start;
    margin-top: 30px;
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
    min-width: 140px;
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

/* Responsive Design */
@media (max-width: 768px) {
    .employee-info-header {
        flex-direction: column;
        text-align: center;
    }

    .employee-main-info {
        flex-direction: column;
        text-align: center;
    }

    .employee-stats {
        flex-direction: column;
        width: 100%;
    }

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

.no-avatar {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f9fafb;
    color: #9ca3af;
    font-size: 24px;
}

.no-avatar span {
    font-size: 12px;
    margin-top: 4px;
}
</style>
@endpush

@push('scripts')
<script>
// Avatar preview functionality
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('avatarPreview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Form validation
document.querySelector('.employee-form').addEventListener('submit', function(e) {
    const requiredFields = ['first_name', 'last_name', 'national_code'];

    for (const field of requiredFields) {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            e.preventDefault();
            alert(`فیلد ${input.previousElementSibling.textContent} الزامی است`);
            input.focus();
            return;
        }
    }

    // Validate national code
    const nationalCode = document.getElementById('national_code').value.trim();
    if (!/^\d{10}$/.test(nationalCode)) {
        e.preventDefault();
        alert('کد ملی باید 10 رقم باشد');
        document.getElementById('national_code').focus();
        return;
    }
});

// Auto-format fields
document.getElementById('national_code').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
@endpush
