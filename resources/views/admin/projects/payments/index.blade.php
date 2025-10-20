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
                        <i class="fas fa-credit-card text-primary mr-2"></i>
                        پرداخت‌های پروژه
                    </h1>
                    <p class="text-muted mb-0">{{ $project->name }} - {{ $project->contract_number }}</p>
                </div>
                <div>
                    <a href="{{ route('panel.projects.payments.create', $project) }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i>
                        ثبت پرداخت جدید
                    </a>
                    <a href="{{ route('panel.projects.show', $project) }}" class="btn btn-outline-secondary mr-2">
                        <i class="fas fa-arrow-right mr-1"></i>
                        بازگشت به پروژه
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-credit-card fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ $statistics['total_payments'] }}</div>
                    <div class="text-white-50 small">کل پرداخت‌ها</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-money-bill-wave fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ number_format($statistics['total_amount'], 0, '.', ',') }}</div>
                    <div class="text-white-50 small">کل مبلغ (ریال)</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ number_format($statistics['completed_amount'], 0, '.', ',') }}</div>
                    <div class="text-white-50 small">پرداخت شده</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ number_format($statistics['pending_amount'], 0, '.', ',') }}</div>
                    <div class="text-white-50 small">در انتظار</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-0">
            <h5 class="card-title mb-0 text-dark">
                <i class="fas fa-filter text-primary mr-2"></i>
                فیلترها
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('panel.projects.payments.index', $project) }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status" class="text-muted small">وضعیت:</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>در انتظار</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>ناموفق</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="payment_type" class="text-muted small">نوع پرداخت:</label>
                            <select name="payment_type" id="payment_type" class="form-control">
                                <option value="">همه انواع</option>
                                <option value="salary" {{ request('payment_type') == 'salary' ? 'selected' : '' }}>حقوق</option>
                                <option value="bonus" {{ request('payment_type') == 'bonus' ? 'selected' : '' }}>پاداش</option>
                                <option value="advance" {{ request('payment_type') == 'advance' ? 'selected' : '' }}>پیش‌پرداخت</option>
                                <option value="expense" {{ request('payment_type') == 'expense' ? 'selected' : '' }}>هزینه</option>
                                <option value="contract" {{ request('payment_type') == 'contract' ? 'selected' : '' }}>قراردادی</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="recipient_type" class="text-muted small">نوع دریافت‌کننده:</label>
                            <select name="recipient_type" id="recipient_type" class="form-control">
                                <option value="">همه انواع</option>
                                <option value="employee" {{ request('recipient_type') == 'employee' ? 'selected' : '' }}>پرسنل</option>
                                <option value="contractor" {{ request('recipient_type') == 'contractor' ? 'selected' : '' }}>پیمانکار</option>
                                <option value="supplier" {{ request('recipient_type') == 'supplier' ? 'selected' : '' }}>تامین‌کننده</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="text-muted small">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search mr-1"></i>
                                    جستجو
                                </button>
                                <a href="{{ route('panel.projects.payments.index', $project) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times mr-1"></i>
                                    پاک کردن
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Payments List -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="card-title mb-0 text-dark">
                <i class="fas fa-list text-primary mr-2"></i>
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
                                <th class="border-0 text-center">مبلغ</th>
                                <th class="border-0 text-center">نوع</th>
                                <th class="border-0 text-center">روش</th>
                                <th class="border-0 text-center">تاریخ</th>
                                <th class="border-0 text-center">وضعیت</th>
                                <th class="border-0 text-center">فیش</th>
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
                                        <span class="font-weight-bold text-dark">{{ number_format($payment->amount, 0, '.', ',') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $payment->currency }}</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-info px-2 py-1">
                                            {{ $payment->payment_type }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-secondary px-2 py-1">
                                            {{ $payment->payment_method }}
                                        </span>
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
                                        @if($payment->receipts->count() > 0)
                                            <span class="badge badge-success px-2 py-1">
                                                <i class="fas fa-file-alt mr-1"></i>
                                                {{ $payment->receipts->count() }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
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
                        {{ $payments->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-credit-card fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">هیچ پرداختی یافت نشد</h5>
                    <p class="text-muted">برای این پروژه هنوز پرداختی ثبت نشده است.</p>
                    <a href="{{ route('panel.projects.payments.create', $project) }}" class="btn btn-primary">
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
