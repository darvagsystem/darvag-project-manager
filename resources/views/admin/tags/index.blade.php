@extends('admin.layout')

@section('title', 'مدیریت تگ‌ها')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">مدیریت تگ‌ها</h1>
            <p class="page-subtitle">ایجاد و مدیریت تگ‌های فایل‌ها</p>
        </div>
        <div>
            <a href="{{ route('panel.tags.create') }}" class="btn btn-primary">
                <i class="mdi mdi-plus"></i> تگ جدید
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($tags->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>نام تگ</th>
                                    <th>رنگ</th>
                                    <th>نوع</th>
                                    <th>محدودیت‌ها</th>
                                    <th>تعداد فایل‌ها</th>
                                    <th>تاریخ ایجاد</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tags as $tag)
                                    <tr>
                                        <td>
                                            <span class="badge" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}; border: 1px solid {{ $tag->color }}40;">
                                                {{ $tag->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="color-preview" style="width: 30px; height: 20px; background-color: {{ $tag->color }}; border-radius: 4px; border: 1px solid #ddd;"></div>
                                        </td>
                                        <td>
                                            @if($tag->is_folder_tag)
                                                <span class="badge bg-warning">پوشه</span>
                                            @else
                                                <span class="badge bg-info">فایل</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="small">
                                                @if($tag->allowed_extensions)
                                                    <div><strong>پسوند:</strong> {{ $tag->getAllowedExtensionsText() }}</div>
                                                @endif
                                                @if($tag->allowed_mime_types)
                                                    <div><strong>MIME:</strong> {{ $tag->getAllowedMimeTypesText() }}</div>
                                                @endif
                                                @if(!$tag->allowed_extensions && !$tag->allowed_mime_types)
                                                    <span class="text-muted">بدون محدودیت</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('panel.tags.files', $tag) }}" class="badge bg-info text-decoration-none" style="cursor: pointer;">
                                                {{ $tag->files->count() }}
                                            </a>
                                        </td>
                                        <td>{{ $tag->created_at->format('Y/m/d H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('panel.tags.files', $tag) }}" class="btn btn-sm btn-outline-info" title="مشاهده فایل‌ها">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                                <a href="{{ route('panel.tags.edit', $tag) }}" class="btn btn-sm btn-outline-primary" title="ویرایش">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <form action="{{ route('panel.tags.destroy', $tag) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                                        <i class="mdi mdi-delete"></i>
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
                        <i class="mdi mdi-tag-outline" style="font-size: 64px; color: #6c757d;"></i>
                        <h5 class="mt-3">هیچ تگی وجود ندارد</h5>
                        <p class="text-muted">برای شروع، اولین تگ خود را ایجاد کنید</p>
                        <a href="{{ route('panel.tags.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> ایجاد تگ جدید
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
