@extends('admin.layout')

@section('title', 'افزودن بانک جدید')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">افزودن بانک جدید</h1>
            <p class="page-subtitle">تعریف بانک جدید در سیستم</p>
        </div>
        <a href="{{ route('panel.settings.banks') }}" class="btn btn-light">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            بازگشت
        </a>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <h3 class="card-title">اطلاعات بانک</h3>
        <p class="card-subtitle">لطفاً اطلاعات بانک را وارد کنید</p>
    </div>
    <form action="{{ route('panel.settings.banks.store') }}" method="POST" enctype="multipart/form-data" class="card-body">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label for="name" class="form-label">نام بانک *</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required placeholder="نام بانک">
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="logo" class="form-label">لوگو بانک</label>
                <input type="file" id="logo" name="logo" class="form-input" accept="image/*">
                <div class="form-help">فرمت‌های مجاز: JPG, PNG, GIF (حداکثر 2MB)</div>
                @error('logo')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full-width">
                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        بانک فعال
                    </label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                ذخیره بانک
            </button>
            <a href="{{ route('panel.settings.banks') }}" class="btn btn-light">انصراف</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
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

.form-input {
    padding: 12px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-help {
    font-size: 12px;
    color: #6b7280;
    margin-top: 4px;
}

.form-error {
    font-size: 12px;
    color: #ef4444;
    margin-top: 4px;
}

.checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 14px;
    color: #374151;
}

.checkbox-label input[type="checkbox"] {
    margin: 0;
}

.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    justify-content: center;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-light {
    background: #f8fafc;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-light:hover {
    background: #f1f5f9;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }
}
</style>
@endpush
@endsection
