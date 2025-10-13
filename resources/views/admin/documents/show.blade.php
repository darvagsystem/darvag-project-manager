@extends('admin.layout')

@section('title', $document->title)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $document->title }}</h1>
        <p class="page-subtitle">کد فرم: {{ $document->form_code }}</p>
    </div>
    <div>
        <a href="{{ route('panel.documents.index') }}" class="btn btn-light me-2">
            <i class="mdi mdi-arrow-right me-1"></i>
            بازگشت به داشبورد
        </a>
        <a href="{{ route('panel.documents.list') }}" class="btn btn-outline-light me-2">
            <i class="mdi mdi-view-list me-1"></i>
            لیست مدارک
        </a>
        <a href="{{ route('panel.documents.edit', $document) }}" class="btn btn-outline-primary me-2">
            <i class="mdi mdi-pencil me-1"></i>
            ویرایش
        </a>
        <a href="{{ route('panel.documents.download', $document) }}" class="btn btn-primary">
            <i class="mdi mdi-download me-1"></i>
            دانلود
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Document Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">جزئیات سند</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <label class="info-label">عنوان:</label>
                            <span class="info-value">{{ $document->title }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <label class="info-label">کد فرم:</label>
                            <span class="info-value">{{ $document->form_code }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <label class="info-label">دسته‌بندی:</label>
                            <span class="info-value">
                                <span class="badge" style="background-color: {{ $document->category->color }}; color: white;">
                                    <i class="{{ $document->category->icon }} me-1"></i>
                                    {{ $document->category->name }}
                                </span>
                            </span>
                        </div>
                        <div class="info-item mb-3">
                            <label class="info-label">نوع فایل:</label>
                            <span class="info-value">
                                <i class="mdi {{ $document->file_icon }} me-1"></i>
                                {{ strtoupper($document->file_type) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <label class="info-label">حجم فایل:</label>
                            <span class="info-value">{{ $document->file_size_human }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <label class="info-label">تعداد دانلود:</label>
                            <span class="info-value">{{ number_format($document->download_count) }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <label class="info-label">تعداد مشاهده:</label>
                            <span class="info-value">{{ number_format($document->view_count) }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <label class="info-label">وضعیت:</label>
                            <span class="info-value">
                                @if($document->is_active)
                                    <span class="badge bg-success">فعال</span>
                                @else
                                    <span class="badge bg-danger">غیرفعال</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                @if($document->description)
                    <div class="info-item">
                        <label class="info-label">توضیحات:</label>
                        <div class="info-value mt-2">
                            <p class="mb-0">{{ $document->description }}</p>
                        </div>
                    </div>
                @endif

                @if($document->tags)
                    <div class="info-item mt-3">
                        <label class="info-label">برچسب‌ها:</label>
                        <div class="info-value mt-2">
                            @foreach($document->tags as $tag)
                                <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Version History -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">تاریخچه نسخه‌ها</h5>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadVersionModal">
                    <i class="mdi mdi-upload me-1"></i>
                    آپلود نسخه جدید
                </button>
            </div>
            <div class="card-body">
                @forelse($document->versions as $version)
                    <div class="version-item {{ $version->is_current ? 'current' : '' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="version-info">
                                <h6 class="version-title">
                                    نسخه {{ $version->version_number }}
                                    @if($version->version_name)
                                        - {{ $version->version_name }}
                                    @endif
                                    @if($version->is_current)
                                        <span class="badge bg-primary ms-2">نسخه فعلی</span>
                                    @endif
                                </h6>
                                @if($version->changelog)
                                    <p class="version-changelog">{{ $version->changelog }}</p>
                                @endif
                                <div class="version-meta">
                                    <small class="text-muted">
                                        <i class="mdi mdi-account me-1"></i>
                                        {{ $version->creator->name }}
                                        <i class="mdi mdi-clock ms-3 me-1"></i>
                                        {{ $version->created_at->format('Y/m/d H:i') }}
                                        <i class="mdi mdi-weight ms-3 me-1"></i>
                                        {{ $version->file_size_human }}
                                    </small>
                                </div>
                            </div>
                            <div class="version-actions">
                                <a href="{{ route('panel.documents.download-version', [$document, $version]) }}"
                                   class="btn btn-sm btn-outline-success me-2">
                                    <i class="mdi mdi-download me-1"></i>
                                    دانلود
                                </a>
                                @if(!$version->is_current)
                                    <form action="{{ route('panel.documents.set-current-version', [$document, $version]) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="mdi mdi-check me-1"></i>
                                            تنظیم به عنوان فعلی
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="mdi mdi-file-document-outline" style="font-size: 3rem; color: #6c757d;"></i>
                        <p class="text-muted mt-2">هیچ نسخه‌ای یافت نشد</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">عملیات سریع</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('panel.documents.download', $document) }}" class="btn btn-primary">
                        <i class="mdi mdi-download me-1"></i>
                        دانلود سند
                    </a>
                    <a href="{{ route('panel.documents.edit', $document) }}" class="btn btn-outline-primary">
                        <i class="mdi mdi-pencil me-1"></i>
                        ویرایش اطلاعات
                    </a>
                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#uploadVersionModal">
                        <i class="mdi mdi-upload me-1"></i>
                        آپلود نسخه جدید
                    </button>
                </div>
            </div>
        </div>

        <!-- Document Stats -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">آمار</h5>
            </div>
            <div class="card-body">
                <div class="stats-item">
                    <div class="stats-icon">
                        <i class="mdi mdi-download"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ number_format($document->download_count) }}</div>
                        <div class="stats-label">دانلود</div>
                    </div>
                </div>
                <div class="stats-item">
                    <div class="stats-icon">
                        <i class="mdi mdi-eye"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ number_format($document->view_count) }}</div>
                        <div class="stats-label">مشاهده</div>
                    </div>
                </div>
                <div class="stats-item">
                    <div class="stats-icon">
                        <i class="mdi mdi-file-document-multiple"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $document->versions->count() }}</div>
                        <div class="stats-label">نسخه</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Info -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">اطلاعات</h5>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <label class="info-label">ایجاد شده توسط:</label>
                    <span class="info-value">{{ $document->creator->name }}</span>
                </div>
                <div class="info-item">
                    <label class="info-label">تاریخ ایجاد:</label>
                    <span class="info-value">{{ $document->created_at->format('Y/m/d H:i') }}</span>
                </div>
                @if($document->updater)
                    <div class="info-item">
                        <label class="info-label">آخرین ویرایش:</label>
                        <span class="info-value">{{ $document->updater->name }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">تاریخ ویرایش:</label>
                        <span class="info-value">{{ $document->updated_at->format('Y/m/d H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Upload Version Modal -->
<div class="modal fade" id="uploadVersionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">آپلود نسخه جدید</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('panel.documents.upload-version', $document) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="file" class="form-label">فایل جدید *</label>
                        <input type="file" class="form-control" id="file" name="file" required
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar">
                    </div>
                    <div class="form-group mb-3">
                        <label for="version_number" class="form-label">شماره نسخه *</label>
                        <input type="text" class="form-control" id="version_number" name="version_number"
                               required placeholder="مثال: 1.1">
                    </div>
                    <div class="form-group mb-3">
                        <label for="version_name" class="form-label">نام نسخه</label>
                        <input type="text" class="form-control" id="version_name" name="version_name"
                               placeholder="مثال: نسخه بهبود یافته">
                    </div>
                    <div class="form-group">
                        <label for="changelog" class="form-label">تغییرات</label>
                        <textarea class="form-control" id="changelog" name="changelog" rows="3"
                                  placeholder="توضیح تغییرات انجام شده..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">آپلود نسخه</button>
                </div>
            </form>
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

.version-item {
    padding: 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    margin-bottom: 1rem;
    background: #f9fafb;
}

.version-item.current {
    border-color: #3b82f6;
    background: #eff6ff;
}

.version-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #1f2937;
}

.version-changelog {
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.version-meta {
    font-size: 0.875rem;
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

.badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

.version-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: wrap;
}

.version-actions .btn {
    white-space: nowrap;
}
</style>
@endpush
