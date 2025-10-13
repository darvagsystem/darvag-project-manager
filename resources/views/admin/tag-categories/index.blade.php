@extends('admin.layout')

@section('title', 'دسته‌بندی تگ‌ها')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">دسته‌بندی تگ‌ها</h3>
                    <a href="{{ route('panel.tag-categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> دسته‌بندی جدید
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($tagCategories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>نام</th>
                                        <th>رنگ</th>
                                        <th>اولویت</th>
                                        <th>الزامی</th>
                                        <th>پروژه‌های مورد نیاز</th>
                                        <th>تعداد تگ‌ها</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tagCategories as $category)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2" style="width: 20px; height: 20px; background-color: {{ $category->color }}; border-radius: 4px;"></div>
                                                    <strong>{{ $category->name }}</strong>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge" style="background-color: {{ $category->color }}; color: white;">
                                                    {{ $category->color }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $category->sort_order }}</span>
                                            </td>
                                            <td>
                                                @if($category->is_required)
                                                    <span class="badge bg-danger">الزامی</span>
                                                @else
                                                    <span class="badge bg-secondary">اختیاری</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($category->is_required)
                                                    <small class="text-muted">{{ $category->required_for_projects_text }}</small>
                                                @else
                                                    <small class="text-muted">-</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $category->tags->count() }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('panel.tag-categories.show', $category) }}" class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('panel.tag-categories.edit', $category) }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('panel.tag-categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">هیچ دسته‌بندی تگی وجود ندارد</h5>
                            <p class="text-muted">برای شروع، یک دسته‌بندی جدید ایجاد کنید.</p>
                            <a href="{{ route('panel.tag-categories.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> ایجاد دسته‌بندی جدید
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
