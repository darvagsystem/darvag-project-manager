@extends('admin.layout')

@section('title', 'ایجاد دسته‌بندی تگ جدید')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ایجاد دسته‌بندی تگ جدید</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('panel.tag-categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">نام دسته‌بندی <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="color" class="form-label">رنگ <span class="text-danger">*</span></label>
                                    <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                                           id="color" name="color" value="{{ old('color', '#007bff') }}" required>
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">اولویت نمایش</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_required" name="is_required" 
                                       value="1" {{ old('is_required') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_required">
                                    این دسته‌بندی الزامی است
                                </label>
                            </div>
                        </div>

                        <div id="required_for_projects_group" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">پروژه‌های مورد نیاز</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="all_categories" name="all_categories" 
                                           value="1" {{ old('all_categories') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="all_categories">
                                        همه دسته‌بندی‌های پروژه
                                    </label>
                                </div>
                                <div id="project_categories" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="required_for_projects[]" 
                                                       value="construction" id="construction" {{ in_array('construction', old('required_for_projects', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="construction">ساخت و ساز</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="required_for_projects[]" 
                                                       value="industrial" id="industrial" {{ in_array('industrial', old('required_for_projects', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="industrial">صنعتی</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="required_for_projects[]" 
                                                       value="infrastructure" id="infrastructure" {{ in_array('infrastructure', old('required_for_projects', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="infrastructure">زیرساخت</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="required_for_projects[]" 
                                                       value="energy" id="energy" {{ in_array('energy', old('required_for_projects', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="energy">انرژی</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="required_for_projects[]" 
                                                       value="petrochemical" id="petrochemical" {{ in_array('petrochemical', old('required_for_projects', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="petrochemical">پتروشیمی</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="required_for_projects[]" 
                                                       value="other" id="other" {{ in_array('other', old('required_for_projects', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="other">سایر</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('panel.tag-categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right"></i> بازگشت
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> ذخیره
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isRequiredCheckbox = document.getElementById('is_required');
    const requiredForProjectsGroup = document.getElementById('required_for_projects_group');
    const allCategoriesCheckbox = document.getElementById('all_categories');
    const projectCategories = document.getElementById('project_categories');

    // Toggle required for projects group
    isRequiredCheckbox.addEventListener('change', function() {
        if (this.checked) {
            requiredForProjectsGroup.style.display = 'block';
        } else {
            requiredForProjectsGroup.style.display = 'none';
        }
    });

    // Toggle project categories
    allCategoriesCheckbox.addEventListener('change', function() {
        if (this.checked) {
            projectCategories.style.display = 'none';
            // Uncheck all project category checkboxes
            const projectCheckboxes = projectCategories.querySelectorAll('input[type="checkbox"]');
            projectCheckboxes.forEach(checkbox => checkbox.checked = false);
        } else {
            projectCategories.style.display = 'block';
        }
    });

    // Initialize display state
    if (isRequiredCheckbox.checked) {
        requiredForProjectsGroup.style.display = 'block';
    }
    if (allCategoriesCheckbox.checked) {
        projectCategories.style.display = 'none';
    }
});
</script>
@endsection
