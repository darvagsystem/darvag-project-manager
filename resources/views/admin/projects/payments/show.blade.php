@extends('admin.layout')

@section('title', 'جزئیات پرداخت - ' . $payment->recipient->recipient_name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-credit-card text-primary mr-2"></i>
                        جزئیات پرداخت
                    </h1>
                    <p class="text-muted mb-0">{{ $project->name }} - {{ $project->contract_number }}</p>
                </div>
                <div>
                    <a href="{{ route('panel.projects.payments.edit', [$project, $payment]) }}" class="btn btn-warning">
                        <i class="fas fa-edit mr-1"></i>
                        ویرایش
                    </a>
                    <a href="{{ route('panel.projects.payments.index', $project) }}" class="btn btn-outline-secondary mr-2">
                        <i class="fas fa-arrow-right mr-1"></i>
                        بازگشت به لیست
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Payment Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        اطلاعات پرداخت
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">دریافت‌کننده:</label>
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
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">مبلغ:</label>
                                <div class="h4 text-primary mb-0">
                                    {{ number_format($payment->amount, 0, '.', ',') }} {{ $payment->currency }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="text-muted small">نوع پرداخت:</label>
                                <div>
                                    <span class="badge badge-info px-3 py-2">{{ $payment->payment_type }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="text-muted small">روش پرداخت:</label>
                                <div>
                                    <span class="badge badge-secondary px-3 py-2">{{ $payment->payment_method }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="text-muted small">وضعیت:</label>
                                <div>
                                    <span class="badge badge-{{ $payment->status_color }} px-3 py-2">
                                        {{ $payment->status_text }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">تاریخ پرداخت:</label>
                                <div class="text-dark">{{ $payment->payment_date->format('Y/m/d') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">شماره مرجع:</label>
                                <div class="text-dark">{{ $payment->reference_number ?: '-' }}</div>
                            </div>
                        </div>
                    </div>

                    @if($payment->description)
                        <div class="mb-3">
                            <label class="text-muted small">توضیحات:</label>
                            <div class="text-dark">{{ $payment->description }}</div>
                        </div>
                    @endif

                    @if($payment->notes)
                        <div class="mb-3">
                            <label class="text-muted small">یادداشت‌ها:</label>
                            <div class="text-dark">{{ $payment->notes }}</div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">ثبت شده توسط:</label>
                                <div class="text-dark">{{ $payment->creator->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">تاریخ ثبت:</label>
                                <div class="text-dark">{{ $payment->created_at->format('Y/m/d H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Receipts -->
            @if($payment->receipts->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0 text-dark">
                            <i class="fas fa-file-alt text-primary mr-2"></i>
                            فیش‌های واریز
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($payment->receipts as $receipt)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card border">
                                        <div class="card-body text-center">
                                            @if($receipt->receipt_type == 'image')
                                                <img src="{{ $receipt->file_url }}"
                                                     class="img-fluid rounded mb-2"
                                                     style="max-height: 150px; object-fit: cover;"
                                                     alt="فیش واریز">
                                            @else
                                                <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                            @endif

                                            <h6 class="card-title small mb-1">{{ $receipt->file_name }}</h6>
                                            <p class="text-muted small mb-2">{{ $receipt->file_size_formatted }}</p>

                                            <div class="d-flex justify-content-center">
                                                <a href="{{ $receipt->file_url }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-outline-primary mr-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ $receipt->file_url }}"
                                                   download
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>

                                            @if($receipt->is_verified)
                                                <div class="mt-2">
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check mr-1"></i>
                                                        تایید شده
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Bank Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-university text-primary mr-2"></i>
                        اطلاعات بانکی
                    </h5>
                </div>
                <div class="card-body">
                    @if($payment->recipient->bank_name)
                        <div class="mb-3">
                            <label class="text-muted small">نام بانک:</label>
                            <div class="text-dark">{{ $payment->recipient->bank_name }}</div>
                        </div>
                    @endif

                    @if($payment->recipient->account_number)
                        <div class="mb-3">
                            <label class="text-muted small">شماره حساب:</label>
                            <div class="text-dark font-monospace">{{ $payment->recipient->account_number }}</div>
                        </div>
                    @endif

                    @if($payment->recipient->iban)
                        <div class="mb-3">
                            <label class="text-muted small">شماره شبا:</label>
                            <div class="text-dark font-monospace">{{ $payment->recipient->iban }}</div>
                        </div>
                    @endif

                    @if($payment->recipient->card_number)
                        <div class="mb-3">
                            <label class="text-muted small">شماره کارت:</label>
                            <div class="text-dark font-monospace">{{ $payment->recipient->card_number }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-bolt text-primary mr-2"></i>
                        عملیات سریع
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($payment->status == 'pending')
                            <button type="button"
                                    class="btn btn-success btn-sm"
                                    onclick="updateStatus('completed')">
                                <i class="fas fa-check mr-1"></i>
                                تایید پرداخت
                            </button>
                        @endif

                        @if($payment->status == 'pending')
                            <button type="button"
                                    class="btn btn-danger btn-sm"
                                    onclick="updateStatus('failed')">
                                <i class="fas fa-times mr-1"></i>
                                رد پرداخت
                            </button>
                        @endif

                        @if($payment->status == 'completed')
                            <button type="button"
                                    class="btn btn-warning btn-sm"
                                    onclick="updateStatus('pending')">
                                <i class="fas fa-clock mr-1"></i>
                                بازگردانی به انتظار
                            </button>
                        @endif

                        <a href="{{ route('panel.projects.payments.edit', [$project, $payment]) }}"
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit mr-1"></i>
                            ویرایش پرداخت
                        </a>

                        <button type="button"
                                class="btn btn-outline-danger btn-sm"
                                onclick="confirmDelete()">
                            <i class="fas fa-trash mr-1"></i>
                            حذف پرداخت
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Form -->
<form id="statusForm" method="POST" action="{{ route('panel.projects.payments.update-status', [$project, $payment]) }}" style="display: none;">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" id="statusInput">
</form>

<!-- Delete Form -->
<form id="deleteForm" method="POST" action="{{ route('panel.projects.payments.destroy', [$project, $payment]) }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function updateStatus(status) {
    if (confirm('آیا از تغییر وضعیت این پرداخت اطمینان دارید؟')) {
        document.getElementById('statusInput').value = status;
        document.getElementById('statusForm').submit();
    }
}

function confirmDelete() {
    if (confirm('آیا از حذف این پرداخت اطمینان دارید؟\nاین عمل قابل بازگشت نیست.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection
