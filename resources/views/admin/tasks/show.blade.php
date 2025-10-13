@extends('admin.layout')

@section('title', 'جزئیات کار')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <!-- اطلاعات اصلی کار -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tasks"></i>
                        {{ $task->title }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('panel.tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                            ویرایش
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>وضعیت:</strong>
                                <span class="badge badge-{{ $task->status_color }}">
                                    {{ $task->status_text }}
                                </span>
                            </p>
                            <p><strong>اولویت:</strong>
                                <span class="badge badge-{{ $task->priority_color }}">
                                    {{ $task->priority_text }}
                                </span>
                            </p>
                            <p><strong>پروژه:</strong>
                                @if($task->project)
                                    {{ $task->project->name }}
                                @else
                                    <span class="text-muted">بدون پروژه</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>واگذار شده به:</strong>
                                @if($task->assignedTo)
                                    {{ $task->assignedTo->name }}
                                @else
                                    <span class="text-muted">واگذار نشده</span>
                                @endif
                            </p>
                            <p><strong>ایجاد شده توسط:</strong> {{ $task->createdBy->name }}</p>
                            <p><strong>تاریخ موعد:</strong>
                                @if($task->due_date)
                                    {{ $task->due_date->format('Y/m/d') }}
                                @else
                                    <span class="text-muted">تعیین نشده</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($task->description)
                        <hr>
                        <h5>توضیحات:</h5>
                        <p>{{ $task->description }}</p>
                    @endif

                    @if($task->notes)
                        <hr>
                        <h5>یادداشت‌ها:</h5>
                        <p>{{ $task->notes }}</p>
                    @endif

                    <hr>
                    <h5>پیشرفت:</h5>
                    <div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%">
                            {{ $task->progress }}%
                        </div>
                    </div>
                </div>
            </div>

            <!-- نظرات -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-comments"></i>
                        نظرات
                    </h5>
                </div>
                <div class="card-body">
                    <div id="comments-list">
                        @foreach($task->comments as $comment)
                            <div class="comment-item mb-3 p-3 border rounded">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <small class="text-muted">{{ $comment->created_at->format('Y/m/d H:i') }}</small>
                                </div>
                                <p class="mt-2 mb-0">{{ $comment->comment }}</p>
                                @if($comment->is_internal)
                                    <small class="text-warning">
                                        <i class="fas fa-lock"></i>
                                        داخلی
                                    </small>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <form id="comment-form">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name="comment" rows="3" placeholder="نظر خود را بنویسید..." required></textarea>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_internal" id="is_internal">
                                <label class="form-check-label" for="is_internal">
                                    نظر داخلی
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            ارسال نظر
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- اقدامات سریع -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-bolt"></i>
                        اقدامات سریع
                    </h5>
                </div>
                <div class="card-body">
                    @if($task->canBeStartedBy(auth()->id()))
                        <button class="btn btn-success btn-block mb-2" onclick="startTask({{ $task->id }})">
                            <i class="fas fa-play"></i>
                            شروع کار
                        </button>
                    @endif

                    @if($task->canBeCompletedBy(auth()->id()))
                        <button class="btn btn-primary btn-block mb-2" onclick="completeTask({{ $task->id }})">
                            <i class="fas fa-check"></i>
                            تکمیل کار
                        </button>
                    @endif

                    <a href="{{ route('panel.tasks.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-right"></i>
                        بازگشت به لیست
                    </a>
                </div>
            </div>

            <!-- فایل‌های ضمیمه -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-paperclip"></i>
                        فایل‌های ضمیمه
                    </h5>
                </div>
                <div class="card-body">
                    <div id="attachments-list">
                        @foreach($task->attachments as $attachment)
                            <div class="attachment-item mb-2 p-2 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file"></i>
                                        {{ $attachment->original_name }}
                                        <br>
                                        <small class="text-muted">{{ $attachment->file_size_formatted }}</small>
                                    </div>
                                    <a href="{{ $attachment->download_url }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form id="upload-form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-info btn-block">
                            <i class="fas fa-upload"></i>
                            آپلود فایل
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// شروع کار
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

// تکمیل کار
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

// ارسال نظر
document.getElementById('comment-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`/panel/tasks/{{ $task->id }}/add-comment`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    });
});

// آپلود فایل
document.getElementById('upload-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`/panel/tasks/{{ $task->id }}/upload-file`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    });
});
</script>
@endpush
