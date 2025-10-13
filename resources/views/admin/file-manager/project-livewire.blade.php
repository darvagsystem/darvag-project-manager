@extends('admin.layout')

@section('title', 'مدیریت فایل‌های پروژه')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">مدیریت فایل‌های پروژه</h1>
            <p class="page-subtitle">{{ $project->name }}</p>
        </div>
        <div>
            <a href="{{ route('panel.tags.index') }}" class="btn btn-outline-primary me-2">
                <i class="mdi mdi-tag me-1"></i>
                مدیریت تگ‌ها
            </a>
            <a href="{{ route('panel.projects.show', $project) }}" class="btn btn-outline-secondary">
                <i class="mdi mdi-arrow-left me-1"></i>
                بازگشت به پروژه
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="file-manager">
            <div class="file-manager-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">فایل‌های پروژه: {{ $project->name }}</h6>
                    <div>
                        <a href="{{ route('panel.tags.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="mdi mdi-tag me-1"></i>
                            مدیریت تگ‌ها
                        </a>
                    </div>
                </div>

                <!-- Livewire File Manager Component -->
                @livewire('file-manager-component', ['projectId' => $project->id])
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@livewireScripts
@endpush

@push('styles')
@livewireStyles
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
    flex: 1;
    overflow-y: auto;
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
    margin-bottom: 15px;
}

.breadcrumb-nav a {
    color: #007bff;
    text-decoration: none;
    padding: 4px 8px;
    border-radius: 3px;
    transition: background-color 0.2s;
}

.breadcrumb-nav a:hover {
    background: #e9ecef;
}

.breadcrumb-nav a[wire\:click] {
    cursor: pointer;
    user-select: none;
}

.breadcrumb-nav .separator {
    color: #6c757d;
    margin: 0 5px;
}

.file-grid-container {
    width: 100%;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.file-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
    width: 100%;
    max-width: 100%;
    padding: 20px;
}

.folder-item, .file-item {
    position: relative;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 140px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.folder-item:hover, .file-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border-color: #007bff;
}

.folder-icon, .file-icon {
    font-size: 40px;
    margin-bottom: 12px;
    color: #6c757d;
}

.folder-content, .file-download-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    padding-top: 20px;
}

.file-name {
    font-size: 14px;
    font-weight: 600;
    color: #495057;
    margin-bottom: 6px;
    word-break: break-word;
    line-height: 1.3;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.file-original-name {
    font-size: 10px;
    color: #6c757d;
    margin-bottom: 2px;
    font-style: italic;
    opacity: 0.8;
}

.file-size {
    font-size: 10px;
    color: #6c757d;
    margin-top: 2px;
}

.file-date {
    font-size: 9px;
    color: #adb5bd;
    margin-top: 2px;
}

.file-tags {
    margin-top: 4px;
    display: flex;
    flex-wrap: wrap;
    gap: 2px;
}

.tag {
    font-size: 8px;
    padding: 2px 6px;
    border-radius: 10px;
    font-weight: 500;
    white-space: nowrap;
    max-width: 60px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.item-checkbox {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 10;
}

.item-checkbox .form-check-input {
    width: 18px;
    height: 18px;
    border-radius: 4px;
    border: 2px solid #dee2e6;
    background-color: white;
    cursor: pointer;
}

.item-checkbox .form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.file-actions {
    position: absolute;
    top: 8px;
    right: 8px;
    opacity: 0.7;
    transition: opacity 0.3s ease;
    display: flex;
    gap: 2px;
    z-index: 10;
}

.file-item:hover .file-actions,
.folder-item:hover .file-actions {
    opacity: 1;
}

.folder-item .file-actions {
    opacity: 0.7;
}

.file-actions .btn {
    padding: 4px 6px;
    font-size: 10px;
    margin: 0;
    border-radius: 4px;
    transition: all 0.2s ease;
    min-width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.file-actions .btn-outline-warning {
    border: 1px solid #ffc107;
    color: #ffc107;
    background: rgba(255, 193, 7, 0.15);
    font-weight: 500;
}

.file-actions .btn-outline-warning:hover {
    background: #ffc107;
    color: #212529;
    border-color: #ffc107;
    transform: scale(1.05);
    box-shadow: 0 1px 4px rgba(255, 193, 7, 0.3);
}

.file-actions .btn-outline-primary {
    border: 1px solid #007bff;
    color: #007bff;
    background: rgba(0, 123, 255, 0.15);
    font-weight: 500;
}

.file-actions .btn-outline-primary:hover {
    background: #007bff;
    color: white;
    border-color: #007bff;
    transform: scale(1.05);
    box-shadow: 0 1px 4px rgba(0, 123, 255, 0.3);
}

.file-actions .btn-outline-danger {
    border: 1px solid #dc3545;
    color: #dc3545;
    background: rgba(220, 53, 69, 0.15);
    font-weight: 500;
}

.file-actions .btn-outline-danger:hover {
    background: #dc3545;
    color: white;
    border-color: #dc3545;
    transform: scale(1.05);
    box-shadow: 0 1px 4px rgba(220, 53, 69, 0.3);
}

.empty-folder {
    text-align: center;
    padding: 80px 20px;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.empty-state-content {
    max-width: 500px;
    width: 100%;
    margin: 0 auto;
}

@media (max-width: 768px) {
    .file-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 15px;
        padding: 15px;
    }

    .folder-item, .file-item {
        min-height: 120px;
        padding: 15px;
    }

    .folder-icon, .file-icon {
        font-size: 32px;
        margin-bottom: 8px;
    }

    .file-name {
        font-size: 12px;
    }

    .empty-folder {
        padding: 40px 15px;
    }

    .file-grid-container {
        min-height: 300px;
    }

    .empty-state-actions {
        flex-direction: column;
        gap: 10px;
    }

    .empty-state-actions .btn {
        width: 100%;
        margin: 0 !important;
    }
}

.empty-state-icon {
    position: relative;
    display: inline-block;
    margin-bottom: 30px;
}

.empty-state-icon i {
    font-size: 120px;
    color: #e9ecef;
    display: block;
    position: relative;
    z-index: 1;
}

.empty-state-icon::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 140px;
    height: 140px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 50%;
    z-index: 0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.empty-state-title {
    color: #495057;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 15px;
    letter-spacing: -0.5px;
}

.empty-state-description {
    color: #6c757d;
    font-size: 1.1rem;
    margin-bottom: 35px;
    line-height: 1.6;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.empty-state-actions {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.empty-state-actions .btn {
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.empty-state-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.empty-state-actions .btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
}

.empty-state-actions .btn-outline-success {
    border: 2px solid #28a745;
    color: #28a745;
}

.empty-state-actions .btn-outline-success:hover {
    background: #28a745;
    color: white;
}

.empty-state-actions .btn-outline-primary {
    border: 2px solid #007bff;
    color: #007bff;
}

.empty-state-actions .btn-outline-primary:hover {
    background: #007bff;
    color: white;
}

.select-all-inline {
    margin-left: 15px;
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}

.select-all-inline .form-check {
    margin: 0;
}

.select-all-inline .form-check-label {
    font-size: 14px;
    font-weight: 500;
    color: #495057;
    cursor: pointer;
}

.tag-selection {
    max-height: 150px;
    overflow-y: auto;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 10px;
    background: #f8f9fa;
}

.tag-selection .form-check {
    margin-bottom: 8px;
}

.tag-selection .form-check-label {
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
}

.tag-selection .form-check-input {
    margin-right: 8px;
}

/* Upload Modal Styles */
.upload-modal .modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

.upload-modal .modal-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 20px 25px;
    border: none;
}

.upload-icon {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.upload-area {
    margin: 20px 0;
}

.upload-zone {
    border: 3px dashed #dee2e6;
    border-radius: 12px;
    padding: 60px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8f9fa;
    position: relative;
    overflow: hidden;
}

.upload-zone:hover {
    border-color: #007bff;
    background: #e3f2fd;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,123,255,0.15);
}

.upload-zone::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(0,123,255,0.1) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.upload-zone:hover::before {
    transform: translateX(100%);
}

.upload-zone-icon {
    font-size: 48px;
    color: #007bff;
    margin-bottom: 15px;
    display: block;
}

.upload-zone-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 1.1rem;
}

.upload-zone-text {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.upload-modal .form-label {
    color: #495057;
    font-size: 0.95rem;
}

.upload-modal .form-control {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.upload-modal .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.upload-modal .modal-footer {
    border: none;
    padding: 20px 25px;
    background: #f8f9fa;
    border-radius: 0 0 12px 12px;
}

.upload-modal .btn {
    border-radius: 8px;
    padding: 10px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.upload-modal .btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
}

.upload-modal .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,123,255,0.3);
}

.upload-modal .btn-outline-secondary:hover {
    background: #6c757d;
    border-color: #6c757d;
    color: white;
}

/* Action Buttons Styles */
.action-btn {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.action-btn.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
}

.action-btn.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    border: none;
}

.action-btn.btn-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    border: none;
}

.action-btn.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
}

.action-btn.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
}

.action-btn.btn-outline-warning {
    border: 2px solid #ffc107;
    color: #ffc107;
    background: transparent;
}

.action-btn.btn-outline-warning:hover {
    background: #ffc107;
    color: #212529;
    border-color: #ffc107;
}
</style>
@endpush
