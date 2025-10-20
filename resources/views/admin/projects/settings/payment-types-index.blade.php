@extends('admin.layout')

@section('title', 'مدیریت انواع پرداخت')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-credit-card text-primary mr-2"></i>
                        مدیریت انواع پرداخت
                    </h1>
                    <p class="text-muted mb-0">مدیریت انواع مختلف پرداخت‌ها</p>
                </div>
                <div>
                    <a href="{{ route('panel.projects.settings.payment-types.create', $project) }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i>
                        افزودن نوع جدید
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Types List -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="card-title mb-0 text-dark">
                <i class="fas fa-list text-primary mr-2"></i>
                لیست انواع پرداخت
                @if($paymentTypes->total() > 0)
                    <span class="badge badge-light ml-2">{{ $paymentTypes->total() }} نوع</span>
                @endif
            </h5>
        </div>
        <div class="card-body p-0">
            @if($paymentTypes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">نام</th>
                                <th class="border-0 text-center">کد</th>
                                <th class="border-0 text-center">آیکون</th>
                                <th class="border-0 text-center">رنگ</th>
                                <th class="border-0 text-center">نیاز به فیش</th>
                                <th class="border-0 text-center">وضعیت</th>
                                <th class="border-0 text-center">ترتیب</th>
                                <th class="border-0 text-center">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentTypes as $paymentType)
                                <tr>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            @if($paymentType->icon)
                                                <i class="{{ $paymentType->icon }} mr-2" style="color: {{ $paymentType->color }};"></i>
                                            @endif
                                            <div>
                                                <div class="font-weight-bold text-dark">{{ $paymentType->name }}</div>
                                                @if($paymentType->description)
                                                    <small class="text-muted">{{ Str::limit($paymentType->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-secondary px-2 py-1">{{ $paymentType->code }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($paymentType->icon)
                                            <i class="{{ $paymentType->icon }} fa-lg" style="color: {{ $paymentType->color }};"></i>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="rounded-circle mr-2" style="width: 20px; height: 20px; background-color: {{ $paymentType->color }};"></div>
                                            <span class="text-muted small">{{ $paymentType->color }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($paymentType->requires_receipt)
                                            <span class="badge badge-success px-2 py-1">بله</span>
                                        @else
                                            <span class="badge badge-secondary px-2 py-1">خیر</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-{{ $paymentType->is_active ? 'success' : 'danger' }} px-3 py-2">
                                            {{ $paymentType->is_active ? 'فعال' : 'غیرفعال' }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-light px-2 py-1">{{ $paymentType->sort_order }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('panel.projects.settings.payment-types.show', [$project, $paymentType]) }}"
                                               class="btn btn-sm btn-outline-primary" title="مشاهده">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('panel.projects.settings.payment-types.edit', [$project, $paymentType]) }}"
                                               class="btn btn-sm btn-outline-warning" title="ویرایش">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm {{ $paymentType->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                    title="{{ $paymentType->is_active ? 'غیرفعال کردن' : 'فعال کردن' }}"
                                                    onclick="toggleStatus({{ $paymentType->id }}, {{ $paymentType->is_active ? 'false' : 'true' }})">
                                                <i class="fas fa-{{ $paymentType->is_active ? 'times' : 'check' }}"></i>
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="حذف"
                                                    onclick="confirmDelete({{ $paymentType->id }}, '{{ $paymentType->name }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div>
                        <span class="text-muted small">
                            نمایش {{ $paymentTypes->firstItem() }} تا {{ $paymentTypes->lastItem() }} از {{ $paymentTypes->total() }} نوع
                        </span>
                    </div>
                    <div>
                        {{ $paymentTypes->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-credit-card fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">هیچ نوع پرداختی یافت نشد</h5>
                    <p class="text-muted">هنوز هیچ نوع پرداختی تعریف نشده است.</p>
                    <a href="{{ route('panel.projects.settings.payment-types.create', $project) }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i>
                        افزودن اولین نوع پرداخت
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">تایید حذف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>آیا از حذف این نوع پرداخت اطمینان دارید؟</p>
                <p class="text-muted small">این عمل قابل بازگشت نیست.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleStatus(paymentTypeId, newStatus) {
    fetch(`/panel/projects/{{ $project->id }}/settings/payment-types/${paymentTypeId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            is_active: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('خطا در تغییر وضعیت: ' + (data.message || 'خطای نامشخص'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در تغییر وضعیت');
    });
}

function confirmDelete(paymentTypeId, paymentTypeName) {
    document.getElementById('deleteModalLabel').textContent = 'تایید حذف نوع پرداخت - ' + paymentTypeName;
    document.getElementById('deleteForm').action = `/panel/projects/{{ $project->id }}/settings/payment-types/${paymentTypeId}`;
    $('#deleteModal').modal('show');
}
</script>
@endsection
