@extends('admin.layout')

@section('title', 'ویرایش وظیفه: ' . $task->title)

@push('scripts')
<script src="{{ asset('js/persian-date.js') }}"></script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش وظیفه: {{ $task->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary">
                            <i class="fas fa-eye"></i> مشاهده
                        </a>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> بازگشت
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">عنوان وظیفه <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ old('title', $task->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">توضیحات</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="4">{{ old('description', $task->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="notes" class="form-label">یادداشت‌ها</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror"
                                              id="notes" name="notes" rows="3">{{ old('notes', $task->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">وضعیت <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>در انتظار</option>
                                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>در حال انجام</option>
                                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                                        <option value="cancelled" {{ old('status', $task->status) == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                                        <option value="on_hold" {{ old('status', $task->status) == 'on_hold' ? 'selected' : '' }}>در انتظار</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="priority" class="form-label">اولویت <span class="text-danger">*</span></label>
                                    <select class="form-select @error('priority') is-invalid @enderror"
                                            id="priority" name="priority" required>
                                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>پایین</option>
                                        <option value="normal" {{ old('priority', $task->priority) == 'normal' ? 'selected' : '' }}>عادی</option>
                                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>بالا</option>
                                        <option value="urgent" {{ old('priority', $task->priority) == 'urgent' ? 'selected' : '' }}>فوری</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="assigned_to" class="form-label">واگذار شده به</label>
                                    <select class="form-select @error('assigned_to') is-invalid @enderror"
                                            id="assigned_to" name="assigned_to">
                                        <option value="">انتخاب کنید...</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="project_id" class="form-label">پروژه</label>
                                    <select class="form-select @error('project_id') is-invalid @enderror"
                                            id="project_id" name="project_id">
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

                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">دسته‌بندی</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id">
                                        <option value="">بدون دسته‌بندی</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="due_date" class="form-label">تاریخ سررسید</label>
                                    <input type="text" class="form-control persian-date @error('due_date') is-invalid @enderror"
                                           id="due_date" name="due_date"
                                           value="{{ old('due_date', $task->due_date ? \App\Helpers\DateHelper::toPersianDateTime($task->due_date) : '') }}"
                                           placeholder="مثال: 1403/08/27 14:30">
                                    <small class="form-text text-muted">فرمت: سال/ماه/روز ساعت:دقیقه</small>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="start_date" class="form-label">تاریخ شروع</label>
                                    <input type="text" class="form-control persian-date @error('start_date') is-invalid @enderror"
                                           id="start_date" name="start_date"
                                           value="{{ old('start_date', $task->start_date ? \App\Helpers\DateHelper::toPersianDateTime($task->start_date) : '') }}"
                                           placeholder="مثال: 1403/08/27 09:00">
                                    <small class="form-text text-muted">فرمت: سال/ماه/روز ساعت:دقیقه</small>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="estimated_hours" class="form-label">ساعات تخمینی</label>
                                    <input type="number" step="0.5" min="0" class="form-control @error('estimated_hours') is-invalid @enderror"
                                           id="estimated_hours" name="estimated_hours"
                                           value="{{ old('estimated_hours', $task->estimated_hours) }}">
                                    @error('estimated_hours')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="actual_hours" class="form-label">ساعات واقعی</label>
                                    <input type="number" step="0.5" min="0" class="form-control @error('actual_hours') is-invalid @enderror"
                                           id="actual_hours" name="actual_hours"
                                           value="{{ old('actual_hours', $task->actual_hours) }}">
                                    @error('actual_hours')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="progress" class="form-label">پیشرفت (درصد) <span class="text-danger">*</span></label>
                                    <input type="number" min="0" max="100" class="form-control @error('progress') is-invalid @enderror"
                                           id="progress" name="progress"
                                           value="{{ old('progress', $task->progress) }}" required>
                                    @error('progress')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> انصراف
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> به‌روزرسانی وظیفه
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
