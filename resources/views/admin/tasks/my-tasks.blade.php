@extends('admin.layouts.app')

@section('title', 'کارهای من')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-tasks"></i>
                        کارهای من
                    </h3>
                </div>
                <div class="card-body">
                    <!-- فیلترها -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" class="form-inline">
                                <div class="form-group mr-2">
                                    <select name="status" class="form-control">
                                        <option value="">همه وضعیت‌ها</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>در انتظار</option>
                                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>در حال انجام</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-search"></i>
                                    جستجو
                                </button>
                                <a href="{{ route('panel.tasks.my-tasks') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i>
                                    پاک کردن
                                </a>
                            </form>
                        </div>
                    </div>

                    <!-- جدول کارها -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>عنوان</th>
                                    <th>پروژه</th>
                                    <th>وضعیت</th>
                                    <th>اولویت</th>
                                    <th>پیشرفت</th>
                                    <th>تاریخ موعد</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                    <tr>
                                        <td>
                                            <strong>{{ $task->title }}</strong>
                                            @if($task->description)
                                                <br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($task->project)
                                                <span class="badge badge-info">{{ $task->project->name }}</span>
                                            @else
                                                <span class="text-muted">بدون پروژه</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $task->status_color }}">
                                                {{ $task->status_text }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $task->priority_color }}">
                                                {{ $task->priority_text }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="width: 100px;">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%">
                                                    {{ $task->progress }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($task->due_date)
                                                {{ $task->due_date->format('Y/m/d') }}
                                                @if($task->due_date->isPast() && $task->status != 'completed')
                                                    <br><small class="text-danger">منقضی شده</small>
                                                @endif
                                            @else
                                                <span class="text-muted">تعیین نشده</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('panel.tasks.show', $task) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('panel.tasks.edit', $task) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($task->canBeStartedBy(auth()->id()))
                                                    <button class="btn btn-sm btn-success" onclick="startTask({{ $task->id }})">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                @endif
                                                @if($task->canBeCompletedBy(auth()->id()))
                                                    <button class="btn btn-sm btn-primary" onclick="completeTask({{ $task->id }})">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">هیچ کاری یافت نشد</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
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
function startTask(taskId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این کار را شروع کنید؟')) {
        fetch(`/panel/tasks/${taskId}/start`, {
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
            } else {
                alert(data.message);
            }
        });
    }
}

function completeTask(taskId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این کار را تکمیل کنید؟')) {
        fetch(`/panel/tasks/${taskId}/complete`, {
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
            } else {
                alert(data.message);
            }
        });
    }
}
</script>
@endpush
