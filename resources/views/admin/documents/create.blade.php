@extends('admin.layout')

@section('title', 'افزودن سند جدید')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">افزودن سند جدید</h1>
        <p class="page-subtitle">آپلود فرم یا سند آماده</p>
    </div>
    <div>
        <a href="{{ route('panel.documents.index') }}" class="btn btn-light me-2">
            <i class="mdi mdi-arrow-right me-1"></i>
            بازگشت به داشبورد
        </a>
        <a href="{{ route('panel.documents.list') }}" class="btn btn-outline-light">
            <i class="mdi mdi-view-list me-1"></i>
            لیست مدارک
        </a>
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
        <i class="mdi mdi-check-circle me-1"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="mdi mdi-alert-circle me-1"></i>
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('panel.documents.store') }}" enctype="multipart/form-data" class="document-form">
    @csrf

    <div class="row">
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">اطلاعات اصلی</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="title" class="form-label">عنوان سند *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="form_code" class="form-label">کد فرم</label>
                                <input type="text" class="form-control @error('form_code') is-invalid @enderror"
                                       id="form_code" name="form_code" value="{{ old('form_code') }}"
                                       placeholder="خودکار تولید می‌شود">
                                @error('form_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">اگر خالی باشد، کد خودکار تولید می‌شود</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description" class="form-label">توضیحات</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="category_id" class="form-label">دسته‌بندی *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" required>
                                    <option value="">انتخاب دسته‌بندی</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @foreach($category->children as $child)
                                            <option value="{{ $child->id }}" {{ old('category_id') == $child->id ? 'selected' : '' }}>
                                                &nbsp;&nbsp;{{ $child->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tags" class="form-label">برچسب‌ها</label>
                                <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                       id="tags" name="tags" value="{{ old('tags') }}"
                                       placeholder="برچسب‌ها را با کاما جدا کنید">
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">مثال: فرم استخدام، قرارداد، گزارش</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Upload -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">آپلود فایل</h5>
                </div>
                <div class="card-body">
                    <div class="file-upload-area">
                        <input type="file" class="form-control @error('file') is-invalid @enderror"
                               id="file" name="file" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar">
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="file-upload-info mt-2">
                            <small class="text-muted">
                                <i class="mdi mdi-information me-1"></i>
                                فرمت‌های مجاز: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, ZIP, RAR
                                <br>
                                حداکثر حجم: 10 مگابایت
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Version Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">اطلاعات نسخه</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="version_name" class="form-label">نام نسخه</label>
                        <input type="text" class="form-control @error('version_name') is-invalid @enderror"
                               id="version_name" name="version_name" value="{{ old('version_name', 'نسخه اولیه') }}">
                        @error('version_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="changelog" class="form-label">تغییرات</label>
                        <textarea class="form-control @error('changelog') is-invalid @enderror"
                                  id="changelog" name="changelog" rows="3">{{ old('changelog', 'نسخه اولیه سند') }}</textarea>
                        @error('changelog')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">عملیات سریع</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-upload me-1"></i>
                            آپلود سند
                        </button>
                        <a href="{{ route('panel.documents.index') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-right me-1"></i>
                            انصراف
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
.document-form .card {
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.document-form .card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.file-upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    transition: border-color 0.3s ease;
}

.file-upload-area:hover {
    border-color: #3b82f6;
}

.file-upload-area input[type="file"] {
    border: none;
    background: transparent;
}

.file-upload-info {
    color: #6c757d;
    font-size: 0.875rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 0.75rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.invalid-feedback {
    display: block;
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
    padding: 0.75rem 1rem;
}

.btn-primary {
    background: #3b82f6;
    border-color: #3b82f6;
}

.btn-primary:hover {
    background: #2563eb;
    border-color: #2563eb;
}
</style>
@endpush

@push('scripts')
<script>
// Auto-generate form code if empty
document.getElementById('form_code').addEventListener('blur', function() {
    if (!this.value) {
        const title = document.getElementById('title').value;
        if (title) {
            const code = 'DOC-' + title.replace(/\s+/g, '-').toUpperCase().substring(0, 8);
            this.value = code;
        }
    }
});

// File upload preview and validation
document.getElementById('file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileInfo = document.querySelector('.file-upload-info');

    if (file) {
        // Check file size (10MB limit)
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        if (file.size > maxSize) {
            fileInfo.innerHTML = `
                <div class="alert alert-danger">
                    <i class="mdi mdi-alert-circle me-1"></i>
                    <strong>خطا:</strong> حجم فایل بیش از 10 مگابایت است
                    <br>
                    <small>حجم فایل: ${(file.size / 1024 / 1024).toFixed(2)} مگابایت</small>
                </div>
            `;
            this.value = ''; // Clear the file input
            return;
        }

        // Check file type
        const allowedTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar'];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedTypes.includes(fileExtension)) {
            fileInfo.innerHTML = `
                <div class="alert alert-danger">
                    <i class="mdi mdi-alert-circle me-1"></i>
                    <strong>خطا:</strong> فرمت فایل مجاز نیست
                    <br>
                    <small>فرمت‌های مجاز: ${allowedTypes.join(', ')}</small>
                </div>
            `;
            this.value = ''; // Clear the file input
            return;
        }

        // Show file info
        fileInfo.innerHTML = `
            <div class="alert alert-success">
                <i class="mdi mdi-file-check me-1"></i>
                <strong>${file.name}</strong>
                <br>
                <small>حجم: ${(file.size / 1024 / 1024).toFixed(2)} مگابایت | فرمت: ${fileExtension.toUpperCase()}</small>
            </div>
        `;
    } else {
        fileInfo.innerHTML = `
            <small class="text-muted">
                <i class="mdi mdi-information me-1"></i>
                فرمت‌های مجاز: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, ZIP, RAR
                <br>
                حداکثر حجم: 10 مگابایت
            </small>
        `;
    }
});

// Form submission validation
document.querySelector('.document-form').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('file');
    const titleInput = document.getElementById('title');
    const categoryInput = document.getElementById('category_id');

    let hasErrors = false;

    // Clear previous error styles
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });

    // Validate title
    if (!titleInput.value.trim()) {
        titleInput.classList.add('is-invalid');
        hasErrors = true;
    }

    // Validate category
    if (!categoryInput.value) {
        categoryInput.classList.add('is-invalid');
        hasErrors = true;
    }

    // Validate file
    if (!fileInput.files.length) {
        fileInput.classList.add('is-invalid');
        hasErrors = true;
    }

    if (hasErrors) {
        e.preventDefault();
        alert('لطفاً تمام فیلدهای الزامی را پر کنید');
        return false;
    }
});
</script>
@endpush
