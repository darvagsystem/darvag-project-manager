@extends('admin.layout')

@section('title', 'مشاهده لاگ‌های سیستم')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <div class="breadcrumb">
                <a href="{{ route('panel.dashboard') }}" class="breadcrumb-link">داشبورد</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">لاگ‌های سیستم</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-file-alt"></i>
                مشاهده لاگ‌های سیستم
            </h1>
            <p class="page-subtitle">مشاهده و مدیریت لاگ‌های سیستم</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="refreshLogs()">
                <i class="fas fa-sync-alt"></i>
                به‌روزرسانی
            </button>
            <button class="btn btn-warning" onclick="clearLogs()">
                <i class="fas fa-trash"></i>
                پاک کردن لاگ‌ها
            </button>
            <button class="btn btn-success" onclick="downloadLogs()">
                <i class="fas fa-download"></i>
                دانلود لاگ‌ها
            </button>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title">فیلترها</h5>
    </div>
    <div class="card-body">
        <form id="filterForm" class="row g-3">
            <div class="col-md-3">
                <label for="channel" class="form-label">کانال</label>
                <select id="channel" name="channel" class="form-select">
                    <option value="all" {{ $channel === 'all' ? 'selected' : '' }}>همه کانال‌ها</option>
                    @foreach($channels as $ch)
                        <option value="{{ $ch }}" {{ $channel === $ch ? 'selected' : '' }}>
                            {{ ucfirst($ch) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="level" class="form-label">سطح</label>
                <select id="level" name="level" class="form-select">
                    <option value="all" {{ $level === 'all' ? 'selected' : '' }}>همه سطوح</option>
                    <option value="debug" {{ $level === 'debug' ? 'selected' : '' }}>Debug</option>
                    <option value="info" {{ $level === 'info' ? 'selected' : '' }}>Info</option>
                    <option value="warning" {{ $level === 'warning' ? 'selected' : '' }}>Warning</option>
                    <option value="error" {{ $level === 'error' ? 'selected' : '' }}>Error</option>
                    <option value="critical" {{ $level === 'critical' ? 'selected' : '' }}>Critical</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="limit" class="form-label">تعداد رکورد</label>
                <select id="limit" name="limit" class="form-select">
                    <option value="50" {{ $limit == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $limit == 100 ? 'selected' : '' }}>100</option>
                    <option value="200" {{ $limit == 200 ? 'selected' : '' }}>200</option>
                    <option value="500" {{ $limit == 500 ? 'selected' : '' }}>500</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i>
                    اعمال فیلتر
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Logs Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title">لاگ‌های سیستم</h5>
        <div class="card-tools">
            <span class="badge bg-info" id="logCount">{{ count($logs) }} رکورد</span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>زمان</th>
                        <th>کانال</th>
                        <th>سطح</th>
                        <th>عمل</th>
                        <th>کاربر</th>
                        <th>جزئیات</th>
                    </tr>
                </thead>
                <tbody id="logsTableBody">
                    @forelse($logs as $log)
                    <tr class="log-row" data-level="{{ $log['level'] ?? 'info' }}">
                        <td>
                            <small class="text-muted">
                                {{ $log['timestamp'] ?? 'نامشخص' }}
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $log['channel'] ?? 'نامشخص' }}
                            </span>
                        </td>
                        <td>
                            @php
                                $level = $log['level'] ?? 'info';
                                $levelClass = match($level) {
                                    'debug' => 'bg-secondary',
                                    'info' => 'bg-info',
                                    'warning' => 'bg-warning',
                                    'error' => 'bg-danger',
                                    'critical' => 'bg-dark',
                                    default => 'bg-info'
                                };
                            @endphp
                            <span class="badge {{ $levelClass }}">
                                {{ strtoupper($level) }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $log['action'] ?? $log['event'] ?? $log['operation'] ?? 'نامشخص' }}</strong>
                        </td>
                        <td>
                            <small>
                                {{ $log['user_name'] ?? $log['user_id'] ?? 'سیستم' }}
                            </small>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="showLogDetails({{ json_encode($log) }})">
                                <i class="fas fa-eye"></i>
                                مشاهده
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            <i class="fas fa-info-circle"></i>
                            هیچ لاگی یافت نشد
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Log Details Modal -->
<div class="modal fade" id="logDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">جزئیات لاگ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="logDetailsContent" class="bg-light p-3 rounded"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.log-row[data-level="error"] {
    background-color: #f8d7da;
}

.log-row[data-level="warning"] {
    background-color: #fff3cd;
}

.log-row[data-level="critical"] {
    background-color: #d1ecf1;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-info h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 600;
}

.header-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.breadcrumb {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.breadcrumb-link {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
}

.breadcrumb-link:hover {
    color: white;
}

.breadcrumb-separator {
    margin: 0 0.5rem;
    color: rgba(255, 255, 255, 0.6);
}

.breadcrumb-current {
    color: white;
    font-weight: 500;
}

.page-subtitle {
    margin: 0;
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.1rem;
}

#logDetailsContent {
    max-height: 400px;
    overflow-y: auto;
    font-size: 0.9rem;
}
</style>
@endpush

@push('scripts')
<script>
function refreshLogs() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);

    window.location.href = '{{ route("panel.logs") }}?' + params.toString();
}

function clearLogs() {
    if (!confirm('آیا مطمئن هستید که می‌خواهید لاگ‌ها را پاک کنید؟')) {
        return;
    }

    const channel = document.getElementById('channel').value;

    fetch('{{ route("panel.logs.clear") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            channel: channel
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('لاگ‌ها با موفقیت پاک شدند');
            refreshLogs();
        } else {
            alert('خطا در پاک کردن لاگ‌ها');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در پاک کردن لاگ‌ها');
    });
}

function downloadLogs() {
    const channel = document.getElementById('channel').value;
    const url = '{{ route("panel.logs.download") }}?channel=' + channel;
    window.open(url, '_blank');
}

function showLogDetails(log) {
    document.getElementById('logDetailsContent').textContent = JSON.stringify(log, null, 2);
    new bootstrap.Modal(document.getElementById('logDetailsModal')).show();
}

// Auto refresh every 30 seconds
setInterval(refreshLogs, 30000);
</script>
@endpush
