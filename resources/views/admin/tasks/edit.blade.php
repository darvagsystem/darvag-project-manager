@extends('admin.layout')

@section('title', 'ویرایش کار')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="mdi mdi-pencil me-2"></i>
                        ویرایش کار: {{ $task->title }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-right me-1"></i>
                            بازگشت
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.tasks.update', $task) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">عنوان کار <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $task->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">توضیحات</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4">{{ old('description', $task->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="type" class="form-label">نوع <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">انتخاب کنید</option>
                                        <option value="task" {{ old('type', $task->type) == 'task' ? 'selected' : '' }}>کار</option>
                                        <option value="reminder" {{ old('type', $task->type) == 'reminder' ? 'selected' : '' }}>یادآوری</option>
                                        <option value="meeting" {{ old('type', $task->type) == 'meeting' ? 'selected' : '' }}>جلسه</option>
                                        <option value="deadline" {{ old('type', $task->type) == 'deadline' ? 'selected' : '' }}>مهلت</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="priority" class="form-label">اولویت <span class="text-danger">*</span></label>
                                    <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                        <option value="">انتخاب کنید</option>
                                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>کم</option>
                                        <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>متوسط</option>
                                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>زیاد</option>
                                        <option value="urgent" {{ old('priority', $task->priority) == 'urgent' ? 'selected' : '' }}>فوری</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">وضعیت <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>در انتظار</option>
                                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>در حال انجام</option>
                                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                                        <option value="cancelled" {{ old('status', $task->status) == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="project_id" class="form-label">پروژه</label>
                                    <select class="form-select @error('project_id') is-invalid @enderror" id="project_id" name="project_id">
                                        <option value="">بدون پروژه</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="assigned_to" class="form-label">واگذار شده به</label>
                                    <select class="form-select @error('assigned_to') is-invalid @enderror" id="assigned_to" name="assigned_to">
                                        <option value="">واگذار نشده</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ old('assigned_to', $task->assigned_to) == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->first_name }} {{ $employee->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">تاریخ موعد</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                           id="due_date" name="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="due_time" class="form-label">زمان موعد</label>
                                    <input type="time" class="form-control @error('due_time') is-invalid @enderror" 
                                           id="due_time" name="due_time" value="{{ old('due_time', $task->due_time?->format('H:i')) }}">
                                    @error('due_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estimated_hours" class="form-label">ساعت تخمینی</label>
                                    <input type="number" class="form-control @error('estimated_hours') is-invalid @enderror" 
                                           id="estimated_hours" name="estimated_hours" value="{{ old('estimated_hours', $task->estimated_hours) }}" min="0">
                                    @error('estimated_hours')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="actual_hours" class="form-label">ساعت واقعی</label>
                                    <input type="number" class="form-control @error('actual_hours') is-invalid @enderror" 
                                           id="actual_hours" name="actual_hours" value="{{ old('actual_hours', $task->actual_hours) }}" min="0">
                                    @error('actual_hours')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tags" class="form-label">تگ‌ها</label>
                                    <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                           id="tags" name="tags" value="{{ old('tags', is_array($task->tags) ? implode(', ', $task->tags) : $task->tags) }}" 
                                           placeholder="تگ‌ها را با کاما جدا کنید">
                                    <small class="form-text text-muted">مثال: مهم، فوری، پروژه</small>
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_reminder" name="is_reminder" 
                                           value="1" {{ old('is_reminder', $task->is_reminder) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_reminder">
                                        یادآوری
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring" 
                                           value="1" {{ old('is_recurring', $task->is_recurring) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_recurring">
                                        تکرار شونده
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="reminder_section" style="{{ $task->is_reminder ? 'display: block;' : 'display: none;' }}">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reminder_at" class="form-label">زمان یادآوری</label>
                                    <input type="datetime-local" class="form-control @error('reminder_at') is-invalid @enderror" 
                                           id="reminder_at" name="reminder_at" value="{{ old('reminder_at', $task->reminder_at?->format('Y-m-d\TH:i')) }}">
                                    @error('reminder_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">یادداشت‌ها</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes', $task->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-check me-1"></i>
                            به‌روزرسانی کار
                        </button>
                        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-close me-1"></i>
                            انصراف
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const reminderCheckbox = document.getElementById('is_reminder');
    const reminderSection = document.getElementById('reminder_section');
    
    reminderCheckbox.addEventListener('change', function() {
        if (this.checked) {
            reminderSection.style.display = 'block';
        } else {
            reminderSection.style.display = 'none';
        }
    });
});
</script>
@endpush
