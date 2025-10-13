@extends('admin.layout')

@section('title', 'مدیریت مدارک و فرم‌ها')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">مدیریت مدارک و فرم‌ها</h1>
        <p class="page-subtitle">آپلود، مدیریت و جستجوی فرم‌های آماده</p>
    </div>
    <div>
        <a href="{{ route('panel.documents.index') }}" class="btn btn-light me-2">
            <i class="mdi mdi-view-dashboard me-1"></i>
            داشبورد
        </a>
        <a href="{{ route('panel.documents.create') }}" class="btn btn-primary me-2">
            <i class="mdi mdi-plus me-1"></i>
            افزودن سند جدید
        </a>
        <a href="{{ route('panel.document-categories.index') }}" class="btn btn-outline-primary">
            <i class="mdi mdi-folder-multiple me-1"></i>
            مدیریت دسته‌بندی‌ها
        </a>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('panel.documents.list') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">جستجو</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="عنوان، کد فرم، توضیحات...">
            </div>
            <div class="col-md-3">
                <label for="category_id" class="form-label">دسته‌بندی</label>
                <select class="form-select" id="category_id" name="category_id">
                    <option value="">همه دسته‌بندی‌ها</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @foreach($category->children as $child)
                            <option value="{{ $child->id }}" {{ request('category_id') == $child->id ? 'selected' : '' }}>
                                &nbsp;&nbsp;{{ $child->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="file_type" class="form-label">نوع فایل</label>
                <select class="form-select" id="file_type" name="file_type">
                    <option value="">همه انواع</option>
                    @foreach($fileTypes as $type)
                        <option value="{{ $type }}" {{ request('file_type') == $type ? 'selected' : '' }}>
                            {{ strtoupper($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="sort" class="form-label">مرتب‌سازی</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>جدیدترین</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>محبوب‌ترین</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>عنوان</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>قدیمی‌ترین</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-1">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                    <a href="{{ route('panel.documents.list') }}" class="btn btn-outline-secondary flex-fill" title="پاک کردن فیلترها">
                        <i class="mdi mdi-refresh"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Results Info -->
@if(request()->hasAny(['search', 'category_id', 'file_type', 'tag']))
    <div class="alert alert-info mb-4">
        <i class="mdi mdi-information me-1"></i>
        <strong>نتایج جستجو:</strong>
        {{ $documents->total() }} سند یافت شد
        @if(request('search'))
            برای عبارت "{{ request('search') }}"
        @endif
    </div>
@endif

<!-- Documents Grid -->
<div class="row">
    @forelse($documents as $document)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card document-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="document-icon">
                            <i class="mdi {{ $document->file_icon }}" style="font-size: 2rem; color: {{ $document->category->color ?? '#3b82f6' }};"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('panel.documents.show', $document) }}">
                                    <i class="mdi mdi-eye me-2"></i>مشاهده
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('panel.documents.edit', $document) }}">
                                    <i class="mdi mdi-pencil me-2"></i>ویرایش
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('panel.documents.download', $document) }}">
                                    <i class="mdi mdi-download me-2"></i>دانلود
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('panel.documents.destroy', $document) }}" method="POST"
                                          onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="mdi mdi-delete me-2"></i>حذف
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <h6 class="card-title mb-2">{{ $document->title }}</h6>
                    <p class="card-text text-muted small mb-2">{{ Str::limit($document->description, 80) }}</p>

                    <div class="document-meta mb-3">
                        <div class="d-flex justify-content-between text-muted small">
                            <span><i class="mdi mdi-tag me-1"></i>{{ $document->form_code }}</span>
                            <span><i class="mdi mdi-file me-1"></i>{{ strtoupper($document->file_type) }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mt-1">
                            <span><i class="mdi mdi-folder me-1"></i>{{ $document->category->name }}</span>
                            <span><i class="mdi mdi-weight me-1"></i>{{ $document->file_size_human }}</span>
                        </div>
                    </div>

                    @if($document->tags)
                        <div class="document-tags mb-3">
                            @foreach(array_slice($document->tags, 0, 3) as $tag)
                                <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
                            @endforeach
                            @if(count($document->tags) > 3)
                                <span class="badge bg-secondary">+{{ count($document->tags) - 3 }}</span>
                            @endif
                        </div>
                    @endif

                    <div class="document-stats d-flex justify-content-between text-muted small">
                        <span><i class="mdi mdi-download me-1"></i>{{ $document->download_count }}</span>
                        <span><i class="mdi mdi-eye me-1"></i>{{ $document->view_count }}</span>
                        <span><i class="mdi mdi-clock me-1"></i>{{ $document->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="card-footer bg-transparent">
                    <div class="d-flex gap-2">
                        <a href="{{ route('panel.documents.download', $document) }}"
                           class="btn btn-primary btn-sm flex-fill">
                            <i class="mdi mdi-download me-1"></i>دانلود
                        </a>
                        <a href="{{ route('panel.documents.show', $document) }}"
                           class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="mdi mdi-eye me-1"></i>مشاهده
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="mdi mdi-file-document-outline" style="font-size: 4rem; color: #6c757d;"></i>
                <h4 class="mt-3">هیچ سندی یافت نشد</h4>
                <p class="text-muted">هنوز هیچ سندی آپلود نشده است</p>
                <a href="{{ route('panel.documents.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i>افزودن اولین سند
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($documents->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $documents->appends(request()->query())->links() }}
    </div>
@endif
@endsection

@push('styles')
<style>
.document-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid #e9ecef;
}

.document-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.document-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 8px;
}

.document-meta {
    font-size: 0.85rem;
}

.document-tags .badge {
    font-size: 0.75rem;
}

.document-stats {
    border-top: 1px solid #f1f3f4;
    padding-top: 0.5rem;
}

.card-footer {
    border-top: 1px solid #f1f3f4;
    padding: 1rem;
}
</style>
@endpush
