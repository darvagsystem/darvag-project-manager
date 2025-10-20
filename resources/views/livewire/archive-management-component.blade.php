<div class="file-browser">
    <!-- Header Bar -->
    <div class="header-bar">
        <div class="header-left">
            <div class="search-container">
                <i class="mdi mdi-magnify"></i>
                <input type="text" wire:model.live="search" placeholder="جستجو..." class="search-input">
            </div>
        </div>
        <div class="header-right">
            <button class="header-btn" wire:click="navigateUp" title="برگشت">
                <i class="mdi mdi-arrow-left"></i>
            </button>
            <button class="header-btn" wire:click="selectAll" title="انتخاب همه">
                <i class="mdi mdi-checkbox-marked"></i>
            </button>

            @if(count($selectedItems) > 0)
                <div class="header-separator"></div>
                <button class="header-btn" wire:click="editSelected" title="ویرایش انتخاب شده‌ها">
                    <i class="mdi mdi-pencil"></i>
                </button>
                <button class="header-btn" wire:click="renameSelected" title="تغییر نام انتخاب شده‌ها">
                    <i class="mdi mdi-rename-box"></i>
                </button>
                <button class="header-btn" wire:click="showPropertiesSelected" title="ویژگی‌های انتخاب شده‌ها">
                    <i class="mdi mdi-information"></i>
                </button>
                <button class="header-btn danger" wire:click="deleteSelected" title="حذف انتخاب شده‌ها">
                    <i class="mdi mdi-delete"></i>
                </button>
                <button class="header-btn" wire:click="clearSelection" title="لغو انتخاب">
                    <i class="mdi mdi-close"></i>
                </button>
            @endif

            <div class="header-separator"></div>
            <button class="header-btn" onclick="showUploadModal()" title="آپلود فایل">
                <i class="mdi mdi-upload"></i>
            </button>
            <button class="header-btn" wire:click="setViewMode('grid')" title="نمایش شبکه‌ای">
                <i class="mdi mdi-view-grid"></i>
            </button>
            <button class="header-btn" wire:click="setViewMode('list')" title="نمایش لیستی">
                <i class="mdi mdi-view-list"></i>
            </button>
            <div class="user-avatar">
                <i class="mdi mdi-account"></i>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-alert-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <!-- Left Sidebar -->
        <div class="left-sidebar">
            <div class="sidebar-section">
                <button class="sidebar-main-btn {{ $currentPath === '/' ? 'active' : '' }}" wire:click="navigateTo('/')">
                    <i class="mdi mdi-folder"></i>
                    <span>فایل‌های من</span>
                </button>

                <div class="sidebar-actions">
                    <button class="sidebar-action" wire:click="$set('showCreateFolderModal', true)">
                        <i class="mdi mdi-folder-plus"></i>
                        <span>پوشه جدید +</span>
                    </button>
                    <button class="sidebar-action" onclick="showUploadModal()">
                        <i class="mdi mdi-file-plus"></i>
                        <span>فایل جدید +</span>
                    </button>
                </div>
            </div>

            <!-- Folder Structure Tree -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <i class="mdi mdi-folder-tree"></i>
                    ساختار پوشه‌ها
                </div>
                <div class="folder-tree">
                    @if($archive->rootFolders->count() > 0)
                        @foreach($archive->rootFolders as $folder)
                            @include('livewire.partials.folder-tree-item', ['folder' => $folder, 'level' => 0])
                        @endforeach
                    @else
                        <div class="tree-empty">
                            <i class="mdi mdi-folder-open-outline"></i>
                            <span>هیچ پوشه‌ای وجود ندارد</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Panel -->
        <div class="main-panel">
            <div class="panel-header">
                <h2>بایگانی</h2>
            </div>

            <!-- Folder Grid -->
            <div class="folder-grid">
                @forelse($this->items as $item)
                    @if($item instanceof \App\Models\ArchiveFolder)
                        <div class="folder-card {{ in_array('folder_' . $item->id, $selectedItems) ? 'selected' : '' }}"
                             wire:click="selectItem({{ $item->id }}, 'folder')"
                             wire:dblclick="openItem({{ $item->id }}, 'folder')"
                             data-item-id="{{ $item->id }}"
                             data-item-type="folder">
                            <div class="folder-icon" style="color: {{ $item->color ?? '#ff9800' }};">
                                <i class="mdi mdi-folder"></i>
                            </div>
                            <div class="folder-name">{{ $item->name }}</div>
                            <div class="folder-date">{{ $item->created_at->format('M d, Y') }}</div>
                            <div class="folder-actions">
                                <button class="action-btn" wire:click.stop="editFolder({{ $item->id }})" title="ویرایش">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <button class="action-btn" wire:click.stop="renameItem({{ $item->id }}, 'folder')" title="تغییر نام">
                                    <i class="mdi mdi-rename-box"></i>
                                </button>
                                <button class="action-btn" wire:click.stop="showProperties({{ $item->id }}, 'folder')" title="ویژگی‌ها">
                                    <i class="mdi mdi-information"></i>
                                </button>
                                <button class="action-btn danger" wire:click.stop="deleteFolder({{ $item->id }})" title="حذف">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="file-card {{ in_array('file_' . $item->id, $selectedItems) ? 'selected' : '' }}"
                             wire:click="selectItem({{ $item->id }}, 'file')"
                             wire:dblclick="openItem({{ $item->id }}, 'file')"
                             data-item-id="{{ $item->id }}"
                             data-item-type="file">
                            <div class="file-icon">
                                <i class="mdi mdi-file"></i>
                            </div>
                            <div class="file-name">{{ $item->name }}</div>
                            <div class="file-date">{{ $item->created_at->format('M d, Y') }}</div>
                            <div class="file-actions">
                                <button class="action-btn" wire:click.stop="downloadFile({{ $item->id }})" title="دانلود">
                                    <i class="mdi mdi-download"></i>
                                </button>
                                <button class="action-btn" wire:click.stop="renameItem({{ $item->id }}, 'file')" title="تغییر نام">
                                    <i class="mdi mdi-rename-box"></i>
                                </button>
                                <button class="action-btn" wire:click.stop="showProperties({{ $item->id }}, 'file')" title="ویژگی‌ها">
                                    <i class="mdi mdi-information"></i>
                                </button>
                                <button class="action-btn danger" wire:click.stop="deleteFile({{ $item->id }})" title="حذف">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="empty-state">
                        <i class="mdi mdi-folder-open-outline"></i>
                        <p>این پوشه خالی است</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Status Bar -->
    <div class="status-bar">
        <div class="status-left">
            <span>{{ count($this->items) }} مورد</span>
            @if(!empty($selectedItems))
                <span>، {{ count($selectedItems) }} انتخاب شده</span>
            @endif
        </div>
        <div class="status-right">
            <div class="completion-status">
                <span>{{ $archive->getCompletionPercentage() }}% تکمیل شده</span>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $archive->getCompletionPercentage() }}%"></div>
                </div>
            </div>
            <div class="app-version">Archive Manager 1.0.0</div>
        </div>
    </div>

    <!-- Modals -->
    @include('livewire.partials.upload-modal')
    @include('livewire.partials.create-folder-modal')
    @include('livewire.partials.edit-folder-modal')
    @include('livewire.partials.rename-modal')
    @include('livewire.partials.properties-modal')

    <style>
/* File Browser Style - Similar to the image */
.file-browser {
    height: calc(100vh - 200px);
    display: flex;
    flex-direction: column;
    background: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Header Bar */
.header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
    background: white;
    border-bottom: 1px solid #e0e0e0;
    height: 60px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.header-btn {
    width: 36px;
    height: 36px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #666;
    transition: all 0.2s;
}

.header-btn:hover {
    background: #f8f9fa;
    border-color: #667eea;
    color: #667eea;
}

.header-btn.danger {
    color: #dc3545;
}

.header-btn.danger:hover {
    background-color: #f8d7da;
    color: #721c24;
}

.header-separator {
    width: 1px;
    height: 24px;
    background-color: #dee2e6;
    margin: 0 8px;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 16px;
}

.search-container {
    position: relative;
    width: 200px;
}

.search-container i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
    font-size: 16px;
}

.search-input {
    width: 100%;
    height: 36px;
    padding: 8px 12px 8px 40px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    background: #f8f9fa;
    transition: all 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
}

.user-avatar {
    width: 36px;
    height: 36px;
    background: #667eea;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

/* Main Content */
.main-content {
    flex: 1;
    display: flex;
    overflow: hidden;
}

.main-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    padding: 20px;
}

.panel-header {
    margin-bottom: 20px;
}

.panel-header h2 {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

/* Folder Grid */
.folder-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 12px;
    flex: 1;
    overflow-y: auto;
    max-width: 100%;
}

.folder-card, .file-card {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 12px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    height: 120px;
    width: 100%;
    justify-content: center;
    aspect-ratio: 1;
    position: relative;
}

.folder-card:hover, .file-card:hover {
    border-color: #1976d2;
    box-shadow: 0 2px 8px rgba(25, 118, 210, 0.1);
    transform: translateY(-1px);
}

.folder-card.selected, .file-card.selected {
    border-color: #1976d2;
    background: #e3f2fd;
    box-shadow: 0 4px 12px rgba(25, 118, 210, 0.2);
}

.folder-icon, .file-icon {
    font-size: 24px;
    color: #ff9800;
    margin-bottom: 6px;
}

.file-card .file-icon {
    color: #2196f3;
}

.folder-name, .file-name {
    font-size: 12px;
    font-weight: 500;
    color: #333;
    margin-bottom: 4px;
    word-break: break-word;
    line-height: 1.2;
}

.folder-date, .file-date {
    font-size: 10px;
    color: #666;
}

.folder-actions, .file-actions {
    position: absolute;
    top: 4px;
    right: 4px;
    display: flex;
    gap: 2px;
    opacity: 0;
    transition: opacity 0.2s;
}

.folder-card:hover .folder-actions,
.file-card:hover .file-actions {
    opacity: 1;
}

.action-btn {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    color: #666;
    transition: all 0.2s;
}

.action-btn:hover {
    background: #f8f9fa;
    border-color: #1976d2;
    color: #1976d2;
}

.action-btn.danger:hover {
    background: #f8d7da;
    border-color: #dc3545;
    color: #dc3545;
}

/* Left Sidebar */
.left-sidebar {
    width: 200px;
    background: white;
    border-right: 1px solid #e0e0e0;
    padding: 20px;
    display: flex;
    flex-direction: column;
}

.sidebar-section {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.sidebar-title {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e0e0e0;
}

.folder-tree {
    max-height: 300px;
    overflow-y: auto;
}

.tree-item {
    display: flex;
    align-items: center;
    padding: 6px 8px;
    margin: 2px 0;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
    font-size: 13px;
}

.tree-item:hover {
    background-color: #f0f0f0;
}

.tree-item.selected {
    background-color: #e3f2fd;
    color: #1976d2;
}

.tree-item.current {
    background-color: #1976d2;
    color: white;
    font-weight: 600;
}

.tree-item.current:hover {
    background-color: #1565c0;
}

.tree-toggle {
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 8px;
    font-size: 12px;
}

.tree-icon {
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 4px;
    font-size: 14px;
    transition: all 0.2s;
}

.tree-name {
    flex: 1;
    margin-left: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.tree-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    color: #6c757d;
    font-size: 12px;
    text-align: center;
}

.tree-empty i {
    font-size: 24px;
    margin-bottom: 8px;
    opacity: 0.5;
}

.sidebar-main-btn {
    width: 100%;
    padding: 12px 16px;
    background: #1976d2;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
}

.sidebar-main-btn:hover {
    background: #1565c0;
}

.sidebar-actions {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.sidebar-action {
    width: 100%;
    padding: 12px 16px;
    background: transparent;
    color: #333;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    transition: all 0.2s;
}

.sidebar-action:hover {
    background: #f8f9fa;
    border-color: #1976d2;
    color: #1976d2;
}

/* Status Bar */
.status-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
    background: white;
    border-top: 1px solid #e0e0e0;
    font-size: 12px;
    color: #666;
    height: 50px;
}

.status-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.completion-status {
    display: flex;
    align-items: center;
    gap: 8px;
}

.progress-bar {
    width: 60px;
    height: 4px;
    background: #e0e0e0;
    border-radius: 2px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: #4caf50;
    transition: width 0.3s ease;
}

.app-version {
    font-size: 11px;
    color: #999;
}

/* Empty State */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 300px;
    color: #666;
    grid-column: 1 / -1;
}

.empty-state i {
    font-size: 64px;
    margin-bottom: 16px;
    color: #ccc;
}

.empty-state p {
    font-size: 16px;
    margin: 0;
}

/* Modal fixes */
.modal {
    z-index: 9999 !important;
}

.modal.show {
    display: block !important;
    background-color: rgba(0,0,0,0.5) !important;
}

.modal-dialog {
    z-index: 10000 !important;
}

/* Context menu fixes */
.context-menu {
    z-index: 10001 !important;
}

/* Alert Messages */
.alert {
    margin: 10px 20px;
    padding: 12px 16px;
    border-radius: 6px;
    border: none;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.alert .btn-close {
    background: none;
    border: none;
    font-size: 18px;
    color: inherit;
    cursor: pointer;
    padding: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.alert .btn-close:hover {
    opacity: 0.7;
}

/* Responsive */
@media (max-width: 768px) {
    .left-sidebar {
        width: 150px;
    }

    .folder-grid {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 8px;
    }

    .search-container {
        width: 150px;
    }

    .folder-card, .file-card {
        padding: 8px;
        height: 80px;
    }

    .folder-icon, .file-icon {
        font-size: 20px;
        margin-bottom: 4px;
    }

    .folder-name, .file-name {
        font-size: 10px;
    }

    .folder-date, .file-date {
        font-size: 9px;
    }
}

@media (max-width: 480px) {
    .folder-grid {
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 6px;
    }

    .folder-card, .file-card {
        height: 70px;
        padding: 6px;
    }

    .folder-icon, .file-icon {
        font-size: 18px;
    }

    .folder-name, .file-name {
        font-size: 9px;
    }

    .folder-date, .file-date {
        font-size: 8px;
    }
}
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey) {
                    switch(e.key) {
                        case 'a':
                            e.preventDefault();
                            Livewire.dispatch('selectAll');
                            break;
                        case 'Delete':
                            e.preventDefault();
                            Livewire.dispatch('deleteSelected');
                            break;
                    }
                }
            });
        });
    </script>
</div>
