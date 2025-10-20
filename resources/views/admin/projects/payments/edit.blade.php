@extends('admin.layout')

@section('title', 'ویرایش پرداخت - ' . $payment->recipient->recipient_name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-edit text-primary mr-2"></i>
                        ویرایش پرداخت
                    </h1>
                    <p class="text-muted mb-0">{{ $project->name }} - {{ $project->contract_number }}</p>
                </div>
                <div>
                    <a href="{{ route('panel.projects.payments.show', [$project, $payment]) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right mr-1"></i>
                        بازگشت به جزئیات
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
                        <i class="fas fa-credit-card text-primary mr-2"></i>
                        اطلاعات پرداخت
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('panel.projects.payments.update', [$project, $payment]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="recipient_id" class="form-label">دریافت‌کننده <span class="text-danger">*</span></label>
                                    <select name="recipient_id" id="recipient_id" class="form-control @error('recipient_id') is-invalid @enderror" required>
                                        <option value="">انتخاب کنید...</option>
                                        @foreach($recipients as $recipient)
                                            <option value="{{ $recipient->id }}"
                                                    {{ old('recipient_id', $payment->recipient_id) == $recipient->id ? 'selected' : '' }}>
                                                {{ $recipient->display_name }} - {{ $recipient->bank_info }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('recipient_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="amount" class="form-label">مبلغ <span class="text-danger">*</span></label>
                                    <input type="number"
                                           name="amount"
                                           id="amount"
                                           class="form-control @error('amount') is-invalid @enderror"
                                           value="{{ old('amount', $payment->amount) }}"
                                           step="0.01"
                                           min="0"
                                           required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="currency" class="form-label">واحد پول <span class="text-danger">*</span></label>
                                    <select name="currency" id="currency" class="form-control @error('currency') is-invalid @enderror" required>
                                        <option value="IRR" {{ old('currency', $payment->currency) == 'IRR' ? 'selected' : '' }}>ریال</option>
                                        <option value="USD" {{ old('currency', $payment->currency) == 'USD' ? 'selected' : '' }}>دلار</option>
                                        <option value="EUR" {{ old('currency', $payment->currency) == 'EUR' ? 'selected' : '' }}>یورو</option>
                                    </select>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="payment_method" class="form-label">روش پرداخت <span class="text-danger">*</span></label>
                                    <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
                                        <option value="">انتخاب کنید...</option>
                                        <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>واریز بانکی</option>
                                        <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>نقدی</option>
                                        <option value="check" {{ old('payment_method', $payment->payment_method) == 'check' ? 'selected' : '' }}>چک</option>
                                        <option value="card" {{ old('payment_method', $payment->payment_method) == 'card' ? 'selected' : '' }}>کارت</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="payment_type" class="form-label">نوع پرداخت <span class="text-danger">*</span></label>
                                    <select name="payment_type" id="payment_type" class="form-control @error('payment_type') is-invalid @enderror" required>
                                        <option value="">انتخاب کنید...</option>
                                        <option value="salary" {{ old('payment_type', $payment->payment_type) == 'salary' ? 'selected' : '' }}>حقوق</option>
                                        <option value="bonus" {{ old('payment_type', $payment->payment_type) == 'bonus' ? 'selected' : '' }}>پاداش</option>
                                        <option value="advance" {{ old('payment_type', $payment->payment_type) == 'advance' ? 'selected' : '' }}>پیش‌پرداخت</option>
                                        <option value="expense" {{ old('payment_type', $payment->payment_type) == 'expense' ? 'selected' : '' }}>هزینه</option>
                                        <option value="contract" {{ old('payment_type', $payment->payment_type) == 'contract' ? 'selected' : '' }}>قراردادی</option>
                                    </select>
                                    @error('payment_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="payment_date" class="form-label">تاریخ پرداخت <span class="text-danger">*</span></label>
                                    <input type="date"
                                           name="payment_date"
                                           id="payment_date"
                                           class="form-control @error('payment_date') is-invalid @enderror"
                                           value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}"
                                           required>
                                    @error('payment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="reference_number" class="form-label">شماره مرجع</label>
                                    <input type="text"
                                           name="reference_number"
                                           id="reference_number"
                                           class="form-control @error('reference_number') is-invalid @enderror"
                                           value="{{ old('reference_number', $payment->reference_number) }}"
                                           placeholder="شماره پیگیری، شماره چک، etc.">
                                    @error('reference_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">وضعیت <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>در انتظار</option>
                                        <option value="completed" {{ old('status', $payment->status) == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                                        <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>ناموفق</option>
                                        <option value="cancelled" {{ old('status', $payment->status) == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">توضیحات</label>
                            <textarea name="description"
                                      id="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="3"
                                      placeholder="توضیحات اضافی در مورد پرداخت...">{{ old('description', $payment->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="notes" class="form-label">یادداشت‌ها</label>
                            <textarea name="notes"
                                      id="notes"
                                      class="form-control @error('notes') is-invalid @enderror"
                                      rows="2"
                                      placeholder="یادداشت‌های داخلی...">{{ old('notes', $payment->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                ذخیره تغییرات
                            </button>
                            <a href="{{ route('panel.projects.payments.show', [$project, $payment]) }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-times mr-1"></i>
                                انصراف
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Current Payment Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        اطلاعات فعلی
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">دریافت‌کننده:</label>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-2"
                                 style="width: 32px; height: 32px; font-size: 14px;">
                                {{ substr($payment->recipient->recipient_name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-weight-bold text-dark">{{ $payment->recipient->recipient_name }}</div>
                                <small class="text-muted">{{ $payment->recipient->recipient_code }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">مبلغ فعلی:</label>
                        <div class="h5 text-primary mb-0">
                            {{ number_format($payment->amount, 0, '.', ',') }} {{ $payment->currency }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">وضعیت فعلی:</label>
                        <div>
                            <span class="badge badge-{{ $payment->status_color }} px-3 py-2">
                                {{ $payment->status_text }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">تاریخ ایجاد:</label>
                        <div class="text-dark">{{ $payment->created_at->format('Y/m/d H:i') }}</div>
                    </div>

                    <div class="mb-0">
                        <label class="text-muted small">آخرین به‌روزرسانی:</label>
                        <div class="text-dark">{{ $payment->updated_at->format('Y/m/d H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Receipts Info -->
            @if($payment->receipts->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0 text-dark">
                            <i class="fas fa-file-alt text-primary mr-2"></i>
                            فیش‌های موجود
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                            <div class="h5 mb-0">{{ $payment->receipts->count() }}</div>
                            <div class="text-muted small">فیش واریز</div>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('panel.projects.payments.show', [$project, $payment]) }}"
                               class="btn btn-outline-primary btn-sm btn-block">
                                <i class="fas fa-eye mr-1"></i>
                                مشاهده فیش‌ها
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
