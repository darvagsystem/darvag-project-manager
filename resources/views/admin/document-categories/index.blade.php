@extends('admin.layout')

@section('title', 'مدیریت دسته‌بندی‌های مدارک')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">مدیریت دسته‌بندی‌های مدارک</h1>
        <p class="page-subtitle">سازماندهی و مدیریت دسته‌بندی‌های سلسله‌مراتبی</p>
    </div>
    <div>
        <a href="{{ route('panel.documents.index') }}" class="btn btn-light me-2">
            <i class="mdi mdi-arrow-right me-1"></i>
            بازگشت به داشبورد
        </a>
        <a href="{{ route('panel.document-categories.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus me-1"></i>
            افزودن دسته‌بندی جدید
        </a>
    </div>
</div>

<!-- Categories Tree -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">ساختار دسته‌بندی‌ها</h5>
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="expandAll()">
                <i class="mdi mdi-expand-all"></i>
                گسترش همه
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="collapseAll()">
                <i class="mdi mdi-collapse-all"></i>
                جمع کردن همه
            </button>
            <button type="button" class="btn btn-sm btn-outline-info" onclick="testToggle()">
                <i class="mdi mdi-test-tube"></i>
                تست کلیک
            </button>
        </div>
    </div>
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card category-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="category-icon me-3" style="background-color: {{ $category->color }};">
                                        <i class="{{ $category->icon }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $category->name }}</h6>
                                        <small class="text-muted">{{ $category->code }}</small>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('panel.document-categories.show', $category) }}">
                                                <i class="mdi mdi-eye me-2"></i>مشاهده
                                            </a></li>
                                            <li><a class="dropdown-item" href="{{ route('panel.document-categories.edit', $category) }}">
                                                <i class="mdi mdi-pencil me-2"></i>ویرایش
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><button class="dropdown-item text-danger" onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')">
                                                <i class="mdi mdi-delete me-2"></i>حذف
                                            </button></li>
                                        </ul>
                                    </div>
                                </div>

                                @if($category->description)
                                    <p class="text-muted small mb-2">{{ Str::limit($category->description, 100) }}</p>
                                @endif

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-{{ $category->status_color }}">{{ $category->status_text }}</span>
                                    <small class="text-muted">
                                        <i class="mdi mdi-file-document-multiple me-1"></i>
                                        {{ $category->documents_count ?? 0 }} سند
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="mdi mdi-folder-outline" style="font-size: 4rem; color: #6c757d;"></i>
                <h4 class="mt-3 text-muted">هیچ دسته‌بندی‌ای یافت نشد</h4>
                <p class="text-muted">برای شروع، اولین دسته‌بندی را ایجاد کنید</p>
                <a href="{{ route('panel.document-categories.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i>
                    افزودن دسته‌بندی جدید
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Statistics -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-icon bg-primary">
                    <i class="mdi mdi-folder-multiple"></i>
                </div>
                <h3 class="stats-number">{{ $categories->count() }}</h3>
                <p class="stats-label">کل دسته‌بندی‌ها</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-icon bg-success">
                    <i class="mdi mdi-folder-check"></i>
                </div>
                <h3 class="stats-number">{{ $categories->where('is_active', true)->count() }}</h3>
                <p class="stats-label">دسته‌بندی‌های فعال</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-icon bg-warning">
                    <i class="mdi mdi-folder-account"></i>
                </div>
                <h3 class="stats-number">{{ $categories->whereNull('parent_id')->count() }}</h3>
                <p class="stats-label">دسته‌بندی‌های اصلی</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-icon bg-info">
                    <i class="mdi mdi-folder-network"></i>
                </div>
                <h3 class="stats-number">{{ $categories->whereNotNull('parent_id')->count() }}</h3>
                <p class="stats-label">زیردسته‌ها</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.category-tree {
    font-family: 'Vazir', sans-serif;
}

.category-item {
    margin-bottom: 0.5rem;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.category-item:hover {
    background: #e9ecef;
    border-color: #dee2e6;
}

.category-header {
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
}

.category-info {
    display: flex;
    align-items: center;
    flex: 1;
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
    color: white;
}

.category-details {
    flex: 1;
}

.category-name {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #1f2937;
}

.category-meta {
    font-size: 0.875rem;
    color: #6b7280;
}

.category-actions {
    display: flex;
    gap: 0.5rem;
}

.category-children {
    padding-right: 2rem;
    border-top: 1px solid #e9ecef;
    background: white;
    display: none;
}

.category-children.show {
    display: block;
}

.toggle-icon {
    transition: transform 0.3s ease;
}

.toggle-icon.rotated {
    transform: rotate(90deg);
}

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
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.stats-label {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

.btn-group .btn {
    border-radius: 6px;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.category-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    background: white;
    transition: all 0.2s ease;
}

.category-header:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.category-info {
    display: flex;
    align-items: center;
    flex: 1;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 6px;
    transition: background-color 0.2s ease;
}

.category-info:hover {
    background-color: #f8f9fa;
}

.category-actions {
    display: flex;
    gap: 0.25rem;
    align-items: center;
    flex-shrink: 0;
    margin-right: 1rem;
}

.category-actions .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.category-actions .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.category-actions .btn:active {
    transform: translateY(0);
}

/* Prevent text selection on action buttons */
.category-actions {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}

/* Category children display */
.category-children {
    display: none !important;
    margin-top: 0.5rem;
    padding-right: 1rem;
}

.category-children.show {
    display: block !important;
}

/* Ensure proper visibility */
.category-tree .category-children {
    display: none;
}

.category-tree .category-children.show {
    display: block;
}

/* Category Card Styles */
.category-card {
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.category-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.category-card .category-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.toggle-icon {
    transition: transform 0.3s ease;
}

.toggle-icon.rotated {
    transform: rotate(90deg);
}
</style>
@endpush

@push('scripts')
<script>
function toggleCategory(element, event) {
    // Prevent event bubbling
    if (event) {
        event.stopPropagation();
    }

    // Check if click was on action buttons
    if (event && event.target.closest('.category-actions')) {
        return;
    }

    const children = element.nextElementSibling;
    const icon = element.querySelector('.toggle-icon');

    console.log('Toggle clicked:', element, children, icon); // Debug log

    if (children) {
        if (children.classList.contains('show')) {
            children.classList.remove('show');
            if (icon) icon.classList.remove('rotated');
        } else {
            children.classList.add('show');
            if (icon) icon.classList.add('rotated');
        }
    }
}

// Event delegation method
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
        // Check if click was on category-info
        const categoryInfo = event.target.closest('.category-info');
        if (!categoryInfo) return;

        // Check if click was on action buttons
        if (event.target.closest('.category-actions')) {
            return;
        }

        // Find children and icon
        const children = categoryInfo.nextElementSibling;
        const icon = categoryInfo.querySelector('.toggle-icon');

        console.log('Click detected:', categoryInfo, children, icon);

        if (children) {
            if (children.classList.contains('show')) {
                children.classList.remove('show');
                children.style.display = 'none';
                if (icon) icon.classList.remove('rotated');
                console.log('Hiding children - classes:', children.className);
            } else {
                children.classList.add('show');
                children.style.display = 'block';
                if (icon) icon.classList.add('rotated');
                console.log('Showing children - classes:', children.className);
                console.log('Children element:', children);
                console.log('Children computed style:', window.getComputedStyle(children).display);
            }
        }
    });
});

function expandAll() {
    document.querySelectorAll('.category-children').forEach(child => {
        child.classList.add('show');
        child.style.display = 'block';
    });
    document.querySelectorAll('.toggle-icon').forEach(icon => {
        icon.classList.add('rotated');
    });
}

function testToggle() {
    console.log('Testing toggle...');
    const firstCategory = document.querySelector('.category-info');
    if (firstCategory) {
        const children = firstCategory.nextElementSibling;
        const icon = firstCategory.querySelector('.toggle-icon');

        console.log('First category:', firstCategory, children, icon);

        if (children) {
            if (children.classList.contains('show')) {
                children.classList.remove('show');
                children.style.display = 'none';
                if (icon) icon.classList.remove('rotated');
                console.log('Hiding first category children');
            } else {
                children.classList.add('show');
                children.style.display = 'block';
                if (icon) icon.classList.add('rotated');
                console.log('Showing first category children');
            }
        }
    }
}

function collapseAll() {
    document.querySelectorAll('.category-children').forEach(child => {
        child.classList.remove('show');
        child.style.display = 'none';
    });
    document.querySelectorAll('.toggle-icon').forEach(icon => {
        icon.classList.remove('rotated');
    });
}

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

function deleteCategory(categoryId, categoryName) {
    SimpleModal.confirm({
        title: 'حذف دسته‌بندی',
        message: `آیا از حذف دسته‌بندی "<strong>${categoryName}</strong>" اطمینان دارید؟<br><small class="text-muted">این عمل قابل بازگشت نیست</small>`,
        icon: 'mdi mdi-delete-alert',
        color: '#dc3545',
        confirmText: 'حذف',
        cancelText: 'انصراف',
        confirmButtonClass: 'btn-danger'
    }).then(confirmed => {
        if (confirmed) {
            // Show loading
            SimpleModal.loading({
                title: 'در حال حذف',
                message: 'دسته‌بندی در حال حذف است...'
            });

            fetch(`/panel/document-categories/${categoryId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                SimpleModal.hide();

                if (data.success) {
                    SimpleModal.message({
                        title: 'موفق',
                        message: data.message || 'دسته‌بندی با موفقیت حذف شد',
                        icon: 'mdi mdi-check-circle',
                        color: '#28a745'
                    });

                    // Reload page after 1 second
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    SimpleModal.message({
                        title: 'خطا',
                        message: data.message || 'خطا در حذف دسته‌بندی',
                        icon: 'mdi mdi-alert-circle',
                        color: '#dc3545'
                    });
                }
            })
            .catch(error => {
                SimpleModal.hide();
                console.error('Error:', error);
                SimpleModal.message({
                    title: 'خطا',
                    message: 'خطا در ارتباط با سرور',
                    icon: 'mdi mdi-alert-circle',
                    color: '#dc3545'
                });
            });
        }
    });
}
</script>
@endpush
