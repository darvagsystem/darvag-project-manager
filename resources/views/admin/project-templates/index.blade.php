@extends('admin.layout')

@section('title', 'قالب‌های پروژه')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item active">قالب‌های پروژه</li>
                    </ol>
                </div>
                <h4 class="page-title">قالب‌های پروژه</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">لیست قالب‌های پروژه</h5>
                        <a href="{{ route('admin.project-templates.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i>
                            ایجاد قالب جدید
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($templates->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>نام قالب</th>
                                        <th>توضیحات</th>
                                        <th>ایجاد کننده</th>
                                        <th>وضعیت</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($templates as $template)
                                        <tr>
                                            <td>
                                                <strong>{{ $template->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ $template->description ? Str::limit($template->description, 50) : 'بدون توضیحات' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $template->creator->name ?? 'نامشخص' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($template->is_active)
                                                    <span class="badge bg-success">فعال</span>
                                                @else
                                                    <span class="badge bg-secondary">غیرفعال</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $template->created_at->format('Y/m/d H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.project-templates.show', $template->id) }}"
                                                       class="btn btn-sm btn-outline-info" title="مشاهده">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.project-templates.edit', $template->id) }}"
                                                       class="btn btn-sm btn-outline-warning" title="ویرایش">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                            onclick="confirmDelete({{ $template->id }})" title="حذف">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-folder-template" style="font-size: 64px; color: #6c757d;"></i>
                            <h5 class="mt-3">هیچ قالبی یافت نشد</h5>
                            <p class="text-muted">برای شروع، اولین قالب پروژه خود را ایجاد کنید</p>
                            <a href="{{ route('admin.project-templates.create') }}" class="btn btn-primary">
                                <i class="mdi mdi-plus me-1"></i>
                                ایجاد قالب جدید
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">تأیید حذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                آیا مطمئن هستید که می‌خواهید این قالب را حذف کنید؟
                <br>
                <small class="text-warning">این عمل غیرقابل بازگشت است.</small>
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

@section('scripts')
<script>
function confirmDelete(templateId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `{{ url('admin/project-templates') }}/${templateId}`;

    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endsection
