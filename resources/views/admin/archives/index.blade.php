@extends('admin.layout')

@section('title', 'بایگانی پروژه‌ها')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title">بایگانی پروژه‌ها</h1>
                        <p class="page-subtitle">مدیریت بایگانی و فایل‌های پروژه‌ها</p>
                    </div>
                    <div>
                        <a href="{{ route('archives.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> ایجاد بایگانی جدید
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if($archives->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>نام بایگانی</th>
                                        <th>پروژه</th>
                                        <th>وضعیت تکمیل</th>
                                        <th>تعداد فایل‌ها</th>
                                        <th>ایجاد شده توسط</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($archives as $archive)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="mdi mdi-archive me-2 text-primary"></i>
                                                    <div>
                                                        <div class="fw-semibold">{{ $archive->name }}</div>
                                                        @if($archive->description)
                                                            <small class="text-muted">{{ Str::limit($archive->description, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('panel.projects.show', $archive->project->id) }}"
                                                   class="text-decoration-none">
                                                    {{ $archive->project->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 100px; height: 8px;">
                                                        <div class="progress-bar bg-{{ $archive->is_complete ? 'success' : 'warning' }}"
                                                             style="width: {{ $archive->getCompletionPercentage() }}%"></div>
                                                    </div>
                                                    <span class="badge bg-{{ $archive->is_complete ? 'success' : 'warning' }}">
                                                        {{ $archive->getCompletionPercentage() }}%
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $archive->files->count() }} فایل</span>
                                            </td>
                                            <td>{{ $archive->creator->name }}</td>
                                            <td>{{ \App\Helpers\DateHelper::toPersianDateTime($archive->created_at) }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('archives.show', $archive) }}"
                                                       class="btn btn-outline-primary" title="مشاهده">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('archives.edit', $archive) }}"
                                                       class="btn btn-outline-warning" title="ویرایش">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger"
                                                            onclick="deleteArchive({{ $archive->id }})" title="حذف">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $archives->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-archive-outline" style="font-size: 64px; color: #6c757d;"></i>
                            <h5 class="mt-3">هیچ بایگانی وجود ندارد</h5>
                            <p class="text-muted">برای شروع، یک بایگانی جدید ایجاد کنید</p>
                            <a href="{{ route('archives.create') }}" class="btn btn-primary">
                                <i class="mdi mdi-plus me-1"></i> ایجاد بایگانی جدید
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأیید حذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                آیا از حذف این بایگانی اطمینان دارید؟ این عمل غیرقابل بازگشت است.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteArchive(archiveId) {
    document.getElementById('deleteForm').action = '/panel/archives/' + archiveId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
