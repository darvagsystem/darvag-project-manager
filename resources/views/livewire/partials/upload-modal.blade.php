<!-- Upload Modal -->
<div id="uploadModal" class="modal-backdrop" style="display: none;" onclick="closeModal()">
    <div class="modal-container" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h5 class="modal-title">
                <i class="mdi mdi-upload me-2"></i>آپلود فایل
            </h5>
            <button type="button" class="btn-close" onclick="closeModal()">
                <i class="mdi mdi-close"></i>
            </button>
        </div>

        <div class="modal-body">
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="uploadFiles" class="form-label">انتخاب فایل‌ها</label>
                    <input type="file" class="form-control" id="uploadFiles" name="files[]" multiple accept="*/*" required>
                    <div id="fileList" class="mt-2"></div>
                </div>

                <div class="mb-3">
                    <label for="uploadDescription" class="form-label">توضیحات (اختیاری)</label>
                    <textarea class="form-control" id="uploadDescription" name="description" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">تگ‌ها (اختیاری)</label>
                    <div class="tag-selection">
                        @foreach($tags as $tag)
                            <label class="tag-item">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                                <span class="tag-name" style="background-color: {{ $tag->color }}; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                    {{ $tag->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">
                انصراف
            </button>
            <button type="button" class="btn btn-primary" id="uploadBtn" onclick="uploadFiles()">
                <i class="mdi mdi-upload me-1"></i>
                <span id="uploadText">آپلود</span>
            </button>
        </div>
    </div>
</div>

<style>
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    z-index: 10000;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e0e0e0;
}

.modal-title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.btn-close {
    background: none;
    border: none;
    font-size: 20px;
    color: #666;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-close:hover {
    color: #333;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 20px;
    border-top: 1px solid #e0e0e0;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #1976d2;
    box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
}

.tag-selection {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag-item {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.tag-item input[type="checkbox"] {
    margin-left: 6px;
}

.tag-name {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-primary {
    background: #1976d2;
    color: white;
}

.btn-primary:hover {
    background: #1565c0;
}

.btn-warning {
    background: #ffc107;
    color: #212529;
}

.btn-warning:hover {
    background: #e0a800;
}

.text-danger {
    color: #dc3545;
    font-size: 12px;
}

/* Ensure modal is above everything */
.modal-backdrop {
    z-index: 9999 !important;
}

.modal-container {
    z-index: 10000 !important;
}

/* Fix file input styling */
#uploadFiles {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

#uploadFiles:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

#uploadFiles:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* File list styling */
#fileList {
    background-color: #f8f9fa;
    border-radius: 6px;
    padding: 10px;
    margin-top: 10px;
    border: 1px solid #e9ecef;
}

/* Tag selection styling */
.tag-selection {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
}

.tag-item {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.tag-item input[type="checkbox"] {
    margin-left: 5px;
}

.tag-name {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.tag-item:hover .tag-name {
    opacity: 0.8;
    transform: scale(1.05);
}
</style>

<script>
function initUploadModal() {
    const fileInput = document.getElementById('uploadFiles');
    const fileList = document.getElementById('fileList');

    if (fileInput && fileList) {
        // Remove existing listeners to avoid duplicates
        fileInput.removeEventListener('change', handleFileChange);
        fileInput.addEventListener('change', handleFileChange);
    }
}

function handleFileChange(event) {
    const fileList = document.getElementById('fileList');
    if (!fileList) return;

    fileList.innerHTML = '';
    if (event.target.files.length > 0) {
        const fileCount = document.createElement('div');
        fileCount.className = 'text-muted small';
        fileCount.textContent = `فایل‌های انتخاب شده: ${event.target.files.length}`;
        fileList.appendChild(fileCount);

        // Show file names
        Array.from(event.target.files).forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'small text-muted mt-1';
            fileItem.textContent = `${index + 1}. ${file.name} (${formatFileSize(file.size)})`;
            fileList.appendChild(fileItem);
        });
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function uploadFiles() {
    const form = document.getElementById('uploadForm');
    const uploadBtn = document.getElementById('uploadBtn');
    const uploadText = document.getElementById('uploadText');

    if (!form || !uploadBtn || !uploadText) {
        alert('خطا در پیدا کردن عناصر فرم');
        return;
    }

    const formData = new FormData(form);

    // Add archive ID
    formData.append('archive_id', {{ $archive->id }});

    // Disable button and show loading
    uploadBtn.disabled = true;
    uploadText.textContent = 'در حال آپلود...';

    fetch('{{ route("archives.files.upload", $archive) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('فایل‌ها با موفقیت آپلود شدند!');
            location.reload();
        } else {
            alert('خطا در آپلود: ' + (data.message || 'خطای نامشخص'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در آپلود فایل‌ها: ' + error.message);
    })
    .finally(() => {
        uploadBtn.disabled = false;
        uploadText.textContent = 'آپلود';
    });
}

function showUploadModal() {
    const modal = document.getElementById('uploadModal');
    if (modal) {
        modal.style.display = 'flex';
        initUploadModal();
    }
}

function closeModal() {
    const modal = document.getElementById('uploadModal');
    if (modal) {
        modal.style.display = 'none';
        // Reset form
        document.getElementById('uploadForm').reset();
        document.getElementById('fileList').innerHTML = '';
    }
}

// Initialize when modal is shown
document.addEventListener('DOMContentLoaded', function() {
    initUploadModal();
});

// Re-initialize when Livewire updates
document.addEventListener('livewire:updated', function() {
    initUploadModal();
});
</script>
