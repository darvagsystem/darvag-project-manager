@extends('admin.layout')

@section('title', 'ویرایش تگ - ' . $tag->name)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">ویرایش تگ</h1>
            <p class="page-subtitle">{{ $tag->name }}</p>
        </div>
        <div>
            <a href="{{ route('panel.tags.index') }}" class="btn btn-secondary">
                <i class="mdi mdi-arrow-right"></i> بازگشت
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('panel.tags.update', $tag) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">نام تگ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $tag->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">رنگ تگ <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                                       id="color" name="color" value="{{ old('color', $tag->color) }}" required>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="colorText" placeholder="#007bff" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">توضیحات</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3">{{ old('description', $tag->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_folder_tag" name="is_folder_tag" value="1"
                                   {{ old('is_folder_tag', $tag->is_folder_tag) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_folder_tag">
                                تگ مخصوص پوشه‌ها
                            </label>
                        </div>
                        <small class="form-text text-muted">اگر فعال باشد، این تگ فقط برای پوشه‌ها قابل استفاده است</small>
                    </div>

                    <div class="mb-3">
                        <label for="allowed_extensions" class="form-label">پسوندهای مجاز</label>
                        <input type="text" class="form-control @error('allowed_extensions') is-invalid @enderror"
                               id="allowed_extensions" name="allowed_extensions"
                               value="{{ old('allowed_extensions', $tag->getAllowedExtensionsText()) }}"
                               placeholder="مثال: pdf,doc,docx (جدا شده با کاما)">
                        <small class="form-text text-muted">پسوندهای فایل‌هایی که این تگ می‌تواند داشته باشد (خالی = همه)</small>
                        @error('allowed_extensions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="allowed_mime_types" class="form-label">نوع‌های MIME مجاز</label>
                        <input type="text" class="form-control @error('allowed_mime_types') is-invalid @enderror"
                               id="allowed_mime_types" name="allowed_mime_types"
                               value="{{ old('allowed_mime_types', $tag->getAllowedMimeTypesText()) }}"
                               placeholder="مثال: application/pdf,image/jpeg (جدا شده با کاما)">
                        <small class="form-text text-muted">نوع‌های MIME فایل‌هایی که این تگ می‌تواند داشته باشد (خالی = همه)</small>
                        @error('allowed_mime_types')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-check"></i> به‌روزرسانی تگ
                        </button>
                        <a href="{{ route('panel.tags.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-close"></i> انصراف
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">پیش‌نمایش تگ</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div id="tagPreview" class="mb-3">
                        <span class="badge" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}; border: 1px solid {{ $tag->color }}40; font-size: 16px; padding: 8px 16px;">
                            {{ $tag->name }}
                        </span>
                    </div>
                    <p class="text-muted small">این پیش‌نمایش تگ شما است</p>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">اطلاعات تگ</h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>تعداد فایل‌ها:</strong>
                    <span class="badge bg-info">{{ $tag->files->count() }}</span>
                </div>
                <div class="mb-2">
                    <strong>تاریخ ایجاد:</strong>
                    <span>{{ $tag->created_at->format('Y/m/d H:i') }}</span>
                </div>
                <div class="mb-2">
                    <strong>آخرین به‌روزرسانی:</strong>
                    <span>{{ $tag->updated_at->format('Y/m/d H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const colorInput = document.getElementById('color');
    const colorText = document.getElementById('colorText');
    const tagPreview = document.getElementById('tagPreview');

    function updatePreview() {
        const name = nameInput.value || 'نام تگ';
        const color = colorInput.value;

        tagPreview.innerHTML = `<span class="badge" style="background-color: ${color}20; color: ${color}; border: 1px solid ${color}40; font-size: 16px; padding: 8px 16px;">${name}</span>`;
        colorText.value = color;
    }

    nameInput.addEventListener('input', updatePreview);
    colorInput.addEventListener('input', updatePreview);

    // Initial preview
    updatePreview();
});
</script>
@endpush
@endsection
