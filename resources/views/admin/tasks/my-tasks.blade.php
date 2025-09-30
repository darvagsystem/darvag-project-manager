@extends('admin.layout')

@section('title', 'کارهای من')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="mdi mdi-account me-2"></i>
                        کارهای من
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i>
                            ایجاد کار جدید
                        </a>
                        <a href="{{ route('admin.tasks.index') }}" class="btn btn-info">
                            <i class="mdi mdi-format-list-checks me-1"></i>
                            همه کارها
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- فیلترها -->
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">وضعیت</label>
                            <select name="status" class="form-select">
                                <option value="">همه</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>در انتظار</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>در حال انجام</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>
                    </form>

                    <!-- جدول کارها -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>عنوان</th>
                                    <th>نوع</th>
                                    <th>اولویت</th>
                                    <th>وضعیت</th>
                                    <th>پروژه</th>
                                    <th>تاریخ موعد</th>
                                    <th>ساعت تخمینی</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                    <tr class="{{ $task->is_overdue ? 'table-danger' : '' }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($task->is_reminder)
                                                    <i class="mdi mdi-bell text-warning me-2"></i>
                                                @endif
                                                @if($task->is_recurring)
                                                    <i class="mdi mdi-repeat text-info me-2"></i>
                                                @endif
                                                <div>
                                                    <strong>{{ $task->title }}</strong>
                                                    @if($task->description)
                                                        <br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $task->type_text }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $task->priority_color }}">
                                                {{ $task->priority_text }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $task->status_color }}">
                                                {{ $task->status_text }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($task->project)
                                                <a href="{{ route('projects.show', $task->project) }}" class="text-decoration-none">
                                                    {{ $task->project->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">بدون پروژه</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($task->due_date)
                                                <div class="d-flex flex-column">
                                                    <span class="{{ $task->is_overdue ? 'text-danger fw-bold' : '' }}">
                                                        {{ $task->due_date->format('Y/m/d') }}
                                                    </span>
                                                    @if($task->due_time)
                                                        <small class="text-muted">{{ $task->due_time->format('H:i') }}</small>
                                                    @endif
                                                    @if($task->is_overdue)
                                                        <small class="text-danger">گذشته!</small>
                                                    @elseif($task->days_until_due !== null)
                                                        <small class="text-info">{{ $task->days_until_due }} روز باقی مانده</small>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">تعین نشده</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($task->estimated_hours)
                                                {{ $task->estimated_hours }} ساعت
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-sm btn-outline-info" title="مشاهده">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-outline-warning" title="ویرایش">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                @if($task->status === 'pending')
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="updateTaskStatus({{ $task->id }}, 'in_progress')" title="شروع">
                                                        <i class="mdi mdi-play"></i>
                                                    </button>
                                                @endif
                                                @if($task->status === 'in_progress')
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                            onclick="updateTaskStatus({{ $task->id }}, 'completed')" title="تکمیل">
                                                        <i class="mdi mdi-check"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="mdi mdi-format-list-checks display-4 d-block mb-3"></i>
                                                هیچ کاری به شما واگذار نشده است
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateTaskStatus(taskId, status) {
    fetch(`/admin/tasks/${taskId}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('خطا در به‌روزرسانی وضعیت');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در به‌روزرسانی وضعیت');
    });
}
</script>
@endpush
