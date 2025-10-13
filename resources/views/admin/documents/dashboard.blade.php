@extends('admin.layout')

@section('title', 'داشبورد مدیریت مدارک')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">داشبورد مدیریت مدارک</h1>
        <p class="page-subtitle">نمای کلی از سیستم مدیریت مدارک و فرم‌ها</p>
    </div>
    <div>
        <a href="{{ route('panel.documents.create') }}" class="btn btn-primary me-2">
            <i class="mdi mdi-plus me-1"></i>
            افزودن سند جدید
        </a>
        <a href="{{ route('panel.documents.list') }}" class="btn btn-outline-primary">
            <i class="mdi mdi-view-list me-1"></i>
            مشاهده همه مدارک
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary">
                        <i class="mdi mdi-file-document-multiple"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ number_format($stats['total_documents']) }}</div>
                        <div class="stats-label">کل مدارک</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success">
                        <i class="mdi mdi-folder-multiple"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ number_format($stats['total_categories']) }}</div>
                        <div class="stats-label">دسته‌بندی‌ها</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning">
                        <i class="mdi mdi-download"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ number_format($stats['total_downloads']) }}</div>
                        <div class="stats-label">کل دانلودها</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info">
                        <i class="mdi mdi-eye"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ number_format($stats['total_views']) }}</div>
                        <div class="stats-label">کل مشاهده‌ها</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Documents -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">مدارک اخیر</h5>
                <a href="{{ route('panel.documents.list') }}" class="btn btn-sm btn-outline-primary">مشاهده همه</a>
            </div>
            <div class="card-body">
                @forelse($recentDocuments as $document)
                    <div class="document-item">
                        <div class="d-flex align-items-center">
                            <div class="document-icon">
                                <i class="mdi {{ $document->file_icon }}" style="color: {{ $document->category->color }};"></i>
                            </div>
                            <div class="document-info flex-grow-1">
                                <h6 class="document-title">
                                    <a href="{{ route('panel.documents.show', $document) }}">{{ $document->title }}</a>
                                </h6>
                                <div class="document-meta">
                                    <span class="badge" style="background-color: {{ $document->category->color }}; color: white;">
                                        {{ $document->category->name }}
                                    </span>
                                    <span class="text-muted">{{ $document->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="document-actions">
                                <a href="{{ route('panel.documents.download', $document) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="mdi mdi-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="mdi mdi-file-document-outline" style="font-size: 3rem; color: #6c757d;"></i>
                        <p class="text-muted mt-2">هیچ سندی یافت نشد</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Popular Documents -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">محبوب‌ترین مدارک</h5>
                <a href="{{ route('panel.documents.list', ['sort' => 'popular']) }}" class="btn btn-sm btn-outline-primary">مشاهده همه</a>
            </div>
            <div class="card-body">
                @forelse($popularDocuments as $document)
                    <div class="document-item">
                        <div class="d-flex align-items-center">
                            <div class="document-icon">
                                <i class="mdi {{ $document->file_icon }}" style="color: {{ $document->category->color }};"></i>
                            </div>
                            <div class="document-info flex-grow-1">
                                <h6 class="document-title">
                                    <a href="{{ route('panel.documents.show', $document) }}">{{ $document->title }}</a>
                                </h6>
                                <div class="document-meta">
                                    <span class="badge" style="background-color: {{ $document->category->color }}; color: white;">
                                        {{ $document->category->name }}
                                    </span>
                                    <span class="text-muted">
                                        <i class="mdi mdi-download me-1"></i>{{ $document->download_count }}
                                        <i class="mdi mdi-eye ms-3 me-1"></i>{{ $document->view_count }}
                                    </span>
                                </div>
                            </div>
                            <div class="document-actions">
                                <a href="{{ route('panel.documents.download', $document) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="mdi mdi-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="mdi mdi-file-document-outline" style="font-size: 3rem; color: #6c757d;"></i>
                        <p class="text-muted mt-2">هیچ سندی یافت نشد</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Documents by Category -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">مدارک بر اساس دسته‌بندی</h5>
                <a href="{{ route('panel.document-categories.index') }}" class="btn btn-sm btn-outline-primary">مدیریت دسته‌بندی‌ها</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($documentsByCategory as $category)
                        <div class="col-md-6 mb-3">
                            <div class="category-item">
                                <div class="d-flex align-items-center">
                                    <div class="category-icon" style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                                        <i class="{{ $category->icon }}"></i>
                                    </div>
                                    <div class="category-info flex-grow-1">
                                        <h6 class="category-name">{{ $category->name }}</h6>
                                        <div class="category-meta">
                                            <span class="badge bg-light text-dark">{{ $category->documents_count }} سند</span>
                                        </div>
                                    </div>
                                    <div class="category-actions">
                                        <a href="{{ route('panel.documents.list', ['category_id' => $category->id]) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4">
                            <i class="mdi mdi-folder-outline" style="font-size: 3rem; color: #6c757d;"></i>
                            <p class="text-muted mt-2">هیچ دسته‌بندی‌ای یافت نشد</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Documents by File Type -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">توزیع نوع فایل</h5>
            </div>
            <div class="card-body">
                @forelse($documentsByFileType as $fileType)
                    <div class="file-type-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="mdi {{ $fileType->file_type === 'pdf' ? 'mdi-file-pdf-box' : ($fileType->file_type === 'docx' ? 'mdi-file-word-box' : 'mdi-file-document-outline') }} me-2"></i>
                                <span class="file-type-name">{{ strtoupper($fileType->file_type) }}</span>
                            </div>
                            <span class="badge bg-primary">{{ $fileType->count }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="mdi mdi-file-outline" style="font-size: 2rem; color: #6c757d;"></i>
                        <p class="text-muted mt-2">هیچ فایلی یافت نشد</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">فعالیت‌های اخیر</h5>
            </div>
            <div class="card-body">
                @forelse($recentActivity as $activity)
                    <div class="activity-item">
                        <div class="d-flex align-items-center">
                            <div class="activity-icon">
                                @if($activity->action === 'created')
                                    <i class="mdi mdi-plus-circle text-success"></i>
                                @elseif($activity->action === 'updated')
                                    <i class="mdi mdi-pencil-circle text-warning"></i>
                                @elseif($activity->action === 'downloaded')
                                    <i class="mdi mdi-download-circle text-primary"></i>
                                @else
                                    <i class="mdi mdi-information-circle text-info"></i>
                                @endif
                            </div>
                            <div class="activity-content flex-grow-1">
                                <p class="activity-text mb-0">{{ $activity->description }}</p>
                                <small class="text-muted">
                                    توسط {{ $activity->user->name ?? 'سیستم' }} - {{ $activity->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="mdi mdi-history" style="font-size: 3rem; color: #6c757d;"></i>
                        <p class="text-muted mt-2">هیچ فعالیتی یافت نشد</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.stats-card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 1rem;
    color: white;
    font-size: 1.5rem;
}

.stats-content {
    flex: 1;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
}

.stats-label {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.document-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.document-item:last-child {
    border-bottom: none;
}

.document-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 1rem;
    background: #f8f9fa;
    font-size: 1.25rem;
}

.document-info {
    flex: 1;
}

.document-title {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.document-title a {
    color: #1f2937;
    text-decoration: none;
}

.document-title a:hover {
    color: #3b82f6;
}

.document-meta {
    font-size: 0.8rem;
}

.category-item {
    padding: 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: #f9fafb;
    transition: all 0.2s ease;
}

.category-item:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}

.category-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 1rem;
    font-size: 1.25rem;
}

.category-name {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #1f2937;
}

.file-type-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.file-type-item:last-child {
    border-bottom: none;
}

.file-type-name {
    font-weight: 500;
    color: #374151;
}

.activity-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 1rem;
    background: #f8f9fa;
    font-size: 1.25rem;
}

.activity-content {
    flex: 1;
}

.activity-text {
    font-size: 0.9rem;
    color: #374151;
    margin-bottom: 0.25rem;
}

.badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

.bg-primary { background-color: #3b82f6 !important; }
.bg-success { background-color: #10b981 !important; }
.bg-warning { background-color: #f59e0b !important; }
.bg-info { background-color: #06b6d4 !important; }
</style>
@endpush
