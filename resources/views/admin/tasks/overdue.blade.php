@extends('admin.layout')

@section('title', 'وظایف معوق')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-danger">
                        <i class="fas fa-exclamation-triangle"></i> وظایف معوق
                    </h3>
                    <div>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> همه وظایف
                        </a>
                        <a href="{{ route('tasks.my-tasks') }}" class="btn btn-primary">
                            <i class="fas fa-user"></i> وظایف من
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($tasks->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>توجه:</strong> {{ $tasks->total() }} وظیفه معوق وجود دارد که نیاز به بررسی و اقدام فوری دارند.
                        </div>

                        <!-- Tasks Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>وضعیت</th>
                                        <th>اولویت</th>
                                        <th>واگذار شده به</th>
                                        <th>پروژه</th>
                                        <th>دسته‌بندی</th>
                                        <th>تاریخ سررسید</th>
                                        <th>تأخیر</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr class="table-danger">
                                            <td>
                                                <div>
                                                    <strong>{{ $task->title }}</strong>
                                                    <span class="badge bg-danger ms-1">معوق</span>
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
                                                @if($task->category)
                                                    <span class="badge" style="background-color: {{ $task->category->color }}; color: white;">
                                                        {{ $task->category->name }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">بدون دسته‌بندی</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->due_date)
                                                    <span class="text-danger">
                                                        {{ \App\Helpers\DateHelper::toPersianDateTime($task->due_date) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">تعین نشده</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->due_date)
                                                    <span class="badge bg-danger">
                                                        {{ $task->due_date->diffForHumans() }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($task->status !== 'completed')
                                                        <form method="POST" action="{{ route('tasks.update-status', $task) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="completed">
                                                            <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('آیا مطمئن هستید که این وظیفه تکمیل شده است؟')">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
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
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h4 class="text-success">عالی!</h4>
                            <p class="text-muted">هیچ وظیفه معوقی وجود ندارد. همه وظایف در زمان مقرر انجام شده‌اند.</p>
                            <a href="{{ route('tasks.index') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> مشاهده همه وظایف
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
