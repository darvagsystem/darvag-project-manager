@extends('admin.layouts.app')

@section('title', 'داشبورد کارها')

@section('content')
<div class="container-fluid">
    <!-- آمار کلی -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>کل کارها</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['pending'] }}</h3>
                    <p>در انتظار</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['in_progress'] }}</h3>
                    <p>در حال انجام</p>
                </div>
                <div class="icon">
                    <i class="fas fa-play"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['completed'] }}</h3>
                    <p>تکمیل شده</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- کارهای اخیر -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i>
                        کارهای اخیر
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>عنوان</th>
                                    <th>پروژه</th>
                                    <th>وضعیت</th>
                                    <th>اولویت</th>
                                    <th>تاریخ ایجاد</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTasks as $task)
                                    <tr>
                                        <td>
                                            <strong>{{ $task->title }}</strong>
                                            @if($task->assignedTo)
                                                <br><small class="text-muted">واگذار شده به: {{ $task->assignedTo->name }}</small>
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
                                        <td>{{ $task->created_at->format('Y/m/d') }}</td>
                                        <td>
                                            <a href="{{ route('panel.tasks.show', $task) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">هیچ کاری یافت نشد</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- کارهای من -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        کارهای من
                    </h3>
                </div>
                <div class="card-body">
                    @forelse($myTasks as $task)
                        <div class="task-item mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $task->title }}</h6>
                                    @if($task->project)
                                        <small class="text-muted">{{ $task->project->name }}</small>
                                    @endif
                                </div>
                                <span class="badge badge-{{ $task->status_color }}">
                                    {{ $task->status_text }}
                                </span>
                            </div>
                            <div class="mt-2">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%">
                                    </div>
                                </div>
                                <small class="text-muted">{{ $task->progress }}% تکمیل شده</small>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('panel.tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                    مشاهده
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">هیچ کاری به شما واگذار نشده است</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- آمار اضافی -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie"></i>
                        توزیع اولویت‌ها
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-arrow-down"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">اولویت کم</span>
                                    <span class="info-box-number">{{ $stats['low_priority'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-exclamation"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">اولویت فوری</span>
                                    <span class="info-box-number">{{ $stats['high_priority'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i>
                        آمار کلی
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">کارهای من</span>
                                    <span class="info-box-number">{{ $stats['my_tasks'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-percentage"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">درصد تکمیل</span>
                                    <span class="info-box-number">
                                        {{ $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100, 1) : 0 }}%
                                    </span>
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
