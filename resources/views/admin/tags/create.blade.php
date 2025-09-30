@extends('admin.layout')

@section('title', 'ایجاد تگ جدید')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">ایجاد تگ جدید</h1>
            <p class="page-subtitle">تگ جدید برای فایل‌ها ایجاد کنید</p>
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
                <form action="{{ route('panel.tags.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">نام تگ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">رنگ تگ <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                                       id="color" name="color" value="{{ old('color', '#007bff') }}" required>
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
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_folder_tag" name="is_folder_tag" value="1" {{ old('is_folder_tag') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_folder_tag">
                                تگ مخصوص پوشه‌ها
                            </label>
                        </div>
                        <small class="form-text text-muted">اگر فعال باشد، این تگ فقط برای پوشه‌ها قابل استفاده است</small>
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">اولویت</label>
                        <select id="priority" name="priority" class="form-select">
                            <option value="critical">بحرانی</option>
                            <option value="high">بالا</option>
                            <option value="medium" selected>متوسط</option>
                            <option value="low">پایین</option>
                            <option value="optional">اختیاری</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_required" name="is_required" value="1" {{ old('is_required') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_required">
                                این تگ برای پروژه‌ها الزامی است
                            </label>
                        </div>
                    </div>

                    <div class="mb-3" id="required_for_projects_group" style="display: none;">
                        <label class="form-label">دسته‌بندی‌های پروژه</label>
                        <div class="form-check-group">
                            <div class="form-check">
                                <input type="checkbox" id="all_categories" name="all_categories" value="1" class="form-check-input">
                                <label for="all_categories" class="form-check-label">همه دسته‌بندی‌ها</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="construction" name="required_for_projects[]" value="construction" class="form-check-input">
                                <label for="construction" class="form-check-label">ساخت و ساز</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="industrial" name="required_for_projects[]" value="industrial" class="form-check-input">
                                <label for="industrial" class="form-check-label">صنعتی</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="infrastructure" name="required_for_projects[]" value="infrastructure" class="form-check-input">
                                <label for="infrastructure" class="form-check-label">زیرساخت</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="energy" name="required_for_projects[]" value="energy" class="form-check-input">
                                <label for="energy" class="form-check-label">انرژی</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="petrochemical" name="required_for_projects[]" value="petrochemical" class="form-check-input">
                                <label for="petrochemical" class="form-check-label">پتروشیمی</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="allowed_extensions" class="form-label">پسوندهای مجاز</label>
                        <input type="text" class="form-control @error('allowed_extensions') is-invalid @enderror"
                               id="allowed_extensions" name="allowed_extensions"
                               value="{{ old('allowed_extensions') }}"
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
                               value="{{ old('allowed_mime_types') }}"
                               placeholder="مثال: application/pdf,image/jpeg (جدا شده با کاما)">
                        <small class="form-text text-muted">نوع‌های MIME فایل‌هایی که این تگ می‌تواند داشته باشد (خالی = همه)</small>
                        @error('allowed_mime_types')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-check"></i> ایجاد تگ
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
                        <span class="badge" style="font-size: 16px; padding: 8px 16px;">
                            نام تگ
                        </span>
                    </div>
                    <p class="text-muted small">این پیش‌نمایش تگ شما است</p>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">رنگ‌های پیشنهادی</h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-3">
                        <div class="color-option" data-color="#dc3545" style="width: 100%; height: 30px; background-color: #dc3545; border-radius: 4px; cursor: pointer; border: 2px solid transparent;" title="قرمز"></div>
                    </div>
                    <div class="col-3">
                        <div class="color-option" data-color="#28a745" style="width: 100%; height: 30px; background-color: #28a745; border-radius: 4px; cursor: pointer; border: 2px solid transparent;" title="سبز"></div>
                    </div>
                    <div class="col-3">
                        <div class="color-option" data-color="#007bff" style="width: 100%; height: 30px; background-color: #007bff; border-radius: 4px; cursor: pointer; border: 2px solid transparent;" title="آبی"></div>
                    </div>
                    <div class="col-3">
                        <div class="color-option" data-color="#ffc107" style="width: 100%; height: 30px; background-color: #ffc107; border-radius: 4px; cursor: pointer; border: 2px solid transparent;" title="زرد"></div>
                    </div>
                    <div class="col-3">
                        <div class="color-option" data-color="#6f42c1" style="width: 100%; height: 30px; background-color: #6f42c1; border-radius: 4px; cursor: pointer; border: 2px solid transparent;" title="بنفش"></div>
                    </div>
                    <div class="col-3">
                        <div class="color-option" data-color="#fd7e14" style="width: 100%; height: 30px; background-color: #fd7e14; border-radius: 4px; cursor: pointer; border: 2px solid transparent;" title="نارنجی"></div>
                    </div>
                    <div class="col-3">
                        <div class="color-option" data-color="#20c997" style="width: 100%; height: 30px; background-color: #20c997; border-radius: 4px; cursor: pointer; border: 2px solid transparent;" title="فیروزه‌ای"></div>
                    </div>
                    <div class="col-3">
                        <div class="color-option" data-color="#6c757d" style="width: 100%; height: 30px; background-color: #6c757d; border-radius: 4px; cursor: pointer; border: 2px solid transparent;" title="خاکستری"></div>
                    </div>
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
    const colorOptions = document.querySelectorAll('.color-option');

    function updatePreview() {
        const name = nameInput.value || 'نام تگ';
        const color = colorInput.value;

        tagPreview.innerHTML = `<span class="badge" style="background-color: ${color}20; color: ${color}; border: 1px solid ${color}40; font-size: 16px; padding: 8px 16px;">${name}</span>`;
        colorText.value = color;
    }

    nameInput.addEventListener('input', updatePreview);
    colorInput.addEventListener('input', updatePreview);

    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            const color = this.dataset.color;
            colorInput.value = color;
            updatePreview();

            // Highlight selected option
            colorOptions.forEach(opt => opt.style.border = '2px solid transparent');
            this.style.border = '2px solid #000';
        });
    });

    // Initial preview
    updatePreview();

    // مدیریت نمایش دسته‌بندی‌های پروژه
    const isRequiredCheckbox = document.getElementById('is_required');
    const requiredForProjectsGroup = document.getElementById('required_for_projects_group');
    const allCategoriesCheckbox = document.getElementById('all_categories');
    const categoryCheckboxes = document.querySelectorAll('input[name="required_for_projects[]"]');

    isRequiredCheckbox.addEventListener('change', function() {
        if (this.checked) {
            requiredForProjectsGroup.style.display = 'block';
        } else {
            requiredForProjectsGroup.style.display = 'none';
            // پاک کردن انتخاب‌ها
            allCategoriesCheckbox.checked = false;
            categoryCheckboxes.forEach(cb => cb.checked = false);
        }
    });

    // مدیریت "همه دسته‌بندی‌ها"
    allCategoriesCheckbox.addEventListener('change', function() {
        if (this.checked) {
            categoryCheckboxes.forEach(cb => cb.checked = false);
        }
    });

    // مدیریت دسته‌بندی‌های فردی
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                allCategoriesCheckbox.checked = false;
            }
        });
    });
});
</script>
@endpush
@endsection
