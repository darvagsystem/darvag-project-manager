@extends('admin.layout')

@section('title', 'فایل‌های تگ - ' . $tag->name)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">فایل‌های تگ: {{ $tag->name }}</h1>
            <p class="page-subtitle">فایل‌هایی که دارای تگ "{{ $tag->name }}" هستند</p>
        </div>
        <div>
            <a href="{{ route('tags.index') }}" class="btn btn-secondary">
                <i class="mdi mdi-arrow-left"></i> بازگشت به تگ‌ها
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}; border: 1px solid {{ $tag->color }}40; font-size: 14px; padding: 8px 16px;">
                            {{ $tag->name }}
                        </span>
                        <div class="color-preview" style="width: 30px; height: 20px; background-color: {{ $tag->color }}; border-radius: 4px; border: 1px solid #ddd;"></div>
                        <span class="text-muted">{{ $files->total() }} فایل</span>
                    </div>
                    @if($tag->description)
                        <div class="text-muted">
                            <i class="mdi mdi-information-outline me-1"></i>
                            {{ $tag->description }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($files->count() > 0)
                    <!-- Bulk Actions -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllFiles">
                                <label class="form-check-label" for="selectAllFiles">
                                    انتخاب همه
                                </label>
                            </div>
                            <span id="selectedCount" class="badge bg-primary" style="display: none;">0 فایل انتخاب شده</span>
                        </div>
                        <div id="bulkActions" style="display: none;">
                            <button type="button" class="btn btn-success btn-sm" onclick="mergeSelectedFiles()">
                                <i class="mdi mdi-file-pdf me-1"></i>
                                ادغام در PDF
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" onclick="downloadSelectedFiles()">
                                <i class="mdi mdi-download me-1"></i>
                                دانلود دسته‌ای
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearSelection()">
                                <i class="mdi mdi-close me-1"></i>
                                لغو انتخاب
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>انتخاب</th>
                                    <th>نام فایل</th>
                                    <th>نوع</th>
                                    <th>حجم</th>
                                    <th>پروژه</th>
                                    <th>آپلود شده توسط</th>
                                    <th>تاریخ آپلود</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                    <tr>
                                        <td>
                                            @if(!$file->is_folder)
                                                <input type="checkbox" class="form-check-input file-checkbox"
                                                       value="{{ $file->id }}" data-file-name="{{ $file->name }}">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="mdi {{ $file->is_folder ? 'mdi-folder' : 'mdi-file' }} me-2"
                                                   style="color: {{ $file->is_folder ? '#ff9800' : '#6c757d' }};"></i>
                                                <div>
                                                    <div class="fw-semibold">{{ $file->display_name ?: $file->name }}</div>
                                                    @if($file->display_name && $file->display_name !== $file->name)
                                                        <small class="text-muted">{{ $file->name }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($file->is_folder)
                                                <span class="badge bg-warning">پوشه</span>
                                            @else
                                                <span class="badge bg-info">{{ $file->mime_type ?? 'فایل' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($file->is_folder)
                                                <span class="text-muted">-</span>
                                            @else
                                                {{ $file->size ? number_format($file->size / 1024, 1) . ' KB' : '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($file->project)
                                                <a href="{{ route('projects.show', $file->project->id) }}" class="text-decoration-none">
                                                    {{ $file->project->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">عمومی</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($file->uploader)
                                                {{ $file->uploader->name }}
                                            @else
                                                <span class="text-muted">نامشخص</span>
                                            @endif
                                        </td>
                                        <td>{{ $file->created_at->format('Y/m/d H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if(!$file->is_folder)
                                                    <a href="{{ route('file-manager.download', $file->id) }}"
                                                       class="btn btn-sm btn-outline-success" title="دانلود">
                                                        <i class="mdi mdi-download"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('file-manager.index', ['tag' => $tag->id]) }}"
                                                   class="btn btn-sm btn-outline-primary" title="مشاهده در فایل منیجر">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $files->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="mdi mdi-file-outline" style="font-size: 64px; color: #6c757d;"></i>
                        <h5 class="mt-3">هیچ فایلی با این تگ وجود ندارد</h5>
                        <p class="text-muted">فایل‌هایی که دارای تگ "{{ $tag->name }}" هستند در اینجا نمایش داده می‌شوند</p>
                        <a href="{{ route('file-manager.index') }}" class="btn btn-primary">
                            <i class="mdi mdi-folder-open me-1"></i>
                            باز کردن فایل منیجر
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.color-preview {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.table th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    border-radius: 4px;
    margin-left: 2px;
}

.badge {
    font-size: 0.75em;
    padding: 0.5em 0.75em;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
}

.page-header {
    margin-bottom: 2rem;
}

.file-checkbox {
    transform: scale(1.2);
}

#bulkActions {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }

    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAllFiles');
    const fileCheckboxes = document.querySelectorAll('.file-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    const bulkActions = document.getElementById('bulkActions');

    // Select All functionality
    selectAllCheckbox.addEventListener('change', function() {
        fileCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelection();
    });

    // Individual checkbox change
    fileCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelection();
        });
    });

    function updateSelection() {
        const checkedBoxes = document.querySelectorAll('.file-checkbox:checked');
        const count = checkedBoxes.length;

        selectedCount.textContent = count + ' فایل انتخاب شده';
        selectedCount.style.display = count > 0 ? 'inline-block' : 'none';
        bulkActions.style.display = count > 0 ? 'block' : 'none';

        // Update select all checkbox
        if (count === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (count === fileCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
        }
    }
});

function clearSelection() {
    document.querySelectorAll('.file-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAllFiles').checked = false;
    document.getElementById('selectedCount').style.display = 'none';
    document.getElementById('bulkActions').style.display = 'none';
}

function downloadSelectedFiles() {
    const selectedFiles = Array.from(document.querySelectorAll('.file-checkbox:checked'))
        .map(checkbox => checkbox.value);

    if (selectedFiles.length === 0) {
        alert('لطفاً حداقل یک فایل انتخاب کنید');
        return;
    }

    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("tags.bulk-download", $tag->id) }}';

    // Add CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);

    // Add file IDs
    selectedFiles.forEach(fileId => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'file_ids[]';
        input.value = fileId;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function mergeSelectedFiles() {
    const selectedFiles = Array.from(document.querySelectorAll('.file-checkbox:checked'))
        .map(checkbox => checkbox.value);

    if (selectedFiles.length === 0) {
        alert('لطفاً حداقل یک فایل انتخاب کنید');
        return;
    }

    if (selectedFiles.length < 2) {
        alert('برای ادغام حداقل 2 فایل انتخاب کنید');
        return;
    }

    // Show loading
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i>در حال ادغام...';
    button.disabled = true;

    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("tags.merge-pdf", $tag->id) }}';

    // Add CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);

    // Add file IDs
    selectedFiles.forEach(fileId => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'file_ids[]';
        input.value = fileId;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

    // Reset button after 3 seconds
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    }, 3000);
}
</script>
@endpush
