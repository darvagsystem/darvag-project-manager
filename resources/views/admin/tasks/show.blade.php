@extends('admin.layout')

@section('title', 'جزئیات کار: ' . $task->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="mdi mdi-eye me-2"></i>
                        جزئیات کار
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-warning">
                            <i class="mdi mdi-pencil me-1"></i>
                            ویرایش
                        </a>
                        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-right me-1"></i>
                            بازگشت
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h4>{{ $task->title }}</h4>
                                @if($task->description)
                                    <p class="text-muted">{{ $task->description }}</p>
                                @endif
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">اطلاعات کلی</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td><strong>نوع:</strong></td>
                                                    <td><span class="badge bg-secondary">{{ $task->type_text }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>اولویت:</strong></td>
                                                    <td><span class="badge bg-{{ $task->priority_color }}">{{ $task->priority_text }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>وضعیت:</strong></td>
                                                    <td><span class="badge bg-{{ $task->status_color }}">{{ $task->status_text }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>تاریخ ایجاد:</strong></td>
                                                    <td>{{ $task->created_at->format('Y/m/d H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>آخرین به‌روزرسانی:</strong></td>
                                                    <td>{{ $task->updated_at->format('Y/m/d H:i') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">اطلاعات پروژه و کاربر</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td><strong>پروژه:</strong></td>
                                                    <td>
                                                        @if($task->project)
                                                            <a href="{{ route('projects.show', $task->project) }}" class="text-decoration-none">
                                                                {{ $task->project->name }}
                                                            </a>
                                                        @else
                                                            <span class="text-muted">بدون پروژه</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>واگذار شده به:</strong></td>
                                                    <td>
                                                        @if($task->assignedTo)
                                                            {{ $task->assignedTo->first_name }} {{ $task->assignedTo->last_name }}
                                                        @else
                                                            <span class="text-muted">واگذار نشده</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>ایجاد شده توسط:</strong></td>
                                                    <td>{{ $task->createdBy->name }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($task->due_date)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card {{ $task->is_overdue ? 'border-danger' : 'border-info' }}">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="mdi mdi-calendar me-2"></i>
                                                    اطلاعات موعد
                                                </h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>تاریخ موعد:</strong> {{ $task->due_date->format('Y/m/d') }}</p>
                                                        @if($task->due_time)
                                                            <p><strong>زمان موعد:</strong> {{ $task->due_time->format('H:i') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        @if($task->is_overdue)
                                                            <p class="text-danger"><strong>گذشته از موعد!</strong></p>
                                                        @elseif($task->days_until_due !== null)
                                                            <p class="text-info"><strong>{{ $task->days_until_due }} روز باقی مانده</strong></p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($task->estimated_hours || $task->actual_hours)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="mdi mdi-clock me-2"></i>
                                                    اطلاعات زمانی
                                                </h6>
                                                <div class="row">
                                                    @if($task->estimated_hours)
                                                        <div class="col-md-6">
                                                            <p><strong>ساعت تخمینی:</strong> {{ $task->estimated_hours }} ساعت</p>
                                                        </div>
                                                    @endif
                                                    @if($task->actual_hours)
                                                        <div class="col-md-6">
                                                            <p><strong>ساعت واقعی:</strong> {{ $task->actual_hours }} ساعت</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($task->tags && count($task->tags) > 0)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="mdi mdi-tag me-2"></i>
                                                    تگ‌ها
                                                </h6>
                                                <div>
                                                    @foreach($task->tags as $tag)
                                                        <span class="badge bg-primary me-1">{{ $tag }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($task->notes)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="mdi mdi-note me-2"></i>
                                                    یادداشت‌ها
                                                </h6>
                                                <p>{{ $task->notes }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">عملیات سریع</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        @if($task->status !== 'completed')
                                            <button type="button" class="btn btn-success"
                                                    onclick="updateTaskStatus({{ $task->id }}, 'completed')">
                                                <i class="mdi mdi-check me-1"></i>
                                                تکمیل کار
                                            </button>
                                        @endif

                                        @if($task->status === 'pending')
                                            <button type="button" class="btn btn-primary"
                                                    onclick="updateTaskStatus({{ $task->id }}, 'in_progress')">
                                                <i class="mdi mdi-play me-1"></i>
                                                شروع کار
                                            </button>
                                        @endif

                                        @if($task->status === 'in_progress')
                                            <button type="button" class="btn btn-warning"
                                                    onclick="updateTaskStatus({{ $task->id }}, 'pending')">
                                                <i class="mdi mdi-pause me-1"></i>
                                                متوقف کردن
                                            </button>
                                        @endif

                                        @if($task->status !== 'cancelled')
                                            <button type="button" class="btn btn-danger"
                                                    onclick="updateTaskStatus({{ $task->id }}, 'cancelled')">
                                                <i class="mdi mdi-close me-1"></i>
                                                لغو کار
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($task->is_reminder)
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="mdi mdi-bell me-2"></i>
                                            یادآوری
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if($task->reminder_at)
                                            <p><strong>زمان یادآوری:</strong></p>
                                            <p>{{ $task->reminder_at->format('Y/m/d H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($task->is_recurring)
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="mdi mdi-repeat me-2"></i>
                                            تکرار شونده
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-info">این کار به صورت تکرار شونده تنظیم شده است.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
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
    if (confirm('آیا مطمئن هستید که می‌خواهید وضعیت کار را تغییر دهید؟')) {
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
}
</script>
@endpush
