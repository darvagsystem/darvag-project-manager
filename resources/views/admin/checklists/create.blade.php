@extends('admin.layout')

@section('title', 'ایجاد چک لیست جدید')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>
                        ایجاد چک لیست جدید
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('panel.checklists.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">عنوان چک لیست <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">توضیحات</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">دسته‌بندی</label>
                                            <select class="form-select @error('category_id') is-invalid @enderror"
                                                    id="category_id" name="category_id">
                                                <option value="">انتخاب دسته‌بندی</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                                                            data-color="{{ $category->color }}">
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="priority" class="form-label">اولویت</label>
                                            <select class="form-select @error('priority') is-invalid @enderror"
                                                    id="priority" name="priority">
                                                <option value="normal" {{ old('priority', 'normal') == 'normal' ? 'selected' : '' }}>عادی</option>
                                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>پایین</option>
                                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>بالا</option>
                                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>فوری</option>
                                            </select>
                                            @error('priority')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="due_date" class="form-label">تاریخ سررسید</label>
                                            <input type="text" class="form-control persian-date @error('due_date') is-invalid @enderror"
                                                   id="due_date" name="due_date" value="{{ old('due_date') }}"
                                                   placeholder="1403/01/15 14:30">
                                            <small class="form-text text-muted">فرمت: 1403/01/15 14:30</small>
                                            @error('due_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">وضعیت</label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status">
                                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>فعال</option>
                                                <option value="paused" {{ old('status') == 'paused' ? 'selected' : '' }}>متوقف شده</option>
                                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>آرشیو شده</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">تنظیمات ظاهری</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="color" class="form-label">رنگ</label>
                                            <div class="d-flex align-items-center">
                                                <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                                                       id="color" name="color" value="{{ old('color', '#3B82F6') }}"
                                                       style="width: 50px; height: 38px;">
                                                <input type="text" class="form-control ms-2" id="colorText"
                                                       value="{{ old('color', '#3B82F6') }}" readonly>
                                            </div>
                                            @error('color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_public"
                                                       name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_public">
                                                    عمومی (قابل مشاهده برای سایر کاربران)
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Color Presets -->
                                        <div class="mb-3">
                                            <label class="form-label">رنگ‌های پیش‌فرض</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-sm color-preset"
                                                        data-color="#3B82F6" style="background-color: #3B82F6; width: 30px; height: 30px; border: 2px solid #ddd;"></button>
                                                <button type="button" class="btn btn-sm color-preset"
                                                        data-color="#10B981" style="background-color: #10B981; width: 30px; height: 30px; border: 2px solid #ddd;"></button>
                                                <button type="button" class="btn btn-sm color-preset"
                                                        data-color="#F59E0B" style="background-color: #F59E0B; width: 30px; height: 30px; border: 2px solid #ddd;"></button>
                                                <button type="button" class="btn btn-sm color-preset"
                                                        data-color="#EF4444" style="background-color: #EF4444; width: 30px; height: 30px; border: 2px solid #ddd;"></button>
                                                <button type="button" class="btn btn-sm color-preset"
                                                        data-color="#8B5CF6" style="background-color: #8B5CF6; width: 30px; height: 30px; border: 2px solid #ddd;"></button>
                                                <button type="button" class="btn btn-sm color-preset"
                                                        data-color="#06B6D4" style="background-color: #06B6D4; width: 30px; height: 30px; border: 2px solid #ddd;"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('panel.checklists.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                انصراف
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                ایجاد چک لیست
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorInput = document.getElementById('color');
    const colorText = document.getElementById('colorText');
    const colorPresets = document.querySelectorAll('.color-preset');
    const categorySelect = document.getElementById('category_id');

    // Sync color input with text input
    colorInput.addEventListener('input', function() {
        colorText.value = this.value;
    });

    colorText.addEventListener('input', function() {
        if (this.value.match(/^#[0-9A-F]{6}$/i)) {
            colorInput.value = this.value;
        }
    });

    // Color presets
    colorPresets.forEach(preset => {
        preset.addEventListener('click', function() {
            const color = this.dataset.color;
            colorInput.value = color;
            colorText.value = color;
        });
    });

    // Auto-select color from category
    categorySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.dataset.color) {
            colorInput.value = selectedOption.dataset.color;
            colorText.value = selectedOption.dataset.color;
        }
    });
});
</script>
@endpush
