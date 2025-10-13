@extends('admin.layout')

@section('title', 'مشاهده دسته‌بندی: ' . $category->name)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $category->name }}</h1>
        <p class="page-subtitle">کد: {{ $category->code }} | مسیر: {{ $category->path }}</p>
    </div>
    <div>
        <a href="{{ route('panel.document-categories.index') }}" class="btn btn-light me-2">
            <i class="mdi mdi-arrow-right me-1"></i>
            بازگشت
        </a>
        <a href="{{ route('panel.document-categories.edit', $category) }}" class="btn btn-outline-primary me-2">
            <i class="mdi mdi-pencil me-1"></i>
            ویرایش
        </a>
        <a href="{{ route('panel.documents.index') }}" class="btn btn-outline-light">
            <i class="mdi mdi-view-dashboard me-1"></i>
            داشبورد مدارک
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Category Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">اطلاعات دسته‌بندی</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">نام دسته‌بندی:</label>
                            <span class="info-value">{{ $category->name }}</span>
                        </div>
                        <div class="info-item">
                            <label class="info-label">کد دسته‌بندی:</label>
                            <span class="info-value badge bg-primary">{{ $category->code }}</span>
                        </div>
                        <div class="info-item">
                            <label class="info-label">وضعیت:</label>
                            <span class="badge bg-{{ $category->status_color }}">{{ $category->status_text }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">ترتیب نمایش:</label>
                            <span class="info-value">{{ $category->sort_order }}</span>
                        </div>
                        <div class="info-item">
                            <label class="info-label">تاریخ ایجاد:</label>
                            <span class="info-value">{{ $category->created_at->format('Y/m/d H:i') }}</span>
                        </div>
                    </div>
                </div>

                @if($category->description)
                    <div class="info-item mt-3">
                        <label class="info-label">توضیحات:</label>
                        <div class="info-value">{{ $category->description }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Documents in this category -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">مدارک این دسته‌بندی</h5>
                <a href="{{ route('panel.documents.create', ['category_id' => $category->id]) }}" class="btn btn-sm btn-primary">
                    <i class="mdi mdi-plus me-1"></i>
                    افزودن سند
                </a>
            </div>
            <div class="card-body">
                @if($category->documents->count() > 0)
                    <div class="documents-list">
                        @foreach($category->documents as $document)
                            <div class="document-item">
                                <div class="d-flex align-items-center">
                                    <div class="document-icon" style="color: {{ $category->color }};">
                                        <i class="{{ $document->file_icon }}"></i>
                                    </div>
                                    <div class="document-info flex-grow-1">
                                        <h6 class="document-title">
                                            <a href="{{ route('panel.documents.show', $document) }}">{{ $document->title }}</a>
                                        </h6>
                                        <div class="document-meta">
                                            <span class="badge bg-light text-dark me-2">{{ $document->form_code }}</span>
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
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="mdi mdi-file-document-outline" style="font-size: 3rem; color: #6c757d;"></i>
                        <p class="text-muted mt-2">هیچ سندی در این دسته‌بندی یافت نشد</p>
                        <a href="{{ route('panel.documents.create', ['category_id' => $category->id]) }}" class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i>
                            افزودن اولین سند
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Category Appearance -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">ظاهر دسته‌بندی</h5>
            </div>
            <div class="card-body text-center">
                <div class="category-preview">
                    <div class="category-icon-large" style="background-color: {{ $category->color }};">
                        <i class="{{ $category->icon }}"></i>
                    </div>
                    <h4 class="category-name-preview">{{ $category->name }}</h4>
                    <p class="text-muted">رنگ: <span style="color: {{ $category->color }};">{{ $category->color }}</span></p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">آمار</h5>
            </div>
            <div class="card-body">
                <div class="stats-item">
                    <div class="stats-icon">
                        <i class="mdi mdi-file-document-multiple"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $category->documents->count() }}</div>
                        <div class="stats-label">مدارک</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">عملیات سریع</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('panel.document-categories.edit', $category) }}" class="btn btn-primary">
                        <i class="mdi mdi-pencil me-1"></i>
                        ویرایش دسته‌بندی
                    </a>
                    <a href="{{ route('panel.documents.create', ['category_id' => $category->id]) }}" class="btn btn-outline-primary">
                        <i class="mdi mdi-plus me-1"></i>
                        افزودن سند جدید
                    </a>
                    <button type="button" class="btn btn-outline-{{ $category->is_active ? 'warning' : 'success' }}"
                            onclick="toggleStatus({{ $category->id }})">
                        <i class="mdi mdi-{{ $category->is_active ? 'pause' : 'play' }} me-1"></i>
                        {{ $category->is_active ? 'غیرفعال کردن' : 'فعال کردن' }}
                    </button>
                    <a href="{{ route('panel.document-categories.index') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-arrow-right me-1"></i>
                        بازگشت به لیست
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.info-item {
    margin-bottom: 1rem;
}

.info-label {
    font-weight: 600;
    color: #374151;
    display: block;
    margin-bottom: 0.25rem;
}

.info-value {
    color: #6b7280;
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

.category-preview {
    padding: 2rem;
}

.category-icon-large {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 2rem;
}

.category-name-preview {
    margin-bottom: 0.5rem;
    color: #1f2937;
}

.stats-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.stats-item:last-child {
    border-bottom: none;
}

.stats-icon {
    width: 40px;
    height: 40px;
    background: #f3f4f6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 1rem;
    color: #6b7280;
}

.stats-content {
    flex: 1;
}

.stats-number {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
}

.stats-label {
    font-size: 0.875rem;
    color: #6b7280;
}

.subcategory-item {
    padding: 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: #f9fafb;
    transition: all 0.2s ease;
}

.subcategory-item:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}

.subcategory-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 1rem;
    color: white;
    font-size: 1.25rem;
}

.subcategory-name {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #1f2937;
}

.subcategory-name a {
    color: #1f2937;
    text-decoration: none;
}

.subcategory-name a:hover {
    color: #3b82f6;
}

.subcategory-meta {
    font-size: 0.8rem;
}
</style>
@endpush

@push('scripts')
<script>
function toggleStatus(categoryId) {
    fetch(`/panel/document-categories/${categoryId}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('خطا در تغییر وضعیت دسته‌بندی');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در تغییر وضعیت دسته‌بندی');
    });
}
</script>
@endpush
