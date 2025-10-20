@extends('admin.layout')

@section('title', 'مدیریت دسته‌بندی وظایف')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">مدیریت دسته‌بندی وظایف</h3>
                    <div>
                        <a href="{{ route('task-categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> دسته‌بندی جدید
                        </a>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-tasks"></i> وظایف
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>نام</th>
                                    <th>رنگ</th>
                                    <th>آیکون</th>
                                    <th>تعداد وظایف</th>
                                    <th>وظایف فعال</th>
                                    <th>وضعیت</th>
                                    <th>ترتیب</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $category->name }}</strong>
                                                @if($category->description)
                                                    <br><small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="color-preview me-2" style="width: 20px; height: 20px; background-color: {{ $category->color }}; border-radius: 3px;"></div>
                                                <span>{{ $category->color }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($category->icon)
                                                <i class="{{ $category->icon }}"></i>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $category->task_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $category->active_task_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $category->is_active ? 'success' : 'danger' }}">
                                                {{ $category->is_active ? 'فعال' : 'غیرفعال' }}
                                            </span>
                                        </td>
                                        <td>{{ $category->sort_order }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('task-categories.show', $category) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('task-categories.edit', $category) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('task-categories.toggle-status', $category) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-{{ $category->is_active ? 'danger' : 'success' }}">
                                                        <i class="fas fa-{{ $category->is_active ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('task-categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
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
                                        <td colspan="8" class="text-center text-muted py-4">
                                            هیچ دسته‌بندی‌ای یافت نشد
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
