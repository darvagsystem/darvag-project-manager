@extends('admin.layout')

@section('title', 'مشاهده نوع پرداخت')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-eye text-primary mr-2"></i>
                        مشاهده نوع پرداخت
                    </h1>
                    <p class="text-muted mb-0">جزئیات نوع پرداخت: {{ $paymentType->name }}</p>
                </div>
                <div>
                    <a href="{{ route('panel.projects.settings.payment-types.index', $project) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right mr-1"></i>
                        بازگشت به لیست
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        اطلاعات نوع پرداخت
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label text-muted">نام</label>
                                <div class="form-control-plaintext">{{ $paymentType->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label text-muted">کد</label>
                                <div class="form-control-plaintext">
                                    <span class="badge badge-secondary">{{ $paymentType->code }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label text-muted">آیکون</label>
                                <div class="form-control-plaintext">
                                    @if($paymentType->icon)
                                        <i class="{{ $paymentType->icon }} fa-2x" style="color: {{ $paymentType->color }};"></i>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label text-muted">رنگ</label>
                                <div class="form-control-plaintext">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle mr-2" style="width: 30px; height: 30px; background-color: {{ $paymentType->color }}; border: 2px solid #ddd;"></div>
                                        <span class="text-muted">{{ $paymentType->color }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label text-muted">نیاز به فیش</label>
                                <div class="form-control-plaintext">
                                    @if($paymentType->requires_receipt)
                                        <span class="badge badge-success">بله</span>
                                    @else
                                        <span class="badge badge-secondary">خیر</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label text-muted">وضعیت</label>
                                <div class="form-control-plaintext">
                                    <span class="badge badge-{{ $paymentType->is_active ? 'success' : 'danger' }}">
                                        {{ $paymentType->is_active ? 'فعال' : 'غیرفعال' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label text-muted">ترتیب</label>
                                <div class="form-control-plaintext">{{ $paymentType->sort_order }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label text-muted">تاریخ ایجاد</label>
                                <div class="form-control-plaintext">{{ $paymentType->created_at->format('Y/m/d H:i') }}</div>
                            </div>
                        </div>
                        @if($paymentType->description)
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="form-label text-muted">توضیحات</label>
                                <div class="form-control-plaintext">{{ $paymentType->description }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-cogs text-primary mr-2"></i>
                        عملیات
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('panel.projects.settings.payment-types.edit', [$project, $paymentType]) }}" class="btn btn-warning">
                            <i class="fas fa-edit mr-1"></i>
                            ویرایش
                        </a>
                        <button type="button" class="btn {{ $paymentType->is_active ? 'btn-danger' : 'btn-success' }}"
                                onclick="toggleStatus({{ $paymentType->id }}, {{ $paymentType->is_active ? 'false' : 'true' }})">
                            <i class="fas fa-{{ $paymentType->is_active ? 'times' : 'check' }} mr-1"></i>
                            {{ $paymentType->is_active ? 'غیرفعال کردن' : 'فعال کردن' }}
                        </button>
                        <button type="button" class="btn btn-outline-danger"
                                onclick="confirmDelete({{ $paymentType->id }}, '{{ $paymentType->name }}')">
                            <i class="fas fa-trash mr-1"></i>
                            حذف
                        </button>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-chart-bar text-primary mr-2"></i>
                        آمار
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="h3 text-primary mb-1">{{ $paymentType->payments->count() }}</div>
                        <div class="text-muted small">تعداد پرداخت‌ها</div>
                    </div>
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
