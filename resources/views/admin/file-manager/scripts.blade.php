<script>
class FileManager {
    constructor() {
        this.selectedItems = [];
        this.currentFolder = null;
        this.project = @if(isset($project)) {{ $project->id }} @else null @endif;
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateToolbar();

        // اطمینان از bind شدن event های آیتم‌های موجود
        setTimeout(() => {
            this.bindItemEvents();
        }, 100);
    }

    bindEvents() {
        // دکمه‌های اصلی
        document.getElementById('createFolderBtn')?.addEventListener('click', () => {
            this.showCreateFolderModal();
        });

        document.getElementById('uploadBtn')?.addEventListener('click', () => {
            this.showUploadModal();
        });

        // دکمه‌های toolbar
        document.getElementById('downloadBtn')?.addEventListener('click', () => {
            this.downloadSelected();
        });

        document.getElementById('renameBtn')?.addEventListener('click', () => {
            this.showRenameModal();
        });

        document.getElementById('deleteBtn')?.addEventListener('click', () => {
            this.showDeleteModal();
        });

        // انتخاب فایل در modal آپلود
        document.getElementById('fileInput')?.addEventListener('change', (e) => {
            this.handleFileSelection(e.target.files);
        });

        // فرم‌ها
        document.getElementById('createFolderForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.createFolder();
        });

        document.getElementById('uploadForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.uploadFiles();
        });

        document.getElementById('renameForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.renameItem();
        });

        document.getElementById('confirmDelete')?.addEventListener('click', () => {
            this.deleteSelected();
        });

        // کلیک روی آیتم‌ها
        this.bindItemEvents();
    }

    bindItemEvents() {
        // حذف event listener های قبلی
        document.querySelectorAll('.file-item, .folder-item').forEach(item => {
            // کپی کردن element برای حذف تمام event listener ها
            const newItem = item.cloneNode(true);
            item.parentNode.replaceChild(newItem, item);
        });

        // اضافه کردن event listener های جدید
        document.querySelectorAll('.file-item, .folder-item').forEach(item => {
            item.addEventListener('click', (e) => {
                this.handleItemClick(item, e);
            });

            item.addEventListener('dblclick', (e) => {
                this.handleItemDoubleClick(item, e);
            });
        });
    }

    handleItemClick(item, event) {
        const isCtrlPressed = event.ctrlKey || event.metaKey;

        if (isCtrlPressed) {
            // انتخاب چندتایی
            item.classList.toggle('selected');
        } else {
            // انتخاب تکی
            document.querySelectorAll('.file-item, .folder-item').forEach(i => {
                i.classList.remove('selected');
            });
            item.classList.add('selected');
        }

        this.updateSelectedItems();
        this.updateToolbar();
    }

    handleItemDoubleClick(item, event) {
        const isFolder = item.classList.contains('folder-item');
        const itemId = item.dataset.id;

        if (isFolder) {
            // ورود به پوشه
            this.navigateToFolder(itemId);
        } else {
            // دانلود فایل
            this.downloadFile(item);
        }
    }

    navigateToFolder(folderId) {
        const currentUrl = new URL(window.location);

        if (folderId) {
            currentUrl.searchParams.set('folder', folderId);
        } else {
            currentUrl.searchParams.delete('folder');
        }

        window.location.href = currentUrl.toString();
    }

    updateSelectedItems() {
        this.selectedItems = Array.from(document.querySelectorAll('.file-item.selected, .folder-item.selected'));
    }

    updateToolbar() {
        const hasSelection = this.selectedItems.length > 0;
        const hasOneSelection = this.selectedItems.length === 1;

        const downloadBtn = document.getElementById('downloadBtn');
        const renameBtn = document.getElementById('renameBtn');
        const deleteBtn = document.getElementById('deleteBtn');

        if (downloadBtn) {
            downloadBtn.style.display = hasSelection ? 'inline-block' : 'none';
            downloadBtn.disabled = !hasSelection;
        }

        if (renameBtn) {
            renameBtn.style.display = hasOneSelection ? 'inline-block' : 'none';
            renameBtn.disabled = !hasOneSelection;
        }

        if (deleteBtn) {
            deleteBtn.style.display = hasSelection ? 'inline-block' : 'none';
            deleteBtn.disabled = !hasSelection;
        }
    }

    showCreateFolderModal() {
        const modal = new bootstrap.Modal(document.getElementById('createFolderModal'));
        document.getElementById('createFolderForm').reset();
        modal.show();
    }

    showUploadModal() {
        const modal = new bootstrap.Modal(document.getElementById('uploadModal'));
        document.getElementById('uploadForm').reset();
        document.getElementById('filePreview').style.display = 'none';
        modal.show();
    }

    showRenameModal() {
        if (this.selectedItems.length !== 1) return;

        const item = this.selectedItems[0];
        const currentName = item.querySelector('.file-name').textContent.trim();

        document.getElementById('newName').value = currentName;

        const modal = new bootstrap.Modal(document.getElementById('renameModal'));
        modal.show();
    }

    showDeleteModal() {
        if (this.selectedItems.length === 0) return;

        const count = this.selectedItems.length;
        const message = count === 1 ?
            'آیا مطمئن هستید که می‌خواهید این آیتم را حذف کنید؟' :
            `آیا مطمئن هستید که می‌خواهید ${count} آیتم را حذف کنید؟`;

        document.getElementById('deleteMessage').textContent = message;

        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    handleFileSelection(files) {
        const preview = document.getElementById('filePreview');
        const fileList = document.getElementById('fileList');

        if (files.length > 0) {
            preview.style.display = 'block';
            fileList.innerHTML = '';

            Array.from(files).forEach(file => {
                const item = document.createElement('div');
                item.className = 'list-group-item d-flex justify-content-between align-items-center';
                item.innerHTML = `
                    <div>
                        <i class="mdi mdi-file me-2"></i>
                        ${file.name}
                    </div>
                    <small class="text-muted">${this.formatFileSize(file.size)}</small>
                `;
                fileList.appendChild(item);
            });
        } else {
            preview.style.display = 'none';
        }
    }

    async createFolder() {
        const form = document.getElementById('createFolderForm');
        const formData = new FormData(form);

        // اضافه کردن پارامترهای اضافی
        const currentFolderId = this.getCurrentFolderId();
        if (currentFolderId) {
            formData.append('parent_id', currentFolderId);
        }
        if (this.project) {
            formData.append('project_id', this.project);
        }

        try {
            const url = this.getApiUrl('create-folder');
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showSuccess(result.message);
                bootstrap.Modal.getInstance(document.getElementById('createFolderModal')).hide();
                this.refreshView();
            } else {
                this.showError(result.message);
            }
        } catch (error) {
            this.showError('خطا در ایجاد پوشه');
        }
    }

    async uploadFiles() {
        const fileInput = document.getElementById('fileInput');
        const description = document.getElementById('fileDescription').value;

        if (!fileInput.files || fileInput.files.length === 0) {
            this.showError('لطفاً حداقل یک فایل انتخاب کنید');
            return;
        }

        const formData = new FormData();

        // اضافه کردن فایل‌ها
        Array.from(fileInput.files).forEach(file => {
            formData.append('files[]', file);
        });

        // اضافه کردن پارامترهای اضافی
        if (description) {
            formData.append('description', description);
        }

        const currentFolderId = this.getCurrentFolderId();
        if (currentFolderId) {
            formData.append('parent_id', currentFolderId);
        }
        if (this.project) {
            formData.append('project_id', this.project);
        }

        // نمایش progress modal
        const progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
        progressModal.show();

        try {
            const url = this.getApiUrl('upload');
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();
            progressModal.hide();

            if (result.success) {
                this.showSuccess(result.message);
                bootstrap.Modal.getInstance(document.getElementById('uploadModal')).hide();
                this.refreshView();
            } else {
                this.showError(result.message);
            }
        } catch (error) {
            progressModal.hide();
            this.showError('خطا در آپلود فایل‌ها');
        }
    }

    async renameItem() {
        if (this.selectedItems.length !== 1) return;

        const item = this.selectedItems[0];
        const itemId = item.dataset.id;
        const newName = document.getElementById('newName').value;

        try {
            const url = this.getApiUrl(`${itemId}/rename`);
            const response = await fetch(url, {
                method: 'PUT',
                body: JSON.stringify({ name: newName }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showSuccess(result.message);
                bootstrap.Modal.getInstance(document.getElementById('renameModal')).hide();
                this.refreshView();
            } else {
                this.showError(result.message);
            }
        } catch (error) {
            this.showError('خطا در تغییر نام');
        }
    }

    async deleteSelected() {
        if (this.selectedItems.length === 0) return;

        const ids = this.selectedItems.map(item => item.dataset.id);

        try {
            const url = this.getApiUrl('delete');
            const response = await fetch(url, {
                method: 'DELETE',
                body: JSON.stringify({ ids }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showSuccess(result.message);
                bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
                this.refreshView();
            } else {
                this.showError(result.message);
            }
        } catch (error) {
            this.showError('خطا در حذف آیتم‌ها');
        }
    }

    downloadFile(fileElement) {
        const downloadUrl = fileElement.dataset.downloadUrl;

        if (!downloadUrl) {
            this.showError('لینک دانلود یافت نشد');
            return;
        }

        // دانلود مستقیم از طریق لینک PHP
        window.location.href = downloadUrl;
    }

    downloadSelected() {
        if (this.selectedItems.length === 0) return;

        // فیلتر کردن فقط فایل‌ها (نه پوشه‌ها)
        const files = this.selectedItems.filter(item => item.classList.contains('file-item'));

        if (files.length === 0) {
            this.showError('لطفاً یک فایل برای دانلود انتخاب کنید');
            return;
        }

        if (files.length === 1) {
            // دانلود تکی
            this.downloadFile(files[0]);
        } else {
            // دانلود گروهی (اگر پیاده‌سازی شده باشد)
            this.showError('دانلود گروهی هنوز پیاده‌سازی نشده است');
        }
    }

    async refreshView() {
        try {
            const currentFolderId = this.getCurrentFolderId();
            const url = this.getApiUrl('files') + (currentFolderId ? `?folder=${currentFolderId}` : '');

            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const result = await response.json();

                if (result.success) {
                    this.updateFileGrid(result.data.folders, result.data.files);
                    this.updateBreadcrumb(result.data.breadcrumb);
                } else {
                    window.location.reload();
                }
            } else {
                window.location.reload();
            }
        } catch (error) {
            window.location.reload();
        }
    }

    updateFileGrid(folders, files) {
        const fileGrid = document.querySelector('.file-grid');
        if (!fileGrid) return;

        fileGrid.innerHTML = '';

        // اضافه کردن پوشه‌ها
        folders.forEach(folder => {
            const element = this.createFolderElement(folder);
            fileGrid.appendChild(element);
        });

        // اضافه کردن فایل‌ها
        files.forEach(file => {
            const element = this.createFileElement(file);
            fileGrid.appendChild(element);
        });

        // بایند کردن مجدد event ها
        this.bindItemEvents();
        this.selectedItems = [];
        this.updateToolbar();
    }

    createFolderElement(folder) {
        const div = document.createElement('div');
        div.className = 'folder-item';
        div.dataset.id = folder.id;
        div.dataset.type = 'folder';

        div.innerHTML = `
            <div class="folder-icon" style="color: ${folder.folder_color || '#ffc107'}">
                <i class="mdi mdi-folder"></i>
            </div>
            <div class="file-name">${folder.name}</div>
            <div class="file-size">پوشه</div>
        `;

        return div;
    }

    createFileElement(file) {
        const div = document.createElement('div');
        div.className = 'file-item';
        div.dataset.id = file.id;
        div.dataset.type = 'file';

        // ایجاد URL دانلود
        const downloadUrl = this.getApiUrl(`download/${file.id}`);
        div.dataset.downloadUrl = downloadUrl;

        const icon = this.getFileIcon(file.mime_type);
        const size = this.formatFileSize(file.size);
        const isImage = file.mime_type && file.mime_type.startsWith('image/');

        if (isImage) {
            const thumbnailUrl = this.getApiUrl(`thumbnail/${file.id}`);
            div.innerHTML = `
                <div class="file-icon image-thumbnail">
                    <img src="${thumbnailUrl}" alt="${file.name}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <i class="mdi ${icon}" style="display: none;"></i>
                </div>
                <div class="file-name" title="${file.name}">${this.truncateFileName(file.name)}</div>
                <div class="file-size">${size}</div>
            `;
        } else {
            div.innerHTML = `
                <div class="file-icon">
                    <i class="mdi ${icon}"></i>
                </div>
                <div class="file-name" title="${file.name}">${this.truncateFileName(file.name)}</div>
                <div class="file-size">${size}</div>
            `;
        }

        return div;
    }

    truncateFileName(fileName) {
        // اگر نام فایل خیلی طولانی است، آن را کوتاه کنیم
        if (fileName.length > 20) {
            const lastDotIndex = fileName.lastIndexOf('.');
            if (lastDotIndex > 0) {
                // فایل دارای پسوند است
                const nameWithoutExt = fileName.substring(0, lastDotIndex);
                const extension = fileName.substring(lastDotIndex);
                if (nameWithoutExt.length > 15) {
                    return nameWithoutExt.substring(0, 15) + '...' + extension;
                }
            } else {
                // فایل بدون پسوند
                return fileName.substring(0, 17) + '...';
            }
        }
        return fileName;
    }

    updateBreadcrumb(breadcrumb) {
        const breadcrumbNav = document.querySelector('.breadcrumb-nav');
        if (!breadcrumbNav) return;

        let html = `
            <div class="breadcrumb-item" onclick="fileManager.navigateToFolder(null)" style="cursor: pointer;">
                <i class="mdi mdi-home"></i>
                <span>خانه</span>
            </div>
        `;

        if (breadcrumb && breadcrumb.length > 0) {
            breadcrumb.forEach((item, index) => {
                html += `<span class="breadcrumb-separator">/</span>`;

                if (index === breadcrumb.length - 1) {
                    // آخرین آیتم (پوشه فعلی) غیرقابل کلیک
                    html += `
                        <div class="breadcrumb-item active">
                            <i class="mdi mdi-folder"></i>
                            <span>${item.name}</span>
                        </div>
                    `;
                } else {
                    // سایر آیتم‌ها قابل کلیک
                    html += `
                        <div class="breadcrumb-item" onclick="fileManager.navigateToFolder(${item.id})" style="cursor: pointer;">
                            <i class="mdi mdi-folder"></i>
                            <span>${item.name}</span>
                        </div>
                    `;
                }
            });
        }

        breadcrumbNav.innerHTML = html;
    }

    getCurrentFolderId() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('folder');
    }

    getApiUrl(endpoint) {
        if (this.project) {
            return `/projects/${this.project}/filemanager/${endpoint}`;
        } else {
            return `/file-manager/${endpoint}`;
        }
    }

    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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

    showSuccess(message) {
        // می‌توانید از toast notification استفاده کنید
        alert(message);
    }

    showError(message) {
        // می‌توانید از toast notification استفاده کنید
        alert(message);
    }
}

// راه‌اندازی فایل منیجر
document.addEventListener('DOMContentLoaded', function() {
    window.fileManager = new FileManager();
});
</script>
