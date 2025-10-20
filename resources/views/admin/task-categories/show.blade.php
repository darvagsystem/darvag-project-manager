@extends('admin.layout')

@section('title', $taskCategory->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="{{ $taskCategory->icon }} me-2" style="color: {{ $taskCategory->color }};"></i>
                        {{ $taskCategory->name }}
                    </h3>
                    <div>
                        <a href="{{ route('task-categories.edit', $taskCategory) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> ویرایش
                        </a>
                        <a href="{{ route('task-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> بازگشت
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>اطلاعات دسته‌بندی</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>نام:</strong></td>
                                    <td>{{ $taskCategory->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>رنگ:</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="color-preview me-2" style="width: 20px; height: 20px; background-color: {{ $taskCategory->color }}; border-radius: 3px;"></div>
                                            <span>{{ $taskCategory->color }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>آیکون:</strong></td>
                                    <td>
                                        @if($taskCategory->icon)
                                            <i class="{{ $taskCategory->icon }}"></i>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>وضعیت:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $taskCategory->is_active ? 'success' : 'danger' }}">
                                            {{ $taskCategory->is_active ? 'فعال' : 'غیرفعال' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>ترتیب:</strong></td>
                                    <td>{{ $taskCategory->sort_order }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>آمار</h5>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h3>{{ $taskCategory->task_count }}</h3>
                                            <p class="mb-0">کل وظایف</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h3>{{ $taskCategory->active_task_count }}</h3>
                                            <p class="mb-0">وظایف فعال</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($taskCategory->description)
                        <div class="mb-4">
                            <h5>توضیحات</h5>
                            <div class="border p-3 rounded">
                                {!! nl2br(e($taskCategory->description)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Tasks in this category -->
                    <div class="mb-4">
                        <h5>وظایف این دسته‌بندی</h5>
                        @if($tasks->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>عنوان</th>
                                            <th>وضعیت</th>
                                            <th>اولویت</th>
                                            <th>واگذار شده به</th>
                                            <th>پروژه</th>
                                            <th>تاریخ سررسید</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tasks as $task)
                                            <tr class="{{ $task->is_overdue ? 'table-danger' : '' }}">
                                                <td>
                                                    <div>
                                                        <strong>{{ $task->title }}</strong>
                                                        @if($task->is_overdue)
                                                            <span class="badge bg-danger ms-1">معوق</span>
                                                        @endif
                                                        @if($task->description)
                                                            <br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'primary' : ($task->status == 'cancelled' ? 'danger' : 'warning')) }}">
                                                        {{ $task->formatted_status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $task->priority == 'urgent' ? 'danger' : ($task->priority == 'high' ? 'warning' : ($task->priority == 'low' ? 'secondary' : 'info')) }}">
                                                        {{ $task->formatted_priority }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($task->assignedUser)
                                                        {{ $task->assignedUser->name }}
                                                    @else
                                                        <span class="text-muted">واگذار نشده</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($task->project)
                                                        <a href="{{ route('panel.projects.show', $task->project) }}" class="text-decoration-none">
                                                            {{ $task->project->name }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">بدون پروژه</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($task->due_date)
                                                        {{ \App\Helpers\DateHelper::toPersianDateTime($task->due_date) }}
                                                    @else
                                                        <span class="text-muted">تعین نشده</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $tasks->links() }}
                            </div>
                        @else
                            <p class="text-muted">هیچ وظیفه‌ای در این دسته‌بندی وجود ندارد</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
