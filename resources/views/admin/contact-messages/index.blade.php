@extends('admin.layout')

@section('title', 'مدیریت پیام‌های تماس')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">مدیریت پیام‌های تماس</h1>
            <p class="text-muted">مدیریت و پاسخگویی به پیام‌های دریافتی از فرم تماس</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="refreshPage()">
                <i class="fas fa-sync-alt me-1"></i>
                بروزرسانی
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">کل پیام‌ها</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">پیام‌های جدید</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['new'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">خوانده شده</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['read'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">پاسخ داده شده</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['replied'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-reply fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">فیلتر و جستجو</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.contact-messages.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">وضعیت</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>جدید</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>خوانده شده</option>
                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>پاسخ داده شده</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>بسته شده</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="subject" class="form-label">موضوع</label>
                    <select name="subject" id="subject" class="form-select">
                        <option value="">همه موضوعات</option>
                        @foreach(\App\Models\ContactMessage::SUBJECTS as $key => $value)
                            <option value="{{ $key }}" {{ request('subject') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="search" class="form-label">جستجو</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           placeholder="جستجو در نام، ایمیل، تلفن یا پیام..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>
                            جستجو
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">لیست پیام‌ها</h6>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary" onclick="selectAll()">
                    <i class="fas fa-check-square me-1"></i>
                    انتخاب همه
                </button>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cog me-1"></i>
                        عملیات گروهی
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="bulkAction('mark_read')">علامت‌گذاری به عنوان خوانده شده</a></li>
                        <li><a class="dropdown-item" href="#" onclick="bulkAction('mark_replied')">علامت‌گذاری به عنوان پاسخ داده شده</a></li>
                        <li><a class="dropdown-item" href="#" onclick="bulkAction('mark_closed')">علامت‌گذاری به عنوان بسته شده</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">حذف انتخاب شده‌ها</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($messages->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                                <th>نام</th>
                                <th>ایمیل</th>
                                <th>تلفن</th>
                                <th>موضوع</th>
                                <th>وضعیت</th>
                                <th>تاریخ</th>
                                <th width="150">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message)
                                <tr class="{{ !$message->is_read ? 'table-warning' : '' }}">
                                    <td>
                                        <input type="checkbox" name="message_ids[]" value="{{ $message->id }}" class="message-checkbox">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if(!$message->is_read)
                                                <span class="badge bg-danger me-2">جدید</span>
                                            @endif
                                            <strong>{{ $message->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->phone }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $message->subject_name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $message->status_color }}">
                                            {{ $message->status_name }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $message->created_at->format('Y/m/d H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.contact-messages.show', $message) }}" 
                                               class="btn btn-outline-primary" title="مشاهده">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(!$message->is_read)
                                                <button class="btn btn-outline-success" 
                                                        onclick="markAsRead({{ $message->id }})" 
                                                        title="علامت‌گذاری به عنوان خوانده شده">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}" 
                                                  class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $messages->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">هیچ پیامی یافت نشد</h5>
                    <p class="text-muted">در حال حاضر هیچ پیام تماسی وجود ندارد.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulkActionForm" method="POST" action="{{ route('admin.contact-messages.bulk-action') }}" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulkAction">
    <div id="bulkMessageIds"></div>
</form>
@endsection

@push('scripts')
<script>
function selectAll() {
    const checkboxes = document.querySelectorAll('.message-checkbox');
    const selectAllCheckbox = document.getElementById('selectAll');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    
    checkboxes.forEach(cb => cb.checked = !allChecked);
    selectAllCheckbox.checked = !allChecked;
}

function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.message-checkbox');
    
    checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
}

function bulkAction(action) {
    const selectedCheckboxes = document.querySelectorAll('.message-checkbox:checked');
    
    if (selectedCheckboxes.length === 0) {
        alert('لطفاً حداقل یک پیام را انتخاب کنید');
        return;
    }
    
    if (action === 'delete' && !confirm('آیا مطمئن هستید که می‌خواهید پیام‌های انتخاب شده را حذف کنید؟')) {
        return;
    }
    
    const form = document.getElementById('bulkActionForm');
    const actionInput = document.getElementById('bulkAction');
    const messageIdsDiv = document.getElementById('bulkMessageIds');
    
    actionInput.value = action;
    messageIdsDiv.innerHTML = '';
    
    selectedCheckboxes.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'message_ids[]';
        input.value = checkbox.value;
        messageIdsDiv.appendChild(input);
    });
    
    form.submit();
}

function markAsRead(messageId) {
    fetch(`{{ url('panel/contact-messages') }}/${messageId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
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
        alert('خطا در بروزرسانی وضعیت');
    });
}

function refreshPage() {
    location.reload();
}
</script>
@endpush
