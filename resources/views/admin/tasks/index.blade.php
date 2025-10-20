@extends('admin.layout')

@section('title', 'مدیریت وظایف')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">مدیریت وظایف</h3>
                    <div>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> وظیفه جدید
                        </a>
                        <a href="{{ route('task-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-tags"></i> دسته‌بندی‌ها
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('tasks.index') }}" class="row g-3">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" placeholder="جستجو در عنوان و توضیحات..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-select">
                                        <option value="all">همه وضعیت‌ها</option>
                                        @foreach($statuses as $key => $label)
                                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="priority" class="form-select">
                                        <option value="all">همه اولویت‌ها</option>
                                        @foreach($priorities as $key => $label)
                                            <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="assigned_to" class="form-select">
                                        <option value="all">همه کاربران</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="project_id" class="form-select">
                                        <option value="all">همه پروژه‌ها</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="btn-group" role="group">
                                <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary {{ !request('overdue') ? 'active' : '' }}">
                                    همه وظایف
                                </a>
                                <a href="{{ route('tasks.index', ['overdue' => 1]) }}" class="btn btn-outline-danger {{ request('overdue') ? 'active' : '' }}">
                                    وظایف معوق
                                </a>
                                <a href="{{ route('tasks.my-tasks') }}" class="btn btn-outline-success">
                                    وظایف من
                                </a>
                            </div>
                        </div>
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
                                    <th>پیشرفت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
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
                                                {{ \App\Helpers\DateHelper::toPersianDateTime($task->due_date) }}
                                            @else
                                                <span class="text-muted">تعین نشده</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%">
                                                    {{ $task->progress }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            هیچ وظیفه‌ای یافت نشد
                                        </td>
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
