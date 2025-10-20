@extends('admin.layout')

@section('title', 'افزودن نوع پرداخت جدید')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-plus-circle text-primary mr-2"></i>
                        افزودن نوع پرداخت جدید
                    </h1>
                    <p class="text-muted mb-0">تعریف نوع جدیدی از پرداخت‌ها</p>
                </div>
                <div>
                    <a href="{{ route('panel.projects.settings.payment-types.index', $project) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right mr-1"></i>
                        بازگشت به لیست
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-credit-card text-primary mr-2"></i>
                        اطلاعات نوع پرداخت
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('panel.projects.settings.payment-types.store', $project) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">نام نوع پرداخت <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="code" class="form-label">کد یکتا <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="code"
                                           id="code"
                                           class="form-control @error('code') is-invalid @enderror"
                                           value="{{ old('code') }}"
                                           required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">توضیحات</label>
                            <textarea name="description"
                                      id="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="icon" class="form-label">آیکون</label>
                                    <input type="text"
                                           name="icon"
                                           id="icon"
                                           class="form-control @error('icon') is-invalid @enderror"
                                           value="{{ old('icon') }}"
                                           placeholder="مثال: fas fa-credit-card">
                                    <small class="form-text text-muted">نام کلاس آیکون Font Awesome</small>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="color" class="form-label">رنگ <span class="text-danger">*</span></label>
                                    <input type="color"
                                           name="color"
                                           id="color"
                                           class="form-control @error('color') is-invalid @enderror"
                                           value="{{ old('color', '#007bff') }}"
                                           required>
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               name="requires_receipt"
                                               id="requires_receipt"
                                               class="form-check-input"
                                               value="1"
                                               {{ old('requires_receipt') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="requires_receipt">
                                            نیاز به فیش واریزی
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               name="is_active"
                                               id="is_active"
                                               class="form-check-input"
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            فعال
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="sort_order" class="form-label">ترتیب نمایش</label>
                            <input type="number"
                                   name="sort_order"
                                   id="sort_order"
                                   class="form-control @error('sort_order') is-invalid @enderror"
                                   value="{{ old('sort_order', 0) }}"
                                   min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                ذخیره نوع پرداخت
                            </button>
                            <a href="{{ route('panel.payment-types.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-times mr-1"></i>
                                انصراف
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-eye text-primary mr-2"></i>
                        پیش‌نمایش
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div id="preview-icon" class="mb-3">
                            <i class="fas fa-credit-card fa-3x" style="color: #007bff;"></i>
                        </div>
                        <h5 id="preview-name" class="text-dark">نام نوع پرداخت</h5>
                        <p id="preview-description" class="text-muted small">توضیحات نوع پرداخت</p>
                        <div class="d-flex justify-content-center">
                            <span id="preview-badge" class="badge px-3 py-2" style="background-color: #007bff; color: white;">
                                <i class="fas fa-credit-card mr-1"></i>
                                نام نوع پرداخت
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const iconInput = document.getElementById('icon');
    const colorInput = document.getElementById('color');
    const descriptionInput = document.getElementById('description');

    const previewIcon = document.getElementById('preview-icon');
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    const previewBadge = document.getElementById('preview-badge');

    function updatePreview() {
        const name = nameInput.value || 'نام نوع پرداخت';
        const icon = iconInput.value || 'fas fa-credit-card';
        const color = colorInput.value || '#007bff';
        const description = descriptionInput.value || 'توضیحات نوع پرداخت';

        // Update preview
        previewName.textContent = name;
        previewDescription.textContent = description;

        // Update icon
        const iconElement = previewIcon.querySelector('i');
        iconElement.className = icon + ' fa-3x';
        iconElement.style.color = color;

        // Update badge
        previewBadge.innerHTML = `<i class="${icon} mr-1"></i>${name}`;
        previewBadge.style.backgroundColor = color;
    }

    // Add event listeners
    nameInput.addEventListener('input', updatePreview);
    iconInput.addEventListener('input', updatePreview);
    colorInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);

    // Initialize preview
    updatePreview();
});
</script>
@endsection
