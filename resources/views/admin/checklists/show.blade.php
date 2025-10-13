@extends('admin.layout')

@section('title', $checklist->title)

@section('content')
<!-- Print Header (only visible when printing) -->
<div class="print-header" style="display: none;">
    <div class="print-title">{{ $checklist->title }}</div>
    @if($checklist->description)
        <div class="print-subtitle">{{ $checklist->description }}</div>
    @endif
    <div class="print-info">
        <div>
            <div class="print-info-item">
                <span class="print-info-label">دسته‌بندی:</span>
                <span>{{ $checklist->category ? $checklist->category->name : 'بدون دسته‌بندی' }}</span>
            </div>
            <div class="print-info-item">
                <span class="print-info-label">اولویت:</span>
                <span>{{ $checklist->formatted_priority }}</span>
            </div>
            <div class="print-info-item">
                <span class="print-info-label">وضعیت:</span>
                <span>{{ $checklist->formatted_status }}</span>
            </div>
        </div>
        <div>
            @if($checklist->due_date)
                <div class="print-info-item">
                    <span class="print-info-label">تاریخ سررسید:</span>
                    <span>{{ \App\Services\PersianDateService::carbonToPersianDateTime($checklist->due_date) }}</span>
                </div>
            @endif
            <div class="print-info-item">
                <span class="print-info-label">تاریخ ایجاد:</span>
                <span>{{ \App\Services\PersianDateService::carbonToPersianDateTime($checklist->created_at) }}</span>
            </div>
        </div>
    </div>

    <!-- Print Progress -->
    <div class="print-progress">
        <div class="print-progress-title">پیشرفت کار</div>
        <div class="print-progress-bar">
            <div class="print-progress-fill" style="width: {{ $checklist->progress_percentage }}"></div>
        </div>
        <div class="print-progress-text">{{ $checklist->completed_items_count }} از {{ $checklist->total_items_count }} کار انجام شده ({{ $checklist->progress_percentage }})</div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="width: 4px; height: 40px; background-color: {{ $checklist->color }}; border-radius: 2px;"></div>
                        <div>
                            <h3 class="card-title mb-0">{{ $checklist->title }}</h3>
                            @if($checklist->description)
                                <p class="text-muted mb-0 small">{{ $checklist->description }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('panel.checklists.print', $checklist) }}" class="btn btn-outline-success btn-sm no-print" target="_blank">
                            <i class="fas fa-print me-1"></i>
                            پرینت حرفه‌ای
                        </a>
                        <a href="{{ route('panel.checklists.edit', $checklist) }}" class="btn btn-outline-primary btn-sm no-print">
                            <i class="fas fa-edit me-1"></i>
                            ویرایش
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('panel.checklists.index') }}">
                                    <i class="fas fa-list me-2"></i>بازگشت به لیست
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('panel.checklists.destroy', $checklist) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('آیا مطمئن هستید؟')">
                                            <i class="fas fa-trash me-2"></i>حذف چک لیست
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Checklist Info -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-tag me-2 text-muted"></i>
                                        <span class="text-muted">دسته‌بندی:</span>
                                        @if($checklist->category)
                                            <span class="badge ms-2" style="background-color: {{ $checklist->category->color }}20; color: {{ $checklist->category->color }}">
                                                {{ $checklist->category->name }}
                                            </span>
                                        @else
                                            <span class="text-muted ms-2">بدون دسته‌بندی</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-flag me-2 text-muted"></i>
                                        <span class="text-muted">اولویت:</span>
                                        <span class="badge bg-{{ $checklist->priority === 'urgent' ? 'danger' : ($checklist->priority === 'high' ? 'warning' : 'secondary') }} ms-2">
                                            {{ $checklist->formatted_priority }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar me-2 text-muted"></i>
                                        <span class="text-muted">تاریخ ایجاد:</span>
                                        <span class="ms-2">{{ \App\Services\PersianDateService::carbonToPersianDateTime($checklist->created_at) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-clock me-2 text-muted"></i>
                                        <span class="text-muted">آخرین به‌روزرسانی:</span>
                                        <span class="ms-2">{{ \App\Services\PersianDateService::carbonToPersianDateTime($checklist->updated_at) }}</span>
                                    </div>
                                </div>
                                @if($checklist->due_date)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-calendar-check me-2 text-muted"></i>
                                            <span class="text-muted">تاریخ سررسید:</span>
                                            <span class="ms-2">{{ $checklist->persian_due_date }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Progress Card -->
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">پیشرفت</h5>
                                    <div class="progress mb-3" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ $checklist->progress_percentage }}; background-color: {{ $checklist->color }}"
                                             aria-valuenow="{{ $checklist->progress_percentage }}"
                                             aria-valuemin="0" aria-valuemax="100">
                                            {{ $checklist->progress_percentage }}
                                        </div>
                                    </div>
                                    <p class="card-text">
                                        <strong>{{ $checklist->completed_items_count }}</strong> از
                                        <strong>{{ $checklist->total_items_count }}</strong> کار انجام شده
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add New Item Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-plus me-2"></i>
                                افزودن کار جدید
                            </h6>
                        </div>
                        <div class="card-body">
                            <form id="addItemForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="itemTitle" name="title"
                                               placeholder="عنوان کار" required>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" id="itemPriority" name="priority">
                                            <option value="normal">عادی</option>
                                            <option value="low">پایین</option>
                                            <option value="high">بالا</option>
                                            <option value="urgent">فوری</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-plus me-1"></i>
                                            افزودن
                                        </button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-9">
                                        <textarea class="form-control" id="itemDescription" name="description"
                                                  rows="2" placeholder="توضیحات (اختیاری)"></textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control persian-date" id="itemDueDate" name="due_date" placeholder="1403/01/15 14:30">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Items List -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-list me-2"></i>
                                فهرست کارها
                            </h6>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-secondary" id="toggleCompleted">
                                    <i class="fas fa-eye-slash me-1"></i>
                                    مخفی کردن کارهای انجام شده
                                </button>
                                <button class="btn btn-sm btn-outline-primary" id="markAllComplete">
                                    <i class="fas fa-check-double me-1"></i>
                                    تیک زدن همه
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @if($checklist->items->count() > 0)
                                <div class="list-group list-group-flush" id="itemsList">
                                    @foreach($checklist->items as $item)
                                        <div class="list-group-item item-row {{ $item->is_completed ? 'completed' : '' }}"
                                             data-item-id="{{ $item->id }}">
                                            <div class="d-flex align-items-start">
                                                <div class="form-check me-3">
                                                    <input class="form-check-input item-checkbox" type="checkbox"
                                                           {{ $item->is_completed ? 'checked' : '' }}
                                                           data-item-id="{{ $item->id }}">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h6 class="mb-1 item-title">{{ $item->title }}</h6>
                                                            @if($item->description)
                                                                <p class="mb-1 text-muted small item-description">{{ $item->description }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                            @if($item->priority !== 'normal')
                                                                <span class="badge bg-{{ $item->priority === 'urgent' ? 'danger' : ($item->priority === 'high' ? 'warning' : 'secondary') }}">
                                                                    {{ $item->formatted_priority }}
                                                                </span>
                                                            @endif
                                                            @if($item->due_date)
                                                                <small class="text-muted">
                                                                    <i class="fas fa-calendar me-1"></i>
                                                                    {{ $item->persian_due_date }}
                                                                </small>
                                                            @endif
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item edit-item" href="#" data-item-id="{{ $item->id }}">
                                                                        <i class="fas fa-edit me-2"></i>ویرایش
                                                                    </a></li>
                                                                    <li><a class="dropdown-item delete-item text-danger" href="#" data-item-id="{{ $item->id }}">
                                                                        <i class="fas fa-trash me-2"></i>حذف
                                                                    </a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-list-check fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">هنوز کاری اضافه نکرده‌اید</h6>
                                    <p class="text-muted">برای شروع، اولین کار خود را اضافه کنید</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ویرایش کار</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editItemForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editItemTitle" class="form-label">عنوان</label>
                        <input type="text" class="form-control" id="editItemTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editItemDescription" class="form-label">توضیحات</label>
                        <textarea class="form-control" id="editItemDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="editItemPriority" class="form-label">اولویت</label>
                            <select class="form-select" id="editItemPriority" name="priority">
                                <option value="normal">عادی</option>
                                <option value="low">پایین</option>
                                <option value="high">بالا</option>
                                <option value="urgent">فوری</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="editItemDueDate" class="form-label">تاریخ سررسید</label>
                            <input type="text" class="form-control persian-date" id="editItemDueDate" name="due_date" placeholder="1403/01/15 14:30">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Print Items List (only visible when printing) -->
<div class="print-items" style="display: none;">
    <h3 style="font-size: 16pt; font-weight: bold; margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 5px;">فهرست کارها</h3>
    @foreach($checklist->items as $item)
        <div class="print-item {{ $item->is_completed ? 'completed' : '' }}">
            <div class="print-checkbox {{ $item->is_completed ? 'checked' : '' }}"></div>
            <div class="print-item-content">
                <div class="print-item-title">{{ $item->title }}</div>
                @if($item->description)
                    <div class="print-item-description">{{ $item->description }}</div>
                @endif
                <div class="print-item-meta">
                    @if($item->priority !== 'normal')
                        <span>اولویت: {{ $item->formatted_priority }}</span>
                    @endif
                    @if($item->due_date)
                        <span>سررسید: {{ \App\Services\PersianDateService::carbonToPersianDateTime($item->due_date) }}</span>
                    @endif
                    @if($item->is_completed && $item->completed_at)
                        <span>تکمیل شده در: {{ \App\Services\PersianDateService::carbonToPersianDateTime($item->completed_at) }}</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Print Footer -->
<div class="print-footer" style="display: none;">
    <p>چاپ شده در تاریخ: {{ \App\Services\PersianDateService::getCurrentPersianDateTime() }}</p>
    <p>سیستم مدیریت پروژه داروگ</p>
</div>
@endsection

@push('styles')
<style>
.item-row.completed {
    opacity: 0.6;
    background-color: #f8f9fa;
}

.item-row.completed .item-title {
    text-decoration: line-through;
}

.list-group-item {
    border-left: 4px solid transparent;
    transition: all 0.2s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.progress {
    border-radius: 10px;
}

/* Print Styles */
@media print {
    .no-print {
        display: none !important;
    }

    .print-header,
    .print-items,
    .print-footer {
        display: block !important;
    }

    body {
        font-family: 'Vazirmatn', Arial, sans-serif;
        font-size: 12pt;
        line-height: 1.4;
        color: #000;
        background: #fff;
        margin: 0;
        padding: 20px;
    }

    .container-fluid,
    .card {
        display: none !important;
    }

    .card-header {
        background-color: #f8f9fa !important;
        border-bottom: 2px solid #ddd !important;
        padding: 15px;
    }

    .card-title {
        font-size: 18pt;
        font-weight: bold;
        color: #000;
        margin-bottom: 10px;
    }

    .card-body {
        padding: 15px;
    }

    .print-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #333;
    }

    .print-title {
        font-size: 24pt;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .print-subtitle {
        font-size: 14pt;
        color: #666;
        margin-bottom: 20px;
    }

    .print-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        font-size: 11pt;
    }

    .print-info-item {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .print-info-label {
        font-weight: bold;
        margin-left: 5px;
    }

    .print-progress {
        text-align: center;
        margin: 20px 0;
        padding: 15px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
    }

    .print-progress-title {
        font-size: 14pt;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .print-progress-bar {
        width: 100%;
        height: 20px;
        background-color: #e9ecef;
        border: 1px solid #ddd;
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .print-progress-fill {
        height: 100%;
        background-color: #007bff;
        transition: width 0.3s ease;
    }

    .print-progress-text {
        font-size: 12pt;
        font-weight: bold;
    }

    .print-items {
        margin-top: 20px;
    }

    .print-item {
        display: flex;
        align-items: flex-start;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
        page-break-inside: avoid;
    }

    .print-item:last-child {
        border-bottom: none;
    }

    .print-item.completed {
        opacity: 0.7;
    }

    .print-item.completed .print-item-title {
        text-decoration: line-through;
    }

    .print-checkbox {
        width: 15px;
        height: 15px;
        border: 2px solid #333;
        margin-left: 10px;
        margin-top: 2px;
        display: inline-block;
    }

    .print-checkbox.checked {
        background-color: #333;
        position: relative;
    }

    .print-checkbox.checked::after {
        content: '✓';
        position: absolute;
        top: -2px;
        left: 2px;
        color: white;
        font-size: 10px;
        font-weight: bold;
    }

    .print-item-content {
        flex: 1;
    }

    .print-item-title {
        font-size: 12pt;
        font-weight: bold;
        margin-bottom: 3px;
    }

    .print-item-description {
        font-size: 10pt;
        color: #666;
        margin-bottom: 3px;
    }

    .print-item-meta {
        font-size: 9pt;
        color: #888;
        display: flex;
        gap: 15px;
    }

    .print-footer {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
        text-align: center;
        font-size: 10pt;
        color: #666;
    }

    .badge {
        font-size: 9pt;
        padding: 2px 6px;
        border-radius: 3px;
    }

    .btn {
        display: none !important;
    }

    .dropdown {
        display: none !important;
    }

    .form-control {
        border: 1px solid #ddd !important;
        background: #fff !important;
    }

    .modal {
        display: none !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Print functionality
function printChecklist() {
    // Show print sections
    document.querySelector('.print-header').style.display = 'block';
    document.querySelector('.print-items').style.display = 'block';
    document.querySelector('.print-footer').style.display = 'block';

    // Hide main content
    document.querySelector('.container-fluid').style.display = 'none';

    // Print
    window.print();

    // Restore visibility after print
    setTimeout(() => {
        document.querySelector('.print-header').style.display = 'none';
        document.querySelector('.print-items').style.display = 'none';
        document.querySelector('.print-footer').style.display = 'none';
        document.querySelector('.container-fluid').style.display = 'block';
    }, 1000);
}

// Make printChecklist function globally available
window.printChecklist = printChecklist;

document.addEventListener('DOMContentLoaded', function() {
    const addItemForm = document.getElementById('addItemForm');
    const editItemForm = document.getElementById('editItemForm');
    const editItemModal = new bootstrap.Modal(document.getElementById('editItemModal'));
    const itemsList = document.getElementById('itemsList');
    const toggleCompletedBtn = document.getElementById('toggleCompleted');
    const markAllCompleteBtn = document.getElementById('markAllComplete');

    let showCompleted = true;
    let currentEditItemId = null;

    // Add new item
    addItemForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(`/checklists/{{ $checklist->id }}/items`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Toggle item completion
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const itemRow = this.closest('.item-row');
            const originalChecked = this.checked;

            // Show loading state
            this.disabled = true;

            fetch(`/checklists/{{ $checklist->id }}/items/${itemId}/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    if (data.is_completed) {
                        itemRow.classList.add('completed');
                    } else {
                        itemRow.classList.remove('completed');
                    }
                    // Update progress without full reload
                    updateProgress();
                } else {
                    throw new Error('Server returned success: false');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert checkbox state
                this.checked = !originalChecked;
                alert('خطا در به‌روزرسانی وضعیت کار. لطفاً دوباره تلاش کنید.');
            })
            .finally(() => {
                this.disabled = false;
            });
        });
    });

    // Function to update progress without full reload
    function updateProgress() {
        const completedItems = document.querySelectorAll('.item-checkbox:checked').length;
        const totalItems = document.querySelectorAll('.item-checkbox').length;
        const percentage = totalItems > 0 ? Math.round((completedItems / totalItems) * 100) : 0;

        // Update progress bar
        const progressBar = document.querySelector('.progress-bar');
        if (progressBar) {
            progressBar.style.width = percentage + '%';
            progressBar.setAttribute('aria-valuenow', percentage);
            progressBar.textContent = percentage + '%';
        }

        // Update progress text
        const progressText = document.querySelector('.card-text strong');
        if (progressText) {
            progressText.textContent = completedItems + ' از ' + totalItems;
        }
    }

    // Edit item
    document.querySelectorAll('.edit-item').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const itemId = this.dataset.itemId;
            const itemRow = this.closest('.item-row');

            // Fill form with current data
            document.getElementById('editItemTitle').value = itemRow.querySelector('.item-title').textContent;
            document.getElementById('editItemDescription').value = itemRow.querySelector('.item-description')?.textContent || '';

            currentEditItemId = itemId;
            editItemModal.show();
        });
    });

    editItemForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(`/checklists/{{ $checklist->id }}/items/${currentEditItemId}`, {
            method: 'PUT',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Delete item
    document.querySelectorAll('.delete-item').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const itemId = this.dataset.itemId;

            if (confirm('آیا مطمئن هستید؟')) {
                fetch(`/checklists/{{ $checklist->id }}/items/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });

    // Toggle completed items visibility
    toggleCompletedBtn.addEventListener('click', function() {
        showCompleted = !showCompleted;
        const completedItems = document.querySelectorAll('.item-row.completed');

        completedItems.forEach(item => {
            item.style.display = showCompleted ? 'block' : 'none';
        });

        this.innerHTML = showCompleted ?
            '<i class="fas fa-eye-slash me-1"></i>مخفی کردن کارهای انجام شده' :
            '<i class="fas fa-eye me-1"></i>نمایش کارهای انجام شده';
    });

    // Mark all as complete
    markAllCompleteBtn.addEventListener('click', function() {
        const uncheckedItems = document.querySelectorAll('.item-checkbox:not(:checked)');

        if (uncheckedItems.length === 0) {
            alert('همه کارها قبلاً انجام شده‌اند');
            return;
        }

        if (confirm(`آیا می‌خواهید ${uncheckedItems.length} کار را به عنوان انجام شده علامت‌گذاری کنید؟`)) {
            // This would need to be implemented as a bulk action
            alert('این قابلیت در نسخه بعدی اضافه خواهد شد');
        }
    });
});
</script>
@endpush
