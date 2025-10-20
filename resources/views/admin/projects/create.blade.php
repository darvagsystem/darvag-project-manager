@extends('admin.layout')

@section('title', 'افزودن پروژه جدید')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">افزودن پروژه جدید</h1>
        <p class="page-subtitle">ایجاد پروژه و قرارداد جدید</p>
    </div>
</div>

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form class="project-form" method="POST" action="{{ route('panel.projects.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-sections">
        <!-- Basic Information Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات پایه پروژه</h3>
                <p class="section-subtitle">اطلاعات اساسی و شناسایی پروژه</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">نام پروژه *</label>
                    <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="نام کامل پروژه">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="client_id" class="form-label">کارفرما *</label>
                    <select id="client_id" name="client_id" class="form-select @error('client_id') is-invalid @enderror" required>
                        <option value="">انتخاب کارفرما</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contract_number" class="form-label">شماره قرارداد *</label>
                    <input type="text" id="contract_number" name="contract_number" class="form-input @error('contract_number') is-invalid @enderror" value="{{ old('contract_number') }}" required placeholder="C-2024-001">
                    @error('contract_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="department" class="form-label">واحد مربوطه *</label>
                    <input type="text" id="department" name="department" class="form-input @error('department') is-invalid @enderror" value="{{ old('department') }}" required placeholder="واحد فنی و مهندسی">
                    @error('department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="description" class="form-label">توضیحات پروژه</label>
                    <textarea id="description" name="description" class="form-textarea @error('description') is-invalid @enderror" rows="4" placeholder="توضیحات کامل درباره پروژه...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="featured_image" class="form-label">تصویر شاخص پروژه</label>
                    <div class="image-upload-container">
                        <input type="file" id="featured_image" name="featured_image" class="form-input @error('featured_image') is-invalid @enderror" accept="image/*" style="display: none;">
                        <input type="hidden" id="cropped_image" name="cropped_image">
                        <div class="image-preview-container" id="imagePreviewContainer" style="display: none;">
                            <img id="imagePreview" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                            <button type="button" id="removeImage" class="btn btn-sm btn-danger" style="margin-top: 10px;">
                                <i class="mdi mdi-delete"></i> حذف تصویر
                            </button>
                        </div>
                        <button type="button" id="selectImageBtn" class="btn btn-outline-primary">
                            <i class="mdi mdi-image"></i> انتخاب تصویر
                        </button>
                    </div>
                    <small class="form-help">تصویری که در وب‌سایت نمایش داده می‌شود (JPG, PNG, WebP) - می‌توانید تصویر را کراپ کنید</small>
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="featured_image_alt" class="form-label">متن جایگزین تصویر</label>
                    <input type="text" id="featured_image_alt" name="featured_image_alt" class="form-input @error('featured_image_alt') is-invalid @enderror" value="{{ old('featured_image_alt') }}" placeholder="توضیح کوتاه تصویر برای SEO">
                    @error('featured_image_alt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <!-- Financial Information Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات مالی</h3>
                <p class="section-subtitle">مبالغ و ضرایب مربوط به قرارداد</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="initial_estimate" class="form-label">برآورد اولیه (ریال)</label>
                    <input type="number" id="initial_estimate" name="initial_estimate" class="form-input @error('initial_estimate') is-invalid @enderror" value="{{ old('initial_estimate') }}" placeholder="45000000000">
                    <small class="form-help">مبلغ برآورد اولیه پروژه</small>
                    @error('initial_estimate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="final_amount" class="form-label">مبلغ نهایی (ریال)</label>
                    <input type="number" id="final_amount" name="final_amount" class="form-input @error('final_amount') is-invalid @enderror" value="{{ old('final_amount') }}" placeholder="48500000000">
                    <small class="form-help">مبلغ نهایی قرارداد</small>
                    @error('final_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contract_coefficient" class="form-label">ضریب پیمان *</label>
                    <input type="number" id="contract_coefficient" name="contract_coefficient" class="form-input @error('contract_coefficient') is-invalid @enderror" value="{{ old('contract_coefficient') }}" step="0.01" min="0" required placeholder="1.08">
                    <small class="form-help">ضریب تعدیل قرارداد</small>
                    @error('contract_coefficient')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="currency" class="form-label">واحد پول</label>
                    <select id="currency" name="currency" class="form-select @error('currency') is-invalid @enderror">
                        <option value="IRR" {{ old('currency', 'IRR') == 'IRR' ? 'selected' : '' }}>ریال</option>
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>دلار آمریکا</option>
                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>یورو</option>
                    </select>
                    @error('currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Timeline Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">زمان‌بندی پروژه</h3>
                <p class="section-subtitle">تاریخ‌های مهم و زمان‌بندی</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="contract_start_date" class="form-label">تاریخ شروع قرارداد *</label>
                    <input type="text" id="contract_start_date" name="contract_start_date" class="form-input persian-date @error('contract_start_date') is-invalid @enderror" value="{{ old('contract_start_date') }}" required placeholder="1403/01/15">
                    <small class="form-help">تاریخ شروع طبق قرارداد</small>
                    @error('contract_start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contract_end_date" class="form-label">تاریخ پایان قرارداد *</label>
                    <input type="text" id="contract_end_date" name="contract_end_date" class="form-input persian-date @error('contract_end_date') is-invalid @enderror" value="{{ old('contract_end_date') }}" required placeholder="1403/12/30">
                    <small class="form-help">تاریخ پایان طبق قرارداد</small>
                    @error('contract_end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="actual_start_date" class="form-label">تاریخ شروع واقعی</label>
                    <input type="text" id="actual_start_date" name="actual_start_date" class="form-input persian-date @error('actual_start_date') is-invalid @enderror" value="{{ old('actual_start_date') }}" placeholder="1403/01/20">
                    <small class="form-help">تاریخ شروع واقعی کار</small>
                    @error('actual_start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="actual_end_date" class="form-label">تاریخ پایان واقعی</label>
                    <input type="text" id="actual_end_date" name="actual_end_date" class="form-input persian-date @error('actual_end_date') is-invalid @enderror" value="{{ old('actual_end_date') }}" placeholder="1403/12/25">
                    <small class="form-help">تاریخ پایان واقعی (در صورت تکمیل)</small>
                    @error('actual_end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Project Status Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">وضعیت و اولویت</h3>
                <p class="section-subtitle">وضعیت فعلی و اولویت پروژه</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="status" class="form-label">وضعیت پروژه *</label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">انتخاب وضعیت</option>
                        <option value="planning" {{ old('status') == 'planning' ? 'selected' : '' }}>در حال برنامه‌ریزی</option>
                        <option value="in_progress" {{ old('status', 'in_progress') == 'in_progress' ? 'selected' : '' }}>در حال اجرا</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                        <option value="paused" {{ old('status') == 'paused' ? 'selected' : '' }}>متوقف شده</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="priority" class="form-label">اولویت پروژه</label>
                    <select id="priority" name="priority" class="form-select @error('priority') is-invalid @enderror">
                        <option value="normal" {{ old('priority', 'normal') == 'normal' ? 'selected' : '' }}>عادی</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>بالا</option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>فوری</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>پایین</option>
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="progress" class="form-label">درصد پیشرفت</label>
                    <input type="number" id="progress" name="progress" class="form-input @error('progress') is-invalid @enderror" value="{{ old('progress', 0) }}" min="0" max="100">
                    <div class="progress-visual">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ old('progress', 0) }}%"></div>
                        </div>
                        <span class="progress-text">{{ old('progress', 0) }}%</span>
                    </div>
                    @error('progress')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="project_manager" class="form-label">مدیر پروژه</label>
                    <input type="text" id="project_manager" name="project_manager" class="form-input @error('project_manager') is-invalid @enderror" value="{{ old('project_manager') }}" placeholder="نام مدیر پروژه">
                    @error('project_manager')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات تکمیلی</h3>
                <p class="section-subtitle">سایر اطلاعات مربوط به پروژه</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="location" class="form-label">محل اجرا</label>
                    <input type="text" id="location" name="location" class="form-input @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="مشهد، منطقه صنعتی">
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">دسته‌بندی</label>
                    <select id="category" name="category" class="form-select @error('category') is-invalid @enderror">
                        <option value="">انتخاب دسته‌بندی</option>
                        <option value="construction" {{ old('category') == 'construction' ? 'selected' : '' }}>ساخت و ساز</option>
                        <option value="industrial" {{ old('category') == 'industrial' ? 'selected' : '' }}>صنعتی</option>
                        <option value="infrastructure" {{ old('category') == 'infrastructure' ? 'selected' : '' }}>زیرساخت</option>
                        <option value="energy" {{ old('category') == 'energy' ? 'selected' : '' }}>انرژی</option>
                        <option value="petrochemical" {{ old('category') == 'petrochemical' ? 'selected' : '' }}>پتروشیمی</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>سایر</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="notes" class="form-label">یادداشت‌ها</label>
                    <textarea id="notes" name="notes" class="form-textarea @error('notes') is-invalid @enderror" rows="4" placeholder="یادداشت‌ها و توضیحات اضافی...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <button type="button" id="fillTestData" class="btn btn-warning">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
            پر کردن با داده تست
        </button>
        <button type="submit" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            ایجاد پروژه
        </button>
        <a href="{{ route('panel.projects.index') }}" class="btn btn-secondary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            انصراف
        </a>
    </div>
</form>

<!-- Image Cropper Modal -->
<div class="modal fade" id="imageCropperModal" tabindex="-1" aria-labelledby="imageCropperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageCropperModalLabel">کراپ تصویر</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="cropper-container">
                    <img id="cropperImage" src="" alt="Image to crop" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                <button type="button" class="btn btn-primary" id="cropImageBtn">کراپ و ذخیره</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<style>
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-size: 14px;
}

.alert-danger {
    background-color: #fef2f2;
    border: 1px solid #fecaca;
    color: #dc2626;
}

.alert ul {
    margin: 0;
    padding-right: 20px;
}

.alert li {
    margin-bottom: 5px;
}

.is-invalid {
    border-color: #dc2626 !important;
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 5px;
    font-size: 12px;
    color: #dc2626;
}

.project-form {
    max-width: 1200px;
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
    min-height: 100px;
}

.form-help {
    margin-top: 5px;
    font-size: 12px;
    color: var(--text-light);
}

.progress-visual {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.progress-bar {
    flex: 1;
    height: 8px;
    background: var(--border-light);
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--success-color));
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-dark);
    min-width: 30px;
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

.btn-warning {
    background: #f59e0b;
    color: white;
}

.btn-warning:hover {
    background: #d97706;
    transform: translateY(-2px);
}

/* Image Upload Styles */
.image-upload-container {
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: border-color 0.3s ease;
}

.image-upload-container:hover {
    border-color: #3b82f6;
}

.image-preview-container {
    margin-bottom: 15px;
}

.cropper-container {
    max-height: 400px;
    overflow: hidden;
}

.btn-outline-primary {
    border: 1px solid #3b82f6;
    color: #3b82f6;
    background: transparent;
}

.btn-outline-primary:hover {
    background: #3b82f6;
    color: white;
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

@push('scripts')
<!-- Cropper.js JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image Cropper Variables
    let cropper = null;
    const imageInput = document.getElementById('featured_image');
    const selectImageBtn = document.getElementById('selectImageBtn');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const removeImageBtn = document.getElementById('removeImage');
    const cropperImage = document.getElementById('cropperImage');
    const croppedImageInput = document.getElementById('cropped_image');
    const imageCropperModal = new bootstrap.Modal(document.getElementById('imageCropperModal'));

    // Image Upload and Cropping
    selectImageBtn.addEventListener('click', function() {
        imageInput.click();
    });

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                cropperImage.src = e.target.result;
                imageCropperModal.show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Initialize Cropper when modal is shown
    document.getElementById('imageCropperModal').addEventListener('shown.bs.modal', function() {
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(cropperImage, {
            aspectRatio: 16 / 9, // نسبت تصویر
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 0.8,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
        });
    });

    // Crop and save image
    document.getElementById('cropImageBtn').addEventListener('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 800,
                height: 450,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            canvas.toBlob(function(blob) {
                // Convert blob to base64
                const reader = new FileReader();
                reader.onload = function() {
                    croppedImageInput.value = reader.result;

                    // Show preview
                    imagePreview.src = reader.result;
                    imagePreviewContainer.style.display = 'block';
                    selectImageBtn.style.display = 'none';

                    // Close modal
                    imageCropperModal.hide();
                };
                reader.readAsDataURL(blob);
            }, 'image/jpeg', 0.9);
        }
    });

    // Remove image
    removeImageBtn.addEventListener('click', function() {
        imagePreviewContainer.style.display = 'none';
        selectImageBtn.style.display = 'inline-block';
        imageInput.value = '';
        croppedImageInput.value = '';
    });

    // Progress bar update
    const progressInput = document.getElementById('progress');
    const progressFill = document.querySelector('.progress-fill');
    const progressText = document.querySelector('.progress-text');

    progressInput.addEventListener('input', function() {
        const value = this.value;
        progressFill.style.width = value + '%';
        progressText.textContent = value + '%';
    });

    // Auto-calculate coefficient
    const initialEstimate = document.getElementById('initial_estimate');
    const finalAmount = document.getElementById('final_amount');
    const coefficient = document.getElementById('contract_coefficient');

    function calculateCoefficient() {
        const initial = parseFloat(initialEstimate.value) || 0;
        const final = parseFloat(finalAmount.value) || 0;

        if (initial > 0 && final > 0) {
            const calc = (final / initial).toFixed(2);
            coefficient.value = calc;
        }
    }

    initialEstimate.addEventListener('input', calculateCoefficient);
    finalAmount.addEventListener('input', calculateCoefficient);

    // Number formatting
    const numberInputs = document.querySelectorAll('input[type="number"]');
    numberInputs.forEach(input => {
        if (input.id === 'initial_estimate' || input.id === 'final_amount') {
            input.addEventListener('input', function() {
                // Add thousand separators for display
                const value = this.value.replace(/\D/g, '');
                if (value) {
                    this.setAttribute('data-formatted', parseInt(value).toLocaleString('fa-IR'));
                }
            });
        }
    });

    // Form validation - فقط validation نمایشی، اجازه submit به backend
    const form = document.querySelector('.project-form');
    form.addEventListener('submit', function(e) {
        // Clear previous error styles
        const allFields = form.querySelectorAll('input, select, textarea');
        allFields.forEach(field => {
            field.style.borderColor = '#d1d5db';
        });

        // Basic validation
        const requiredFields = form.querySelectorAll('[required]');
        let hasError = false;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = '#ef4444';
                hasError = true;
            }
        });

        // Date validation
        const startDate = document.getElementById('contract_start_date').value;
        const endDate = document.getElementById('contract_end_date').value;

        if (startDate && endDate) {
            if (startDate >= endDate) {
                document.getElementById('contract_end_date').style.borderColor = '#ef4444';
                hasError = true;
            }
        }

        // Amount validation
        const initial = parseFloat(initialEstimate.value) || 0;
        const final = parseFloat(finalAmount.value) || 0;

        if (initial > 0 && final > 0 && final < initial) {
            if (!confirm('مبلغ نهایی کمتر از برآورد اولیه است. آیا مطمئن هستید؟')) {
                hasError = true;
            }
        }

        // اگر خطا داشت، جلوگیری از submit
        if (hasError) {
            e.preventDefault();
            alert('لطفاً خطاهای فرم را اصلاح کنید.');
            return false;
        }

        // اگر خطا نداشت، اجازه submit دادن به backend
        // هیچ preventDefault نمی‌زنیم
    });

    // Fill test data button
    const fillTestDataBtn = document.getElementById('fillTestData');
    if (fillTestDataBtn) {
        fillTestDataBtn.addEventListener('click', function() {
            document.getElementById('name').value = 'پروژه تست';
            document.getElementById('client_id').value = '1'; // Assuming client with ID 1 exists
            document.getElementById('contract_number').value = 'TST-2024-001';
            document.getElementById('department').value = 'واحد فنی و مهندسی';
            document.getElementById('description').value = 'این پروژه یک پروژه تست برای آزمایش فرم است.';
            document.getElementById('initial_estimate').value = '50000000000';
            document.getElementById('final_amount').value = '55000000000';
            document.getElementById('contract_coefficient').value = '1.10';
            document.getElementById('currency').value = 'IRR';
            document.getElementById('contract_start_date').value = '1403/01/10';
            document.getElementById('contract_end_date').value = '1403/12/31';
            document.getElementById('actual_start_date').value = '1403/01/15';
            document.getElementById('actual_end_date').value = '1403/12/28';
            document.getElementById('status').value = 'in_progress';
            document.getElementById('priority').value = 'normal';
            document.getElementById('progress').value = '75';
            document.getElementById('project_manager').value = 'مدیر پروژه تست';
            document.getElementById('location').value = 'تهران، منطقه صنعتی';
            document.getElementById('category').value = 'construction';
            document.getElementById('notes').value = 'این پروژه فقط برای آزمایش است و مقادیر واقعی نیست.';

            // Re-calculate coefficient after filling
            calculateCoefficient();

            // Update formatted numbers
            const numberInputs = document.querySelectorAll('input[type="number"]');
            numberInputs.forEach(input => {
                if (input.id === 'initial_estimate' || input.id === 'final_amount') {
                    const formattedValue = input.getAttribute('data-formatted');
                    if (formattedValue) {
                        input.value = formattedValue;
                    }
                }
            });

            alert('فرم با داده‌های تست پر شد.');
        });
    }
});
</script>
@endpush
