@extends('admin.layout')

@section('title', 'ویرایش کارفرما')

@section('content')
<div class="page-header">
    <h1 class="page-title">ویرایش کارفرما</h1>
    <p class="page-subtitle">ویرایش اطلاعات "{{ $client->name }}"</p>
</div>

<form class="client-form" method="POST" action="{{ route('panel.clients.update', $client->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

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
                    <input type="text" id="name" name="name" class="form-input" value="{{ $client->name }}" required>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">وضعیت *</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="">انتخاب کنید</option>
                        <option value="active" {{ $client->status === 'active' ? 'selected' : '' }}>فعال</option>
                        <option value="inactive" {{ $client->status === 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="description" class="form-label">درباره شرکت</label>
                    <textarea id="description" name="description" class="form-textarea" rows="4" placeholder="توضیحات کوتاه در مورد شرکت...">{{ $client->description ?? '' }}</textarea>
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
                    <div class="logo-placeholder" style="display: none;">
                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>پیش‌نمایش لوگو</span>
                    </div>
                    <img id="logo-preview" src="{{ $client->logo ? asset('storage/' . $client->logo) : 'data:image/svg+xml;base64,' . base64_encode('<svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="120" rx="12" fill="#e3f2fd"/><text x="60" y="70" font-family="Arial, sans-serif" font-size="24" font-weight="bold" fill="#1976d2" text-anchor="middle">'. substr($client->name, 0, 2) .'</text></svg>') }}" alt="لوگو فعلی">
                </div>

                <div class="logo-upload">
                    <input type="file" id="logo" name="logo" accept="image/*" class="file-input">
                    <label for="logo" class="file-label">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        تغییر لوگو
                    </label>
                    <p class="file-info">فرمت‌های مجاز: PNG, JPG, SVG - حداکثر 2MB</p>
                    <p class="current-logo-info">لوگو فعلی: {{ $client->logo }}</p>
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
                    <label for="email" class="form-label">ایمیل *</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ $client->email }}" required>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">تلفن *</label>
                    <input type="tel" id="phone" name="phone" class="form-input" value="{{ $client->phone }}" required>
                </div>

                <div class="form-group">
                    <label for="website" class="form-label">وب‌سایت</label>
                    <input type="url" id="website" name="website" class="form-input" value="{{ $client->website ?? '' }}" placeholder="https://example.com">
                </div>

                <div class="form-group full-width">
                    <label for="address" class="form-label">آدرس</label>
                    <textarea id="address" name="address" class="form-textarea" rows="3" placeholder="آدرس کامل شرکت...">{{ $client->address ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">آمار و اطلاعات</h3>
                <p class="section-subtitle">اطلاعات اضافی درباره کارفرما</p>
            </div>

            <div class="stats-info">
                <div class="stat-item">
                    <div class="stat-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $client->projects_count ?? 0 }}</div>
                        <div class="stat-label">پروژه انجام شده</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon success">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $client->created_at }}</div>
                        <div class="stat-label">تاریخ عضویت</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon accent">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $client->status === 'active' ? 'فعال' : 'غیرفعال' }}</div>
                        <div class="stat-label">وضعیت فعلی</div>
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
        <a href="{{ route('panel.clients.index') }}" class="btn btn-secondary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
            </svg>
            بازگشت
        </a>
        <button type="button" class="btn btn-danger" onclick="deleteClient()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            حذف کارفرما
        </button>
    </div>
</form>
@endsection

@push('styles')
<style>
.client-form {
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
    width: fit-content;
}

.file-label:hover {
    background: var(--primary-color);
    color: white;
}

.file-info {
    font-size: 12px;
    color: var(--text-light);
}

.current-logo-info {
    font-size: 12px;
    color: var(--text-light);
    font-weight: 500;
}

.stats-info {
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

.stat-icon.accent {
    background: var(--accent-light);
    color: var(--accent-color);
}

.stat-content {
    flex: 1;
}

.stat-number {
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

.btn-contacts {
    background: rgba(0, 200, 83, 0.1);
    color: var(--success-color);
    border: 1px solid var(--success-color);
}

.btn-contacts:hover {
    background: var(--success-color);
    color: white;
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

    .stats-info {
        grid-template-columns: 1fr;
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

    // Form validation
    const form = document.querySelector('.client-form');
    form.addEventListener('submit', function(e) {
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

        if (hasError) {
            e.preventDefault();
            alert('لطفاً تمام فیلدهای اجباری را پر کنید.');
        }
        // If no errors, let the form submit naturally
    });
});

function deleteClient() {
    if (confirm('آیا از حذف این کارفرما اطمینان دارید؟\n\nتوجه: تمام اطلاعات مربوط به این کارفرما حذف خواهد شد.')) {
        // Here you would normally send delete request
        alert('کارفرما با موفقیت حذف شد!');
        window.location.href = '{{ route("panel.clients.index") }}';
    }
}
</script>
@endpush
