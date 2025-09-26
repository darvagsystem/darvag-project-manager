@extends('admin.layout')

@section('title', 'مدیریت فایل‌ها' . ($project ? ' - ' . $project->name : ''))

@push('styles')
<style>
.file-manager {
    height: calc(100vh - 250px);
    display: flex;
    flex-direction: column;
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.file-manager-header {
    background: #fff;
    border-bottom: 1px solid #dee2e6;
    padding: 15px;
}

.toolbar {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.toolbar-group {
    display: flex;
    gap: 5px;
    align-items: center;
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 8px 12px;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    font-size: 14px;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 3px;
    transition: background 0.2s;
}

.breadcrumb-item:hover {
    background: #e9ecef;
}

.breadcrumb-separator {
    color: #6c757d;
    margin: 0 5px;
}

.file-manager-body {
    flex: 1;
    display: flex;
    overflow: hidden;
}

.sidebar {
    width: 250px;
    background: #fff;
    border-right: 1px solid #dee2e6;
    overflow-y: auto;
}

.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.content-area {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #fff;
}

.file-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 15px;
    padding: 10px;
}

.file-item, .folder-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px 10px;
    border: 2px solid transparent;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
    user-select: none;
}

.file-item:hover, .folder-item:hover {
    background: #f8f9fa;
    border-color: #007bff;
}

.file-item.selected, .folder-item.selected {
    background: #e3f2fd;
    border-color: #2196f3;
}

.file-icon, .folder-icon {
    font-size: 48px;
    margin-bottom: 8px;
    color: #495057;
}

.folder-icon {
    color: #ffc107;
}

.file-name {
    font-size: 12px;
    text-align: center;
    word-break: break-word;
    max-width: 100%;
    line-height: 1.3;
}

.file-size {
    font-size: 10px;
    color: #6c757d;
    margin-top: 2px;
}

.empty-folder {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-folder i {
    font-size: 64px;
    margin-bottom: 20px;
    display: block;
}

.status-bar {
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
    padding: 8px 15px;
    font-size: 12px;
    color: #6c757d;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Responsive */
@media (max-width: 768px) {
    .file-manager {
        height: calc(100vh - 200px);
    }

    .file-manager-body {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        max-height: 200px;
    }

    .file-grid {
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 10px;
    }

    .toolbar {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }

    .toolbar-group {
        justify-content: center;
    }

    .breadcrumb-nav {
        font-size: 12px;
        overflow-x: auto;
        white-space: nowrap;
    }
}

/* Additional Styles for better integration */
.content-wrapper {
    background: #f8f9fa;
    min-height: 100vh;
}

.page-header {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.page-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin-bottom: 0;
}

.breadcrumb-item a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: #6c757d;
}

/* Enhanced File Manager Styles */
.file-manager {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    border: 1px solid #e9ecef;
}

.file-manager-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-bottom: none;
}

.file-manager-header .toolbar {
    margin-bottom: 15px;
}

.file-manager-header .toolbar-group {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
}

.file-manager-header .toolbar-group .btn {
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    backdrop-filter: blur(10px);
}

.file-manager-header .toolbar-group .btn:hover {
    background: rgba(255,255,255,0.3);
    border-color: rgba(255,255,255,0.4);
}

.file-manager-header .toolbar-group .btn:disabled {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.2);
    opacity: 0.6;
}

.file-manager-header .search-box {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
    backdrop-filter: blur(10px);
}

.file-manager-header .search-box::placeholder {
    color: rgba(255,255,255,0.7);
}

.file-manager-header .breadcrumb-nav {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
}

.file-manager-header .breadcrumb-item {
    color: rgba(255,255,255,0.9);
}

.file-manager-header .breadcrumb-item:hover {
    background: rgba(255,255,255,0.2);
    color: white;
}

.file-manager-header .breadcrumb-separator {
    color: rgba(255,255,255,0.6);
}

.file-manager-body {
    background: #f8f9fa;
}

.sidebar {
    background: white;
    border-right: 1px solid #e9ecef;
    box-shadow: 2px 0 10px rgba(0,0,0,0.05);
}

.sidebar .list-group-item {
    border: none;
    border-radius: 8px;
    margin-bottom: 5px;
    transition: all 0.2s ease;
}

.sidebar .list-group-item:hover {
    background: #f8f9fa;
    transform: translateX(5px);
}

.sidebar .list-group-item.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.main-content {
    background: white;
}

.content-area {
    background: white;
    padding: 25px;
}

.file-grid {
    gap: 20px;
    padding: 15px;
}

.file-item, .folder-item {
    background: white;
    border: 2px solid transparent;
    border-radius: 12px;
    padding: 20px 15px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
}

.file-item::before, .folder-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.file-item:hover::before, .folder-item:hover::before {
    transform: scaleX(1);
}

.file-item:hover, .folder-item:hover {
    background: #f8f9fa;
    border-color: #667eea;
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.file-item.selected, .folder-item.selected {
    background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
    border-color: #667eea;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.2);
}

.file-icon, .folder-icon {
    font-size: 48px;
    margin-bottom: 12px;
    transition: all 0.3s ease;
}

.file-item:hover .file-icon, .folder-item:hover .folder-icon {
    transform: scale(1.1);
}

.file-name {
    font-size: 13px;
    font-weight: 600;
    color: #2c3e50;
    text-align: center;
    line-height: 1.4;
    margin-bottom: 5px;
}

.file-size {
    font-size: 11px;
    color: #6c757d;
    text-align: center;
    font-weight: 500;
}

.empty-folder {
    text-align: center;
    padding: 80px 20px;
    color: #6c757d;
}

.empty-folder i {
    font-size: 80px;
    margin-bottom: 25px;
    display: block;
    opacity: 0.5;
}

.empty-folder h5 {
    color: #495057;
    margin-bottom: 15px;
    font-weight: 600;
}

.empty-folder p {
    color: #6c757d;
    margin-bottom: 25px;
}

.status-bar {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-top: 1px solid #dee2e6;
    padding: 12px 20px;
    font-size: 13px;
    color: #6c757d;
    font-weight: 500;
}

/* Progress Bar */
.progress {
    height: 8px;
    border-radius: 4px;
    background: #e9ecef;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(90deg, #667eea, #764ba2);
    transition: width 0.3s ease;
}

/* Modal Enhancements */
.modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0;
    border-bottom: none;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.modal-body {
    padding: 25px;
}

.modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 20px 25px;
}

/* Form Controls */
.form-control, .form-select {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 15px;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Buttons */
.btn {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
}

.btn-success:hover {
    background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
    border: none;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c82333 0%, #d91a72 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

.btn-outline-primary {
    border: 2px solid #667eea;
    color: #667eea;
}

.btn-outline-primary:hover {
    background: #667eea;
    border-color: #667eea;
    transform: translateY(-2px);
}

.btn-outline-warning {
    border: 2px solid #ffc107;
    color: #ffc107;
}

.btn-outline-warning:hover {
    background: #ffc107;
    border-color: #ffc107;
    color: #212529;
    transform: translateY(-2px);
}

.btn-outline-danger {
    border: 2px solid #dc3545;
    color: #dc3545;
}

.btn-outline-danger:hover {
    background: #dc3545;
    border-color: #dc3545;
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .file-manager {
        height: calc(100vh - 200px);
    }

    .file-manager-body {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        max-height: 200px;
        border-right: none;
        border-bottom: 1px solid #e9ecef;
    }

    .file-grid {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 15px;
        padding: 10px;
    }

    .file-item, .folder-item {
        padding: 15px 10px;
    }

    .file-icon, .folder-icon {
        font-size: 36px;
    }

    .file-name {
        font-size: 12px;
    }

    .toolbar {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }

    .toolbar-group {
        justify-content: center;
    }

    .breadcrumb-nav {
        font-size: 12px;
        overflow-x: auto;
        white-space: nowrap;
    }
}
</style>
@endpush

@section('content')
<div class="content-wrapper" style="padding: 20px;">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title h3">
                    مدیریت فایل‌ها
                    @if($project)
                        <small class="text-muted">- {{ $project->name }}</small>
                    @endif
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                        @if($project)
                            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">پروژه‌ها</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a></li>
                        @endif
                        <li class="breadcrumb-item active">مدیریت فایل‌ها</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- File Manager -->
    <div class="file-manager" id="fileManagerContainer" data-folder-id="{{ $currentFolder?->id }}">
        <!-- Header with Toolbar -->
        <div class="file-manager-header">
            <div class="toolbar">
                <div class="toolbar-group">
                    <button type="button" class="btn btn-sm btn-primary" id="createFolderBtn">
                        <i class="mdi mdi-folder-plus"></i> پوشه جدید
                    </button>
                    <button type="button" class="btn btn-sm btn-success" id="uploadBtn">
                        <i class="mdi mdi-upload"></i> آپلود فایل
                    </button>
                </div>

                <div class="toolbar-group">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="downloadBtn" disabled>
                        <i class="mdi mdi-download"></i> دانلود
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-warning" id="renameBtn" disabled>
                        <i class="mdi mdi-pencil"></i> تغییر نام
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" id="deleteBtn" disabled>
                        <i class="mdi mdi-delete"></i> حذف
                    </button>
                </div>

                <div class="toolbar-group">
                    <input type="search" class="form-control form-control-sm search-box" id="searchInput" placeholder="جستجو در فایل‌ها...">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="searchBtn">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                </div>
            </div>

            <!-- Breadcrumb Navigation -->
            <div class="breadcrumb-nav" id="breadcrumbNav">
                <div class="breadcrumb-item" data-folder-id="">
                    <i class="mdi mdi-home"></i>
                    <span>{{ $project ? $project->name : 'فایل‌های عمومی' }}</span>
                </div>
                @if($breadcrumb && $breadcrumb->count() > 0)
                    @foreach($breadcrumb as $crumb)
                        <span class="breadcrumb-separator">›</span>
                        <div class="breadcrumb-item" data-folder-id="{{ $crumb['id'] }}">
                            <i class="mdi mdi-folder"></i>
                            <span>{{ $crumb['name'] }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Body -->
        <div class="file-manager-body">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="p-3">
                    <h6 class="mb-3">دسترسی سریع</h6>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('file-manager.index') }}" class="list-group-item list-group-item-action {{ !$project ? 'active' : '' }}">
                            <i class="mdi mdi-folder-home me-2"></i>
                            فایل‌های عمومی
                        </a>
                        @if($project)
                            <a href="{{ route('file-manager.index', $project->id) }}" class="list-group-item list-group-item-action active">
                                <i class="mdi mdi-folder-account me-2"></i>
                                {{ $project->name }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Content Area -->
                <div class="content-area">
                    <div class="file-grid" id="fileGrid">
                        @if($folders->count() > 0 || $files->count() > 0)
                            <!-- Folders -->
                            @foreach($folders as $folder)
                                <div class="folder-item" data-id="{{ $folder->id }}" data-type="folder">
                                    <div class="folder-icon" style="color: {{ $folder->folder_color ?? '#ffc107' }}">
                                        <i class="mdi mdi-folder"></i>
                                    </div>
                                    <div class="file-name">{{ $folder->name }}</div>
                                    <div class="file-size">{{ $folder->children->count() }} آیتم</div>
                                </div>
                            @endforeach

                            <!-- Files -->
                            @foreach($files as $file)
                                <div class="file-item" data-id="{{ $file->id }}" data-type="file">
                                    <div class="file-icon">
                                        <i class="mdi {{ $file->icon }}"></i>
                                    </div>
                                    <div class="file-name">{{ $file->name }}</div>
                                    <div class="file-size">{{ $file->formatted_size }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-folder col-12">
                                <i class="mdi mdi-folder-open-outline"></i>
                                <h5>این پوشه خالی است</h5>
                                <p class="text-muted">فایل یا پوشه‌ای در اینجا وجود ندارد</p>
                                <button type="button" class="btn btn-primary" id="uploadEmptyBtn">
                                    <i class="mdi mdi-upload"></i> آپلود اولین فایل
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Bar -->
        <div class="status-bar">
            <div>
                <span id="itemCount">{{ $folders->count() + $files->count() }} آیتم</span>
            </div>
            <div>
                <span id="currentPath">{{ $currentFolder ? $currentFolder->full_path : ($project ? $project->name : 'فایل‌های عمومی') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Upload Input -->
<input type="file" id="fileInput" multiple style="display: none;">

@include('admin.file-manager.modals')
@endsection

@push('scripts')
@include('admin.file-manager.scripts')
@endpush
