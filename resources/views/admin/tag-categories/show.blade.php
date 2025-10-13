@extends('admin.layout')

@section('title', 'جزئیات دسته‌بندی تگ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">جزئیات دسته‌بندی تگ: {{ $tagCategory->name }}</h3>
                    <div class="btn-group">
                        <a href="{{ route('panel.tag-categories.edit', $tagCategory) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> ویرایش
                        </a>
                        <a href="{{ route('panel.tag-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> بازگشت
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="200"><strong>نام:</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2" style="width: 20px; height: 20px; background-color: {{ $tagCategory->color }}; border-radius: 4px;"></div>
                                            <span>{{ $tagCategory->name }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>رنگ:</strong></td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $tagCategory->color }}; color: white;">
                                            {{ $tagCategory->color }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>توضیحات:</strong></td>
                                    <td>{{ $tagCategory->description ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>اولویت نمایش:</strong></td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $tagCategory->sort_order }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>وضعیت الزامی:</strong></td>
                                    <td>
                                        @if($tagCategory->is_required)
                                            <span class="badge bg-danger">الزامی</span>
                                        @else
                                            <span class="badge bg-secondary">اختیاری</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($tagCategory->is_required)
                                <tr>
                                    <td><strong>پروژه‌های مورد نیاز:</strong></td>
                                    <td>{{ $tagCategory->required_for_projects_text }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td><strong>تاریخ ایجاد:</strong></td>
                                    <td>{{ $tagCategory->created_at->format('Y/m/d H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>آخرین به‌روزرسانی:</strong></td>
                                    <td>{{ $tagCategory->updated_at->format('Y/m/d H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">آمار</h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <h2 class="text-primary">{{ $tagCategory->tags->count() }}</h2>
                                        <p class="text-muted mb-0">تعداد تگ‌ها</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($tagCategory->tags->count() > 0)
                        <hr>
                        <h5>تگ‌های این دسته‌بندی</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>نام تگ</th>
                                        <th>نوع</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tagCategory->tags as $tag)
                                        <tr>
                                            <td>
                                                <span class="badge" style="background-color: {{ $tagCategory->color }}; color: white;">
                                                    {{ $tag->name }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($tag->is_folder_tag)
                                                    <span class="badge bg-info">پوشه</span>
                                                @else
                                                    <span class="badge bg-success">فایل</span>
                                                @endif
                                            </td>
                                            <td>{{ $tag->created_at->format('Y/m/d') }}</td>
                                            <td>
                                                <a href="{{ route('panel.tags.edit', $tag) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
