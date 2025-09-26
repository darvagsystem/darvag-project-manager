<script>
// File Manager JavaScript
class FileManager {
    constructor() {
        this.selectedItems = [];
        this.currentFolder = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateToolbar();
    }

    bindEvents() {
        const currentFolderId = document.getElementById('fileManagerContainer')?.dataset.folderId;
        // Create folder button
        document.getElementById('createFolderBtn')?.addEventListener('click', () => {
            this.showCreateFolderModal();
        });

        // Upload button
        document.getElementById('uploadBtn')?.addEventListener('click', () => {
            this.showUploadModal();
        });

        // File input change
        document.getElementById('fileInput')?.addEventListener('change', (e) => {
            this.handleFileSelection(e.target.files);
        });

        // Toolbar buttons
        document.getElementById('downloadBtn')?.addEventListener('click', () => {
            this.downloadSelected();
        });

        document.getElementById('renameBtn')?.addEventListener('click', () => {
            this.showRenameModal();
        });

        document.getElementById('deleteBtn')?.addEventListener('click', () => {
            this.showDeleteModal();
        });

        // Search
        document.getElementById('searchBtn')?.addEventListener('click', () => {
            this.search();
        });

        document.getElementById('searchInput')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.search();
            }
        });

        // File/folder click handlers
        document.addEventListener('click', (e) => {
            if (e.target.closest('.file-item, .folder-item')) {
                this.handleItemClick(e.target.closest('.file-item, .folder-item'));
            }
        });

        // Form submissions
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

        document.getElementById('moveForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.moveItems();
        });

        document.getElementById('confirmDelete')?.addEventListener('click', () => {
            this.deleteSelected();
        });
    }

    handleItemClick(item) {
        const isCtrlPressed = event.ctrlKey || event.metaKey;

        if (isCtrlPressed) {
            // Multi-select
            item.classList.toggle('selected');
        } else {
            // Single select
            document.querySelectorAll('.file-item, .folder-item').forEach(i => i.classList.remove('selected'));
            item.classList.add('selected');
        }

        this.updateSelectedItems();
        this.updateToolbar();
    }

    updateSelectedItems() {
        this.selectedItems = Array.from(document.querySelectorAll('.file-item.selected, .folder-item.selected'));
    }

    updateToolbar() {
        const hasSelection = this.selectedItems.length > 0;
        const singleSelection = this.selectedItems.length === 1;

        document.getElementById('downloadBtn').disabled = !hasSelection;
        document.getElementById('renameBtn').disabled = !singleSelection;
        document.getElementById('deleteBtn').disabled = !hasSelection;
    }

    showCreateFolderModal() {
        const modal = new bootstrap.Modal(document.getElementById('createFolderModal'));
        modal.show();
    }

    showUploadModal() {
        const modal = new bootstrap.Modal(document.getElementById('uploadModal'));
        modal.show();
    }

    showRenameModal() {
        if (this.selectedItems.length !== 1) return;

        const item = this.selectedItems[0];
        const currentName = item.querySelector('.file-name').textContent;
        const itemId = item.dataset.id;

        console.log('Rename modal - Item:', item);
        console.log('Rename modal - Item ID:', itemId);
        console.log('Rename modal - Current name:', currentName);

        if (!itemId) {
            this.showError('خطا: شناسه آیتم یافت نشد');
            return;
        }

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

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    async createFolder() {
        const form = document.getElementById('createFolderForm');
        const formData = new FormData(form);
        const currentFolderId = document.getElementById('fileManagerContainer')?.dataset.folderId;

        try {
            let url;
            if ({{ isset($project) ? 'true' : 'false' }}) {
                url = '{{ route("projects.filemanager.create-folder", $project->id) }}';
            } else {
                url = '{{ route("file-manager.create-folder") }}';
            }

            const response = await fetch(url, {
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
                bootstrap.Modal.getInstance(document.getElementById('createFolderModal')).hide();
                form.reset();
                this.refreshView();
            } else {
                this.showError(result.message || 'خطا در ایجاد پوشه');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showError('خطا در ایجاد پوشه');
        }
    }

    async uploadFiles() {
        const form = document.getElementById('uploadForm');
        const formData = new FormData(form);
        const currentFolderId = document.getElementById('fileManagerContainer')?.dataset.folderId;

        // Show progress modal
        const progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
        progressModal.show();

        try {
            let url;
            if ({{ isset($project) ? 'true' : 'false' }}) {
                url = '{{ route("projects.filemanager.upload", $project->id) }}';
            } else {
                url = '{{ route("file-manager.upload") }}';
            }

            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            progressModal.hide();

            if (result.success) {
                this.showSuccess('فایل‌ها با موفقیت آپلود شدند');
                bootstrap.Modal.getInstance(document.getElementById('uploadModal')).hide();
                form.reset();
                document.getElementById('filePreview').style.display = 'none';
                this.refreshView();
            } else {
                this.showError(result.message || 'خطا در آپلود فایل‌ها');
            }
        } catch (error) {
            console.error('Error:', error);
            progressModal.hide();
            this.showError('خطا در آپلود فایل‌ها');
        }
    }

    async renameItem() {
        if (this.selectedItems.length !== 1) return;

        const item = this.selectedItems[0];
        const itemId = item.dataset.id;
        const newName = document.getElementById('newName').value;
        const currentFolderId = document.getElementById('fileManagerContainer')?.dataset.folderId;

        // Debug: Log the itemId to console
        console.log('Selected item:', item);
        console.log('Item ID:', itemId);
        console.log('New name:', newName);

        if (!itemId) {
            this.showError('خطا: شناسه آیتم یافت نشد');
            return;
        }

        try {
            let url;
            if ({{ isset($project) ? 'true' : 'false' }}) {
                // For project routes: /projects/{project}/filemanager/{id}/rename
                url = '{{ route("projects.filemanager.rename", [$project->id, ":id"]) }}'.replace(':id', itemId);
            } else {
                // For general routes: /file-manager/{id}/rename
                url = '{{ route("file-manager.rename", ":id") }}'.replace(':id', itemId);
            }

            console.log('Request URL:', url);

            const response = await fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ name: newName, folder_id: currentFolderId })
            });

            const result = await response.json();
            console.log('Response:', result);

            if (result.success) {
                this.showSuccess('نام با موفقیت تغییر کرد');
                bootstrap.Modal.getInstance(document.getElementById('renameModal')).hide();
                this.refreshView();
            } else {
                this.showError(result.message || 'خطا در تغییر نام');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showError('خطا در تغییر نام');
        }
    }

    async deleteSelected() {
        if (this.selectedItems.length === 0) return;

        const itemIds = this.selectedItems.map(item => item.dataset.id);
        const currentFolderId = document.getElementById('fileManagerContainer')?.dataset.folderId;

        try {
            let url;
            if ({{ isset($project) ? 'true' : 'false' }}) {
                url = '{{ route("projects.filemanager.delete", $project->id) }}';
            } else {
                url = '{{ route("file-manager.delete") }}';
            }

            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ ids: itemIds, folder_id: currentFolderId })
            });

            const result = await response.json();

            if (result.success) {
                this.showSuccess('آیتم‌ها با موفقیت حذف شدند');
                bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
                this.refreshView();
            } else {
                this.showError(result.message || 'خطا در حذف آیتم‌ها');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showError('خطا در حذف آیتم‌ها');
        }
    }

    async downloadSelected() {
        if (this.selectedItems.length === 0) return;

        if (this.selectedItems.length === 1) {
            // Single file download
            const item = this.selectedItems[0];
            const itemId = item.dataset.id;
            let url;
            if ({{ isset($project) ? 'true' : 'false' }}) {
                url = '{{ route("projects.filemanager.download", [$project->id, ":id"]) }}'.replace(':id', itemId);
            } else {
                url = '{{ route("file-manager.download", ":id") }}'.replace(':id', itemId);
            }
            window.open(url, '_blank');
        } else {
            // Bulk download
            const itemIds = this.selectedItems.map(item => item.dataset.id);
            const currentFolderId = document.getElementById('fileManagerContainer')?.dataset.folderId;

            try {
                let url;
                if ({{ isset($project) ? 'true' : 'false' }}) {
                    url = '{{ route("projects.filemanager.bulk-download", $project->id) }}';
                } else {
                    url = '{{ route("file-manager.bulk-download") }}';
                }

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ ids: itemIds, folder_id: currentFolderId })
                });

                if (response.ok) {
                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'files.zip';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                } else {
                    this.showError('خطا در دانلود فایل‌ها');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showError('خطا در دانلود فایل‌ها');
            }
        }
    }

    async moveItems() {
        if (this.selectedItems.length === 0) return;

        const itemIds = this.selectedItems.map(item => item.dataset.id);
        const destinationFolderId = document.getElementById('destinationFolder').value;

        try {
            let url;
            if ({{ isset($project) ? 'true' : 'false' }}) {
                url = '{{ route("projects.filemanager.move", $project->id) }}';
            } else {
                url = '{{ route("file-manager.move") }}';
            }

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    ids: itemIds,
                    destination_folder_id: destinationFolderId || null
                })
            });

            const result = await response.json();

            if (result.success) {
                this.showSuccess('آیتم‌ها با موفقیت منتقل شدند');
                bootstrap.Modal.getInstance(document.getElementById('moveModal')).hide();
                this.refreshView();
            } else {
                this.showError(result.message || 'خطا در انتقال آیتم‌ها');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showError('خطا در انتقال آیتم‌ها');
        }
    }

    async search() {
        const query = document.getElementById('searchInput').value;
        if (!query.trim()) return;

        const currentFolderId = document.getElementById('fileManagerContainer')?.dataset.folderId;

        try {
            const params = new URLSearchParams({ q: query, folder_id: currentFolderId });
            let searchUrl;
            if ({{ isset($project) ? 'true' : 'false' }}) {
                searchUrl = '{{ route("projects.filemanager.search", $project->id) }}?';
            } else {
                searchUrl = '{{ route("file-manager.search") }}?';
            }
            const response = await fetch(searchUrl + params.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const result = await response.json();

            if (result.success) {
                this.displaySearchResults(result.data);
            } else {
                this.showError('خطا در جستجو');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showError('خطا در جستجو');
        }
    }

    displaySearchResults(results) {
        const fileGrid = document.getElementById('fileGrid');
        fileGrid.innerHTML = '';

        if (results.length === 0) {
            fileGrid.innerHTML = `
                <div class="empty-folder col-12">
                    <i class="mdi mdi-magnify"></i>
                    <h5>نتیجه‌ای یافت نشد</h5>
                    <p class="text-muted">لطفاً عبارت جستجوی دیگری امتحان کنید</p>
                </div>
            `;
            return;
        }

        results.forEach(item => {
            const itemElement = this.createItemElement(item);
            fileGrid.appendChild(itemElement);
        });
    }

    createItemElement(item) {
        const div = document.createElement('div');
        div.className = item.is_folder ? 'folder-item' : 'file-item';
        div.dataset.id = item.id;
        div.dataset.type = item.is_folder ? 'folder' : 'file';

        const icon = item.is_folder ? 'mdi-folder' : this.getFileIcon(item.mime_type);
        const color = item.is_folder ? (item.folder_color || '#ffc107') : '#495057';
        const size = item.is_folder ? `${item.children_count || 0} آیتم` : this.formatFileSize(item.size);

        div.innerHTML = `
            <div class="${item.is_folder ? 'folder-icon' : 'file-icon'}" style="color: ${color}">
                <i class="mdi ${icon}"></i>
            </div>
            <div class="file-name">${item.name}</div>
            <div class="file-size">${size}</div>
        `;

        return div;
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
        if (mimeType.includes('zip') || mimeType.includes('rar')) return 'mdi-file-zip';

        return 'mdi-file';
    }

    async refreshView() {
        // Reload the page to refresh the view
        window.location.reload();
    }

    showSuccess(message) {
        // You can implement a toast notification system here
        alert(message);
    }

    showError(message) {
        // You can implement a toast notification system here
        alert(message);
    }
}

// Initialize file manager when page loads
document.addEventListener('DOMContentLoaded', function() {
    window.fileManager = new FileManager();
});
</script>
