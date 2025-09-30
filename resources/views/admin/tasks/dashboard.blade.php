@extends('admin.layout')

@section('title', 'داشبورد کارها')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="mdi mdi-view-dashboard me-2"></i>
                        داشبورد کارها
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.tasks.index') }}" class="btn btn-primary">
                            <i class="mdi mdi-format-list-checks me-1"></i>
                            لیست کارها
                        </a>
                        <a href="{{ route('admin.tasks.create') }}" class="btn btn-success">
                            <i class="mdi mdi-plus me-1"></i>
                            ایجاد کار جدید
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- آمار کلی -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                                            <p class="mb-0">کل کارها</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-format-list-checks display-4"></i>
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
                                            <h4 class="mb-0">{{ $stats['pending'] }}</h4>
                                            <p class="mb-0">در انتظار</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-clock-outline display-4"></i>
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
                                            <h4 class="mb-0">{{ $stats['in_progress'] }}</h4>
                                            <p class="mb-0">در حال انجام</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-progress-clock display-4"></i>
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
                                            <h4 class="mb-0">{{ $stats['completed'] }}</h4>
                                            <p class="mb-0">تکمیل شده</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-check-circle display-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- آمار اضافی -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ $stats['overdue'] }}</h4>
                                            <p class="mb-0">گذشته از موعد</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-alert-circle display-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card bg-secondary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ $stats['due_today'] }}</h4>
                                            <p class="mb-0">امروز</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-calendar-today display-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card bg-dark text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ $stats['due_this_week'] }}</h4>
                                            <p class="mb-0">این هفته</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-calendar-week display-4"></i>
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
                                            <h4 class="mb-0">{{ $stats['high_priority'] }}</h4>
                                            <p class="mb-0">اولویت بالا</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-priority-high display-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- کارهای گذشته از موعد -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-alert-circle me-2"></i>
                                        کارهای گذشته از موعد
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @forelse($overdueTasks as $task)
                                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $task->title }}</h6>
                                                <small class="text-muted">
                                                    @if($task->project)
                                                        پروژه: {{ $task->project->name }}
                                                    @endif
                                                    @if($task->assignedTo)
                                                        | واگذار شده به: {{ $task->assignedTo->first_name }} {{ $task->assignedTo->last_name }}
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="text-danger">
                                                    موعد: {{ $task->due_date->format('Y/m/d') }}
                                                </small>
                                            </div>
                                            <div class="ms-3">
                                                <span class="badge bg-{{ $task->priority_color }}">
                                                    {{ $task->priority_text }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-3">
                                            <i class="mdi mdi-check-circle display-4 d-block mb-2"></i>
                                            هیچ کار گذشته از موعدی وجود ندارد
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- کارهای امروز -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-calendar-today me-2"></i>
                                        کارهای امروز
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @forelse($dueTodayTasks as $task)
                                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $task->title }}</h6>
                                                <small class="text-muted">
                                                    @if($task->project)
                                                        پروژه: {{ $task->project->name }}
                                                    @endif
                                                    @if($task->assignedTo)
                                                        | واگذار شده به: {{ $task->assignedTo->first_name }} {{ $task->assignedTo->last_name }}
                                                    @endif
                                                </small>
                                                @if($task->due_time)
                                                    <br>
                                                    <small class="text-info">
                                                        زمان: {{ $task->due_time->format('H:i') }}
                                                    </small>
                                                @endif
                                            </div>
                                            <div class="ms-3">
                                                <span class="badge bg-{{ $task->priority_color }}">
                                                    {{ $task->priority_text }}
                                                </span>
                                                <span class="badge bg-{{ $task->status_color }}">
                                                    {{ $task->status_text }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-3">
                                            <i class="mdi mdi-calendar-check display-4 d-block mb-2"></i>
                                            هیچ کاری برای امروز تعین نشده
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- کارهای اخیر -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-history me-2"></i>
                                        کارهای اخیر
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>عنوان</th>
                                                    <th>نوع</th>
                                                    <th>اولویت</th>
                                                    <th>وضعیت</th>
                                                    <th>پروژه</th>
                                                    <th>واگذار شده به</th>
                                                    <th>تاریخ ایجاد</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($recentTasks as $task)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('admin.tasks.show', $task) }}" class="text-decoration-none">
                                                                {{ $task->title }}
                                                            </a>
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
                                                                {{ $task->project->name }}
                                                            @else
                                                                <span class="text-muted">بدون پروژه</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($task->assignedTo)
                                                                {{ $task->assignedTo->first_name }} {{ $task->assignedTo->last_name }}
                                                            @else
                                                                <span class="text-muted">واگذار نشده</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $task->created_at->format('Y/m/d H:i') }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted py-4">
                                                            هیچ کاری یافت نشد
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
