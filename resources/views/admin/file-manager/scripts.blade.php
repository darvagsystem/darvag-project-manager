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
            // هدایت به صفحه آپلود جدید
            window.location.href = '{{ route("panel.upload-files") }}';
        });

        // دکمه آپلود در صفحه خالی
        document.getElementById('uploadEmptyBtn')?.addEventListener('click', () => {
            // هدایت به صفحه آپلود جدید
            window.location.href = '{{ route("panel.upload-files") }}';
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

        document.getElementById('confirmDelete')?.addEventListener('click', () => {
            this.deleteSelected();
        });

        // فرم‌ها
        document.getElementById('createFolderForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.createFolder();
        });

        document.getElementById('renameForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.renameItem();
        });

        // کلیک روی آیتم‌ها
        document.addEventListener('click', (e) => {
            if (e.target.closest('.file-item')) {
                this.toggleSelection(e.target.closest('.file-item'));
            }
        });
    }

    bindItemEvents() {
        // bind کردن event های آیتم‌های موجود
        document.querySelectorAll('.file-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleSelection(item);
            });
        });
    }

    toggleSelection(item) {
        if (item.classList.contains('selected')) {
            item.classList.remove('selected');
            this.selectedItems = this.selectedItems.filter(selected => selected !== item);
        } else {
            item.classList.add('selected');
            this.selectedItems.push(item);
        }
        this.updateToolbar();
    }

    updateToolbar() {
        const downloadBtn = document.getElementById('downloadBtn');
        const renameBtn = document.getElementById('renameBtn');
        const deleteBtn = document.getElementById('deleteBtn');

        if (this.selectedItems.length === 0) {
            downloadBtn?.setAttribute('disabled', 'disabled');
            renameBtn?.setAttribute('disabled', 'disabled');
            deleteBtn?.setAttribute('disabled', 'disabled');
        } else if (this.selectedItems.length === 1) {
            downloadBtn?.removeAttribute('disabled');
            renameBtn?.removeAttribute('disabled');
            deleteBtn?.removeAttribute('disabled');
        } else {
            downloadBtn?.removeAttribute('disabled');
            renameBtn?.setAttribute('disabled', 'disabled');
            deleteBtn?.removeAttribute('disabled');
        }
    }

    showCreateFolderModal() {
        const modal = new bootstrap.Modal(document.getElementById('createFolderModal'));
        document.getElementById('createFolderForm').reset();
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

        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 B';

        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
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

    getCurrentFolderId() {
        const container = document.getElementById('fileManagerContainer');
        return container ? container.dataset.folderId : null;
    }

    getProjectId() {
        return this.project;
    }

    async createFolder() {
        const form = document.getElementById('createFolderForm');
        const formData = new FormData(form);
        const currentFolderId = this.getCurrentFolderId();
        const projectId = this.getProjectId();

        if (currentFolderId) {
            formData.append('parent_id', currentFolderId);
        }
        if (projectId) {
            formData.append('project_id', projectId);
        }

        try {
            const response = await fetch('{{ isset($project) ? route("panel.projects.filemanager.create-folder", $project->id) : route("panel.file-manager.create-folder") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();
            if (result.success) {
                this.showSuccess('پوشه با موفقیت ایجاد شد');
                const modal = bootstrap.Modal.getInstance(document.getElementById('createFolderModal'));
                modal.hide();
                this.refreshView();
            } else {
                this.showError(result.message);
            }
        } catch (error) {
            this.showError('خطا در ایجاد پوشه: ' + error.message);
        }
    }

    async renameItem() {
        if (this.selectedItems.length !== 1) return;

        const item = this.selectedItems[0];
        const itemId = item.dataset.itemId;
        const newName = document.getElementById('newName').value.trim();

        if (!newName) {
            this.showError('لطفاً نام جدید را وارد کنید');
            return;
        }

        try {
            const response = await fetch('{{ isset($project) ? route("panel.projects.filemanager.rename.post", $project->id) : route("panel.file-manager.rename.post") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    id: itemId,
                    name: newName
                })
            });

            const result = await response.json();
            if (result.success) {
                this.showSuccess('نام با موفقیت تغییر کرد');
                const modal = bootstrap.Modal.getInstance(document.getElementById('renameModal'));
                modal.hide();
                this.refreshView();
            } else {
                this.showError(result.message);
            }
        } catch (error) {
            this.showError('خطا در تغییر نام: ' + error.message);
        }
    }

    async deleteSelected() {
        if (this.selectedItems.length === 0) return;

        const itemIds = this.selectedItems.map(item => item.dataset.itemId);

        try {
            const response = await fetch('{{ isset($project) ? route("panel.projects.filemanager.delete", $project->id) : route("panel.file-manager.delete") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    ids: itemIds
                })
            });

            const result = await response.json();
            if (result.success) {
                this.showSuccess(`${itemIds.length} آیتم با موفقیت حذف شد`);
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                modal.hide();
                this.refreshView();
            } else {
                this.showError(result.message);
            }
        } catch (error) {
            this.showError('خطا در حذف آیتم‌ها: ' + error.message);
        }
    }

    async downloadSelected() {
        if (this.selectedItems.length === 0) return;

        if (this.selectedItems.length === 1) {
            // دانلود تک فایل
            const item = this.selectedItems[0];
            const itemId = item.dataset.itemId;
            const itemName = item.querySelector('.file-name').textContent.trim();

            window.open(`{{ isset($project) ? route("panel.projects.filemanager.download.post", $project->id) : route("panel.file-manager.download.post") }}?id=${itemId}`, '_blank');
        } else {
            // دانلود چند فایل (ZIP)
            const itemIds = this.selectedItems.map(item => item.dataset.itemId);
            const params = new URLSearchParams();
            itemIds.forEach(id => params.append('ids[]', id));

            window.open(`{{ isset($project) ? route("panel.projects.filemanager.download.post", $project->id) : route("panel.file-manager.download.post") }}?${params.toString()}`, '_blank');
        }
    }

    refreshView() {
        window.location.reload();
    }

    showSuccess(message) {
        // ایجاد toast notification
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white bg-success border-0';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="mdi mdi-check-circle me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

        document.body.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

        // حذف toast بعد از 5 ثانیه
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }

    showError(message) {
        // ایجاد toast notification
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white bg-danger border-0';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="mdi mdi-alert-circle me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

        document.body.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

        // حذف toast بعد از 5 ثانیه
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }
}

// Initialize file manager
document.addEventListener('DOMContentLoaded', function() {
    new FileManager();
});
</script>
