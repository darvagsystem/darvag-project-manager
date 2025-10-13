@extends('admin.layout')

@section('title', 'ویرایش سند: ' . $document->title)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">ویرایش سند</h1>
        <p class="page-subtitle">{{ $document->title }}</p>
    </div>
    <div>
        <a href="{{ route('panel.documents.index') }}" class="btn btn-light me-2">
            <i class="mdi mdi-arrow-right me-1"></i>
            بازگشت به داشبورد
        </a>
        <a href="{{ route('panel.documents.show', $document) }}" class="btn btn-outline-light me-2">
            <i class="mdi mdi-eye me-1"></i>
            مشاهده سند
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

<form method="POST" action="{{ route('panel.documents.update', $document) }}" class="document-form">
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
                                <label for="title" class="form-label">عنوان سند *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title', $document->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="form_code" class="form-label">کد فرم *</label>
                                <input type="text" class="form-control @error('form_code') is-invalid @enderror"
                                       id="form_code" name="form_code" value="{{ old('form_code', $document->form_code) }}" required>
                                @error('form_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description" class="form-label">توضیحات</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4">{{ old('description', $document->description) }}</textarea>
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
                                        <option value="{{ $category->id }}" {{ old('category_id', $document->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @foreach($category->children as $child)
                                            <option value="{{ $child->id }}" {{ old('category_id', $document->category_id) == $child->id ? 'selected' : '' }}>
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
                                       id="tags" name="tags" value="{{ old('tags', is_array($document->tags) ? implode(', ', $document->tags) : '') }}"
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

            <!-- Current File Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">اطلاعات فایل فعلی</h5>
                </div>
                <div class="card-body">
                    <div class="current-file-info">
                        <div class="d-flex align-items-center">
                            <div class="file-icon">
                                <i class="mdi {{ $document->file_icon }}" style="font-size: 2rem; color: {{ $document->category->color }};"></i>
                            </div>
                            <div class="file-details flex-grow-1">
                                <h6 class="file-name">{{ $document->title }}</h6>
                                <div class="file-meta">
                                    <span class="badge bg-light text-dark me-2">{{ strtoupper($document->file_type) }}</span>
                                    <span class="text-muted">{{ $document->file_size_human }}</span>
                                </div>
                            </div>
                            <div class="file-actions">
                                <a href="{{ route('panel.documents.download', $document) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="mdi mdi-download me-1"></i>
                                    دانلود
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Status Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">تنظیمات</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $document->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                سند فعال است
                            </label>
                        </div>
                        <small class="form-text text-muted">سندهای غیرفعال در لیست نمایش داده نمی‌شوند</small>
                    </div>
                </div>
            </div>

            <!-- Document Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">آمار</h5>
                </div>
                <div class="card-body">
                    <div class="stats-item">
                        <div class="stats-icon">
                            <i class="mdi mdi-download"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ number_format($document->download_count) }}</div>
                            <div class="stats-label">دانلود</div>
                        </div>
                    </div>
                    <div class="stats-item">
                        <div class="stats-icon">
                            <i class="mdi mdi-eye"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ number_format($document->view_count) }}</div>
                            <div class="stats-label">مشاهده</div>
                        </div>
                    </div>
                    <div class="stats-item">
                        <div class="stats-icon">
                            <i class="mdi mdi-file-document-multiple"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ $document->versions->count() }}</div>
                            <div class="stats-label">نسخه</div>
                        </div>
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
                            <i class="mdi mdi-content-save me-1"></i>
                            ذخیره تغییرات
                        </button>
                        <a href="{{ route('panel.documents.show', $document) }}" class="btn btn-outline-primary">
                            <i class="mdi mdi-eye me-1"></i>
                            مشاهده سند
                        </a>
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

.current-file-info {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.file-icon {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 1rem;
    background: white;
}

.file-name {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #1f2937;
}

.file-meta {
    font-size: 0.875rem;
}

.stats-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.stats-item:last-child {
    border-bottom: none;
}

.stats-icon {
    width: 40px;
    height: 40px;
    background: #f3f4f6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 1rem;
    color: #6b7280;
}

.stats-content {
    flex: 1;
}

.stats-number {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
}

.stats-label {
    font-size: 0.875rem;
    color: #6b7280;
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
