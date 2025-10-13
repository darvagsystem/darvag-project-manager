@extends('admin.layout')

@section('title', 'لاگ‌های فعالیت')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <div class="breadcrumb">
                <a href="{{ route('panel.dashboard') }}" class="breadcrumb-link">داشبورد</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">لاگ‌های فعالیت</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-history"></i>
                لاگ‌های فعالیت
            </h1>
            <p class="page-subtitle">مشاهده و مدیریت فعالیت‌های کاربران</p>
        </div>
        <div class="header-actions">
            <button type="button" class="btn btn-outline-primary" onclick="exportLogs()">
                <i class="fas fa-download"></i>
                صادر کردن
            </button>
            <button type="button" class="btn btn-outline-warning" onclick="clearOldLogs()">
                <i class="fas fa-trash"></i>
                پاک کردن لاگ‌های قدیمی
            </button>
        </div>
    </div>
</div>

<div class="page-content">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $statistics['total_activities'] }}</h4>
                            <p class="mb-0">کل فعالیت‌ها</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $statistics['activities_by_user']->count() }}</h4>
                            <p class="mb-0">کاربران فعال</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $statistics['activities_by_action']->count() }}</h4>
                            <p class="mb-0">انواع عملیات</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-tasks fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $statistics['activities_by_model']->count() }}</h4>
                            <p class="mb-0">انواع مدل‌ها</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-database fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">فیلترها</h5>
        </div>
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('panel.activity-logs') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label for="user_id" class="form-label">کاربر</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">همه کاربران</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="action" class="form-label">عملیات</label>
                        <select name="action" id="action" class="form-select">
                            <option value="">همه عملیات</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ $action }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="model_type" class="form-label">نوع مدل</label>
                        <select name="model_type" id="model_type" class="form-select">
                            <option value="">همه مدل‌ها</option>
                            @foreach($modelTypes as $modelType)
                                <option value="{{ $modelType }}" {{ request('model_type') == $modelType ? 'selected' : '' }}>
                                    {{ class_basename($modelType) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="level" class="form-label">سطح</label>
                        <select name="level" id="level" class="form-select">
                            <option value="">همه سطوح</option>
                            @foreach($levels as $level)
                                <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">از تاریخ</label>
                        <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">تا تاریخ</label>
                        <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">جستجو در توضیحات</label>
                        <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="جستجو...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                فیلتر
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Activity Logs Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">لاگ‌های فعالیت</h5>
        </div>
        <div class="card-body">
            @if($logs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>تاریخ و زمان</th>
                                <th>کاربر</th>
                                <th>عملیات</th>
                                <th>توضیحات</th>
                                <th>مدل</th>
                                <th>سطح</th>
                                <th>IP</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            {{ $log->created_at->format('Y/m/d H:i:s') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($log->user)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    {{ substr($log->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $log->user->name }}</div>
                                                    <small class="text-muted">{{ $log->user->email }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">سیستم</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $log->formatted_action }}</span>
                                    </td>
                                    <td>
                                        <div class="text-wrap" style="max-width: 300px;">
                                            {{ $log->description }}
                                        </div>
                                        @if($log->properties)
                                            <button type="button" class="btn btn-sm btn-outline-info mt-1" onclick="showProperties({{ $log->id }})">
                                                <i class="fas fa-info-circle"></i>
                                                جزئیات
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->model_type)
                                            <span class="badge bg-info">{{ $log->model_name }}</span>
                                            @if($log->model_id)
                                                <small class="text-muted">#{{ $log->model_id }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $log->level_color }}">
                                            {{ $log->formatted_level }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $log->ip_address }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if($log->model_type && $log->model_id)
                                                <button type="button" class="btn btn-outline-primary" onclick="viewModelActivity('{{ $log->model_type }}', {{ $log->model_id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            @endif
                                            @if($log->user)
                                                <button type="button" class="btn btn-outline-info" onclick="viewUserActivity({{ $log->user->id }})">
                                                    <i class="fas fa-user"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">هیچ فعالیتی یافت نشد</h5>
                    <p class="text-muted">فعالیت‌های کاربران در اینجا نمایش داده می‌شود</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Properties Modal -->
<div class="modal fade" id="propertiesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">جزئیات فعالیت</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="propertiesContent" class="bg-light p-3 rounded"></pre>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showProperties(logId) {
    // This would typically fetch properties via AJAX
    // For now, we'll show a placeholder
    document.getElementById('propertiesContent').textContent = 'جزئیات فعالیت...';
    new bootstrap.Modal(document.getElementById('propertiesModal')).show();
}

function viewModelActivity(modelType, modelId) {
    window.open(`{{ route('panel.activity-logs.model', ['', '']) }}/${modelType}/${modelId}`, '_blank');
}

function viewUserActivity(userId) {
    window.open(`{{ route('panel.activity-logs.user', '') }}/${userId}`, '_blank');
}

function exportLogs() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);

    window.open(`{{ route('panel.activity-logs.export') }}?${params.toString()}`, '_blank');
}

function clearOldLogs() {
    if (!confirm('آیا مطمئن هستید که می‌خواهید لاگ‌های قدیمی‌تر از 90 روز را پاک کنید؟')) {
        return;
    }

    fetch('{{ route("panel.activity-logs.clear-old") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            days: 90
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`تعداد ${data.deleted_count} لاگ قدیمی پاک شد`);
            location.reload();
        } else {
            alert('خطا در پاک کردن لاگ‌ها');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در پاک کردن لاگ‌ها');
    });
}
</script>
@endsection
