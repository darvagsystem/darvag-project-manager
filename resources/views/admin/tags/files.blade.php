@extends('admin.layout')

@section('title', 'فایل‌های تگ: ' . $tag->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title">فایل‌های تگ</h1>
                        <p class="page-subtitle">
                            <span class="badge" style="background-color: {{ $tag->color }}; color: white; font-size: 14px; padding: 6px 12px;">
                                {{ $tag->name }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('panel.tags.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> بازگشت به لیست تگ‌ها
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($files->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>نام فایل</th>
                                        <th>نوع</th>
                                        <th>اندازه</th>
                                        <th>پروژه</th>
                                        <th>بایگانی</th>
                                        <th>تاریخ آپلود</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($files as $file)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="mdi mdi-file me-2" style="color: #6c757d;"></i>
                                                    <span>{{ $file->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ strtoupper($file->extension) }}</span>
                                            </td>
                                            <td>{{ $file->human_size }}</td>
                                            <td>
                                                <a href="{{ route('projects.show', $file->archive->project) }}" class="text-decoration-none">
                                                    {{ $file->archive->project->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('archives.show', $file->archive) }}" class="text-decoration-none">
                                                    {{ $file->archive->name }}
                                                </a>
                                            </td>
                                            <td>{{ \App\Helpers\DateHelper::toPersianDateTime($file->created_at) }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('archives.files.download', $file) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="دانلود">
                                                        <i class="mdi mdi-download"></i>
                                                    </a>
                                                    <a href="{{ route('archives.show', $file->archive) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="مشاهده در بایگانی">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $files->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-file-outline" style="font-size: 64px; color: #6c757d;"></i>
                            <h5 class="mt-3">هیچ فایلی یافت نشد</h5>
                            <p class="text-muted">هیچ فایلی با این تگ وجود ندارد.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
