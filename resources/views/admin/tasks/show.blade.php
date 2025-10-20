@extends('admin.layout')

@section('title', $task->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $task->title }}</h3>
                    <div>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> ویرایش
                        </a>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> بازگشت
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Task Details -->
                        <div class="col-md-8">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>جزئیات وظیفه</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>وضعیت:</strong></td>
                                            <td>
                                                <span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'primary' : ($task->status == 'cancelled' ? 'danger' : 'warning')) }}">
                                                    {{ $task->formatted_status }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>اولویت:</strong></td>
                                            <td>
                                                <span class="badge bg-{{ $task->priority == 'urgent' ? 'danger' : ($task->priority == 'high' ? 'warning' : ($task->priority == 'low' ? 'secondary' : 'info')) }}">
                                                    {{ $task->formatted_priority }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>واگذار شده به:</strong></td>
                                            <td>{{ $task->assignedUser ? $task->assignedUser->name : 'واگذار نشده' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>ایجاد شده توسط:</strong></td>
                                            <td>{{ $task->creator->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>پروژه:</strong></td>
                                            <td>
                                                @if($task->project)
                                                    <a href="{{ route('panel.projects.show', $task->project) }}" class="text-decoration-none">
                                                        {{ $task->project->name }}
                                                    </a>
                                                @else
                                                    بدون پروژه
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>دسته‌بندی:</strong></td>
                                            <td>
                                                @if($task->category)
                                                    <span class="badge" style="background-color: {{ $task->category->color }}; color: white;">
                                                        {{ $task->category->name }}
                                                    </span>
                                                @else
                                                    بدون دسته‌بندی
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>زمان‌بندی</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>تاریخ شروع:</strong></td>
                                            <td>{{ $task->start_date ? \App\Helpers\DateHelper::toPersianDateTime($task->start_date) : 'تعین نشده' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>تاریخ سررسید:</strong></td>
                                            <td>
                                                @if($task->due_date)
                                                    <span class="{{ $task->is_overdue ? 'text-danger' : '' }}">
                                                        {{ \App\Helpers\DateHelper::toPersianDateTime($task->due_date) }}
                                                        @if($task->is_overdue)
                                                            <span class="badge bg-danger">معوق</span>
                                                        @endif
                                                    </span>
                                                @else
                                                    تعین نشده
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>تاریخ تکمیل:</strong></td>
                                            <td>{{ $task->completed_date ? \App\Helpers\DateHelper::toPersianDateTime($task->completed_date) : 'تکمیل نشده' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>ساعات تخمینی:</strong></td>
                                            <td>{{ $task->estimated_hours ? $task->estimated_hours . ' ساعت' : 'تعین نشده' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>ساعات واقعی:</strong></td>
                                            <td>{{ $task->actual_hours ? $task->actual_hours . ' ساعت' : 'ثبت نشده' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Progress -->
                            <div class="mb-4">
                                <h5>پیشرفت</h5>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%">
                                        {{ $task->progress }}%
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($task->description)
                                <div class="mb-4">
                                    <h5>توضیحات</h5>
                                    <div class="border p-3 rounded">
                                        {!! nl2br(e($task->description)) !!}
                                    </div>
                                </div>
                            @endif

                            <!-- Notes -->
                            @if($task->notes)
                                <div class="mb-4">
                                    <h5>یادداشت‌ها</h5>
                                    <div class="border p-3 rounded">
                                        {!! nl2br(e($task->notes)) !!}
                                    </div>
                                </div>
                            @endif

                            <!-- Files -->
                            <div class="mb-4">
                                <h5>فایل‌های ضمیمه</h5>
                                @if($task->files->count() > 0)
                                    <div class="row">
                                        @foreach($task->files as $file)
                                            <div class="col-md-4 mb-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <i class="{{ $file->file_icon }} fa-2x text-primary me-3"></i>
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1">{{ $file->original_name }}</h6>
                                                                <small class="text-muted">{{ $file->formatted_file_size }}</small>
                                                                @if($file->description)
                                                                    <p class="card-text mt-1">{{ $file->description }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="mt-2">
                                                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-download"></i> دانلود
                                                            </a>
                                                            <form method="POST" action="{{ route('task-files.destroy', $file) }}" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash"></i> حذف
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">هیچ فایلی ضمیمه نشده است</p>
                                @endif
                            </div>

                            <!-- Comments -->
                            <div class="mb-4">
                                <h5>نظرات و گفتگو</h5>
                                @if($task->comments->count() > 0)
                                    <div class="comments">
                                        @foreach($task->comments as $comment)
                                            <div class="comment mb-3 p-3 border rounded">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <strong>{{ $comment->user->name }}</strong>
                                                    <small class="text-muted">{{ $comment->created_at->format('Y/m/d H:i') }}</small>
                                                </div>
                                                <p class="mb-0">{{ $comment->comment }}</p>
                                                @if($comment->is_internal)
                                                    <span class="badge bg-warning">داخلی</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">هیچ نظری ثبت نشده است</p>
                                @endif
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-md-4">
                            <!-- Status Update -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6>تغییر وضعیت</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('tasks.update-status', $task) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-3">
                                            <select name="status" class="form-select">
                                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>در انتظار</option>
                                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>در حال انجام</option>
                                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                                                <option value="cancelled" {{ $task->status == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                                                <option value="on_hold" {{ $task->status == 'on_hold' ? 'selected' : '' }}>در انتظار</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">به‌روزرسانی وضعیت</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Add Comment -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6>افزودن نظر</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('tasks.add-comment', $task) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <textarea name="comment" class="form-control" rows="3" placeholder="نظر خود را بنویسید..." required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_internal" id="is_internal">
                                                <label class="form-check-label" for="is_internal">
                                                    نظر داخلی
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">افزودن نظر</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Upload File -->
                            <div class="card">
                                <div class="card-header">
                                    <h6>آپلود فایل</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('tasks.upload-file', $task) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="file" name="file" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" name="description" class="form-control" placeholder="توضیحات فایل (اختیاری)">
                                        </div>
                                        <button type="submit" class="btn btn-success w-100">آپلود فایل</button>
                                    </form>
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
