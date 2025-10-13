@extends('admin.layout')

@section('title', 'ویرایش دسته‌بندی: ' . $category->name)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">ویرایش دسته‌بندی</h1>
        <p class="page-subtitle">{{ $category->name }} (کد: {{ $category->code }})</p>
    </div>
    <div>
        <a href="{{ route('panel.document-categories.show', $category) }}" class="btn btn-light me-2">
            <i class="mdi mdi-eye me-1"></i>
            مشاهده
        </a>
        <a href="{{ route('panel.document-categories.index') }}" class="btn btn-outline-light me-2">
            <i class="mdi mdi-arrow-right me-1"></i>
            بازگشت
        </a>
        <a href="{{ route('panel.documents.index') }}" class="btn btn-outline-light">
            <i class="mdi mdi-view-dashboard me-1"></i>
            داشبورد مدارک
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

<form method="POST" action="{{ route('panel.document-categories.update', $category) }}" class="category-form">
    @csrf
    @method('PUT')

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
                                <label for="name" class="form-label">نام دسته‌بندی *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description" class="form-label">توضیحات</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Appearance Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">تنظیمات ظاهری</h5>
                </div>
                <div class="card-body">
                    @include('admin.partials.icon-picker', [
                        'inputId' => 'icon',
                        'inputName' => 'icon',
                        'label' => 'آیکون',
                        'value' => old('icon', $category->icon)
                    ])

                    <div class="form-group mb-3">
                        <label for="color" class="form-label">رنگ</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                                   id="color" name="color" value="{{ old('color', $category->color) }}">
                            <input type="text" class="form-control" id="color_text" value="{{ old('color', $category->color) }}"
                                   onchange="document.getElementById('color').value = this.value">
                        </div>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="sort_order" class="form-label">ترتیب نمایش</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                               id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">عدد کمتر = نمایش بالاتر</small>
                    </div>
                </div>
            </div>

            <!-- Status Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">تنظیمات وضعیت</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                دسته‌بندی فعال است
                            </label>
                        </div>
                        <small class="form-text text-muted">دسته‌بندی‌های غیرفعال در لیست نمایش داده نمی‌شوند</small>
                    </div>
                </div>
            </div>

            <!-- Current Category Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">اطلاعات فعلی</h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label class="info-label">کد دسته‌بندی:</label>
                        <span class="badge bg-primary">{{ $category->code }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">تاریخ ایجاد:</label>
                        <span class="text-muted">{{ $category->created_at->format('Y/m/d H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">آخرین بروزرسانی:</label>
                        <span class="text-muted">{{ $category->updated_at->format('Y/m/d H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">تعداد مدارک:</label>
                        <span class="text-muted">{{ $category->documents->count() }} سند</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">تعداد زیردسته:</label>
                        <span class="text-muted">{{ $category->children->count() }} زیردسته</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">عملیات</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save me-1"></i>
                            ذخیره تغییرات
                        </button>
                        <a href="{{ route('panel.document-categories.show', $category) }}" class="btn btn-outline-primary">
                            <i class="mdi mdi-eye me-1"></i>
                            مشاهده دسته‌بندی
                        </a>
                        <a href="{{ route('panel.document-categories.index') }}" class="btn btn-outline-secondary">
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
.category-form .card {
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.category-form .card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
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

.form-control-color {
    width: 3rem;
    height: 2.5rem;
    padding: 0.375rem;
}

.info-item {
    margin-bottom: 0.75rem;
}

.info-label {
    font-weight: 600;
    color: #374151;
    display: block;
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

</style>
@endpush

@push('scripts')
<script>
// Color picker synchronization
document.getElementById('color').addEventListener('input', function() {
    document.getElementById('color_text').value = this.value;
});

document.getElementById('color_text').addEventListener('input', function() {
    if (this.value.match(/^#[0-9A-F]{6}$/i)) {
        document.getElementById('color').value = this.value;
    }
});

</script>
@endpush
