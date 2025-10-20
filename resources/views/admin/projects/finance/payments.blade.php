@extends('admin.layout')

@section('title', 'پرداخت‌های پروژه - ' . $project->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-credit-card text-info mr-2"></i>
                        پرداخت‌های پروژه
                    </h1>
                    <p class="text-muted mb-0">{{ $project->name }} - {{ $project->contract_number }}</p>
                </div>
                <div>
                    <a href="{{ route('panel.projects.finance.dashboard', $project) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right mr-1"></i>
                        بازگشت به داشبورد
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments List -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="card-title mb-0 text-dark">
                <i class="fas fa-list text-info mr-2"></i>
                لیست پرداخت‌ها
                @if($payments->total() > 0)
                    <span class="badge badge-light ml-2">{{ $payments->total() }} پرداخت</span>
                @endif
            </h5>
        </div>
        <div class="card-body p-0">
            @if($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">دریافت‌کننده</th>
                                <th class="border-0 text-center">نوع پرداخت</th>
                                <th class="border-0 text-center">مبلغ</th>
                                <th class="border-0 text-center">روش پرداخت</th>
                                <th class="border-0 text-center">تاریخ</th>
                                <th class="border-0 text-center">وضعیت</th>
                                <th class="border-0 text-center">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-2"
                                                 style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">
                                                {{ substr($payment->recipient->recipient_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark">{{ $payment->recipient->recipient_name }}</div>
                                                <small class="text-muted">{{ $payment->recipient->recipient_code }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($payment->paymentType)
                                            <span class="badge" style="background-color: {{ $payment->paymentType->color }}; color: white;">
                                                @if($payment->paymentType->icon)
                                                    <i class="{{ $payment->paymentType->icon }} mr-1"></i>
                                                @endif
                                                {{ $payment->paymentType->name }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">نامشخص</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="font-weight-bold text-dark">{{ number_format($payment->amount, 0, '.', ',') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $payment->currency }}</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-secondary px-2 py-1">{{ $payment->payment_method }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-muted">{{ $payment->payment_date->format('Y/m/d') }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-{{ $payment->status_color }} px-3 py-2">
                                            {{ $payment->status_text }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('panel.projects.payments.show', [$project, $payment]) }}"
                                               class="btn btn-sm btn-outline-primary" title="مشاهده">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('panel.projects.payments.edit', [$project, $payment]) }}"
                                               class="btn btn-sm btn-outline-warning" title="ویرایش">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="حذف"
                                                    onclick="confirmDelete({{ $payment->id }}, '{{ $payment->recipient->recipient_name }}')">
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
                            نمایش {{ $payments->firstItem() }} تا {{ $payments->lastItem() }} از {{ $payments->total() }} پرداخت
                        </span>
                    </div>
                    <div>
                        {{ $payments->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-credit-card fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">هیچ پرداختی یافت نشد</h5>
                    <p class="text-muted">برای این پروژه هنوز پرداختی ثبت نشده است.</p>
                    <a href="{{ route('panel.projects.payments.create', $project) }}" class="btn btn-info">
                        <i class="fas fa-plus mr-1"></i>
                        ثبت اولین پرداخت
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
                <p>آیا از حذف این پرداخت اطمینان دارید؟</p>
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
function confirmDelete(paymentId, recipientName) {
    document.getElementById('deleteModalLabel').textContent = 'تایید حذف پرداخت - ' + recipientName;
    document.getElementById('deleteForm').action = '{{ route("panel.projects.payments.destroy", [$project, ":id"]) }}'.replace(':id', paymentId);
    $('#deleteModal').modal('show');
}
</script>
@endsection
