@extends('admin.layout')

@section('title', 'آپلود فایل‌ها')

@push('styles')
<style>
.upload-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.upload-area {
    border: 3px dashed #007bff;
    border-radius: 15px;
    padding: 60px 20px;
    text-align: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.upload-area:hover {
    border-color: #0056b3;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,123,255,0.15);
}

.upload-area.dragover {
    border-color: #28a745;
    background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
    transform: scale(1.02);
}

.upload-icon {
    font-size: 4rem;
    color: #007bff;
    margin-bottom: 20px;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

.upload-text {
    font-size: 1.2rem;
    color: #495057;
    margin-bottom: 10px;
    font-weight: 600;
}

.upload-subtext {
    color: #6c757d;
    font-size: 0.9rem;
}

.file-preview {
    margin-top: 30px;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: none;
}

.file-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 10px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.file-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.file-icon {
    font-size: 2rem;
    margin-right: 15px;
    color: #007bff;
}

.file-info {
    flex: 1;
}

.file-name {
    font-weight: 600;
    color: #212529;
    margin-bottom: 5px;
}

.file-size {
    color: #6c757d;
    font-size: 0.9rem;
}

.file-status {
    margin-left: 15px;
}

.progress-container {
    margin-top: 20px;
    display: none;
}

.progress {
    height: 25px;
    border-radius: 12px;
    background: #e9ecef;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(90deg, #007bff, #0056b3);
    transition: width 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
}

.upload-stats {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: #007bff;
}

.stat-label {
    color: #6c757d;
    font-size: 0.9rem;
}

.tag-selection {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
}

.tag-item {
    display: flex;
    align-items: center;
    padding: 5px 10px;
    border: 1px solid #dee2e6;
    border-radius: 20px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.tag-item:hover {
    background: #f8f9fa;
    transform: translateY(-1px);
}

.tag-item.selected {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.tag-checkbox {
    margin-right: 5px;
}

.btn-upload {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    padding: 15px 30px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 8px;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,123,255,0.3);
}

.btn-upload:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,123,255,0.4);
    background: linear-gradient(135deg, #0056b3, #004085);
}

.btn-upload:disabled {
    background: #6c757d;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.success-message {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 8px;
    margin-top: 20px;
    border: 1px solid #c3e6cb;
    display: none;
}

.error-message {
    background: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 8px;
    margin-top: 20px;
    border: 1px solid #f5c6cb;
    display: none;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="mdi mdi-upload me-2"></i>
                        آپلود فایل‌ها
                    </h4>
                </div>
                <div class="card-body">
                    <div class="upload-container">
                        <!-- Upload Area -->
                        <div class="upload-area" id="uploadArea">
                            <div class="upload-icon">
                                <i class="mdi mdi-cloud-upload"></i>
                            </div>
                            <div class="upload-text">فایل‌ها را اینجا بکشید یا کلیک کنید</div>
                            <div class="upload-subtext">چندین فایل را همزمان انتخاب کنید (حداکثر 200MB برای هر فایل)</div>
                            <input type="file" id="fileInput" name="files[]" multiple style="display: none;">
                        </div>

                        <!-- File Preview -->
                        <div class="file-preview" id="filePreview">
                            <h5 class="mb-3">
                                <i class="mdi mdi-file-multiple me-2"></i>
                                فایل‌های انتخاب شده:
                                <span class="badge bg-primary ms-2" id="fileCount">0</span>
                            </h5>
                            <div id="fileList"></div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">توضیحات (اختیاری)</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="توضیحات مربوط به فایل‌ها..."></textarea>
                        </div>

                        <!-- Tags -->
                        <div class="mb-3">
                            <label class="form-label">تگ‌ها (اختیاری)</label>
                            <div class="tag-selection" id="tagSelection">
                                @foreach($tags as $tag)
                                    <div class="tag-item" data-tag-id="{{ $tag->id }}">
                                        <input type="checkbox" class="tag-checkbox" id="tag_{{ $tag->id }}" value="{{ $tag->id }}">
                                        <label for="tag_{{ $tag->id }}" style="color: {{ $tag->color }}; margin: 0; cursor: pointer;">
                                            {{ $tag->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Progress -->
                        <div class="progress-container" id="progressContainer">
                            <div class="progress">
                                <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%">0%</div>
                            </div>
                            <div class="upload-stats">
                                <div class="stat-item">
                                    <div class="stat-number" id="totalFiles">0</div>
                                    <div class="stat-label">کل فایل‌ها</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number" id="uploadedFiles">0</div>
                                    <div class="stat-label">آپلود شده</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number" id="currentFile">0</div>
                                    <div class="stat-label">فایل فعلی</div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Button -->
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-upload" id="uploadBtn" disabled>
                                <i class="mdi mdi-upload me-2"></i>
                                آپلود فایل‌ها
                            </button>
                        </div>

                        <!-- Messages -->
                        <div class="success-message" id="successMessage"></div>
                        <div class="error-message" id="errorMessage"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
class FileUploader {
    constructor() {
        this.selectedFiles = [];
        this.uploadedFiles = 0;
        this.totalFiles = 0;
        this.currentFileIndex = 0;
        this.init();
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const uploadBtn = document.getElementById('uploadBtn');

        // Click to select files
        uploadArea.addEventListener('click', () => {
            fileInput.click();
        });

        // File input change
        fileInput.addEventListener('change', (e) => {
            this.handleFileSelection(e.target.files);
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            this.handleFileSelection(e.dataTransfer.files);
        });

        // Upload button
        uploadBtn.addEventListener('click', () => {
            this.uploadFiles();
        });

        // Tag selection
        document.querySelectorAll('.tag-item').forEach(item => {
            item.addEventListener('click', () => {
                const checkbox = item.querySelector('.tag-checkbox');
                checkbox.checked = !checkbox.checked;
                item.classList.toggle('selected', checkbox.checked);
            });
        });
    }

    handleFileSelection(files) {
        this.selectedFiles = Array.from(files);
        this.displayFiles();
        this.updateUploadButton();
    }

    displayFiles() {
        const preview = document.getElementById('filePreview');
        const fileList = document.getElementById('fileList');
        const fileCount = document.getElementById('fileCount');

        if (this.selectedFiles.length > 0) {
            preview.style.display = 'block';
            fileList.innerHTML = '';
            fileCount.textContent = this.selectedFiles.length;

            this.selectedFiles.forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';

                const icon = this.getFileIcon(file.type);
                const size = this.formatFileSize(file.size);
                const isLarge = file.size > 50 * 1024 * 1024;

                fileItem.innerHTML = `
                    <div class="file-icon">
                        <i class="mdi ${icon}"></i>
                    </div>
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-size">${size} ${isLarge ? '(آپلود تکه‌ای)' : ''}</div>
                    </div>
                    <div class="file-status">
                        <span class="badge bg-secondary">#${index + 1}</span>
                    </div>
                `;

                fileList.appendChild(fileItem);
            });
        } else {
            preview.style.display = 'none';
        }
    }

    updateUploadButton() {
        const uploadBtn = document.getElementById('uploadBtn');
        uploadBtn.disabled = this.selectedFiles.length === 0;
    }

    async uploadFiles() {
        if (this.selectedFiles.length === 0) return;

        this.totalFiles = this.selectedFiles.length;
        this.uploadedFiles = 0;
        this.currentFileIndex = 0;

        this.showProgress();
        this.updateProgress(0, 'شروع آپلود...');

        try {
            for (let i = 0; i < this.selectedFiles.length; i++) {
                this.currentFileIndex = i + 1;
                const file = this.selectedFiles[i];

                this.updateProgress(
                    (i / this.totalFiles) * 100,
                    `در حال آپلود فایل ${i + 1} از ${this.totalFiles}: ${file.name}`
                );

                await this.uploadSingleFile(file);
                this.uploadedFiles++;
            }

            this.updateProgress(100, 'آپلود تکمیل شد!');
            this.showSuccess(`${this.uploadedFiles} فایل با موفقیت آپلود شد`);

            // Reset form
            setTimeout(() => {
                this.resetForm();
            }, 2000);

        } catch (error) {
            this.showError('خطا در آپلود فایل‌ها: ' + error.message);
        }
    }

    async uploadSingleFile(file) {
        const formData = new FormData();
        formData.append('files[]', file);

        const description = document.getElementById('description').value;
        if (description) {
            formData.append('description', description);
        }

        // Add selected tags
        const selectedTags = Array.from(document.querySelectorAll('.tag-checkbox:checked'))
            .map(checkbox => checkbox.value);
        selectedTags.forEach(tagId => {
            formData.append('tags[]', tagId);
        });

        const response = await fetch('{{ route("panel.upload-files.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        if (!result.success) {
            throw new Error(result.message);
        }
    }

    showProgress() {
        document.getElementById('progressContainer').style.display = 'block';
    }

    updateProgress(percentage, text) {
        const progressBar = document.getElementById('progressBar');
        const totalFiles = document.getElementById('totalFiles');
        const uploadedFiles = document.getElementById('uploadedFiles');
        const currentFile = document.getElementById('currentFile');

        progressBar.style.width = percentage + '%';
        progressBar.textContent = Math.round(percentage) + '%';
        totalFiles.textContent = this.totalFiles;
        uploadedFiles.textContent = this.uploadedFiles;
        currentFile.textContent = this.currentFileIndex;
    }

    showSuccess(message) {
        const successDiv = document.getElementById('successMessage');
        successDiv.textContent = message;
        successDiv.style.display = 'block';
        this.hideError();
    }

    showError(message) {
        const errorDiv = document.getElementById('errorMessage');
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        this.hideSuccess();
    }

    hideSuccess() {
        document.getElementById('successMessage').style.display = 'none';
    }

    hideError() {
        document.getElementById('errorMessage').style.display = 'none';
    }

    resetForm() {
        this.selectedFiles = [];
        document.getElementById('fileInput').value = '';
        document.getElementById('description').value = '';
        document.querySelectorAll('.tag-checkbox').forEach(checkbox => {
            checkbox.checked = false;
            checkbox.closest('.tag-item').classList.remove('selected');
        });
        document.getElementById('filePreview').style.display = 'none';
        document.getElementById('progressContainer').style.display = 'none';
        this.updateUploadButton();
        this.hideSuccess();
        this.hideError();
    }

    getFileIcon(mimeType) {
        if (!mimeType) return 'mdi-file';
        if (mimeType.startsWith('image/')) return 'mdi-file-image';
        if (mimeType.startsWith('video/')) return 'mdi-file-video';
        if (mimeType.startsWith('audio/')) return 'mdi-file-music';
        if (mimeType.includes('pdf')) return 'mdi-file-pdf-box';
        if (mimeType.includes('word')) return 'mdi-file-word';
        if (mimeType.includes('excel') || mimeType.includes('spreadsheet')) return 'mdi-file-excel';
        if (mimeType.includes('powerpoint') || mimeType.includes('presentation')) return 'mdi-file-powerpoint';
        if (mimeType.includes('zip') || mimeType.includes('rar')) return 'mdi-file-archive';
        return 'mdi-file';
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
}

// Initialize uploader
document.addEventListener('DOMContentLoaded', function() {
    new FileUploader();
});
</script>
@endpush
