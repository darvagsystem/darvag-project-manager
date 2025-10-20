@extends('admin.layout')

@section('title', 'ثبت پرداخت جدید - ' . $project->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-plus-circle text-primary mr-2"></i>
                        ثبت پرداخت جدید
                    </h1>
                    <p class="text-muted mb-0">{{ $project->name }} - {{ $project->contract_number }}</p>
                </div>
                <div>
                    <a href="{{ route('panel.projects.payments.index', $project) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right mr-1"></i>
                        بازگشت به لیست پرداخت‌ها
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
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6>خطاهای زیر رخ داده است:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('panel.projects.payments.store', $project) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="recipient_id" class="form-label">دریافت‌کننده <span class="text-danger">*</span></label>
                                    <select name="recipient_id" id="recipient_id" class="form-control @error('recipient_id') is-invalid @enderror" required>
                                        <option value="">انتخاب کنید...</option>
                                        @foreach($recipients as $recipient)
                                            <option value="{{ $recipient->id }}" {{ old('recipient_id') == $recipient->id ? 'selected' : '' }}>
                                                {{ $recipient->display_name }}
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
                                    <label for="bank_account_id" class="form-label">شماره حساب</label>
                                    <select name="bank_account_id" id="bank_account_id" class="form-control @error('bank_account_id') is-invalid @enderror">
                                        <option value="">ابتدا دریافت‌کننده را انتخاب کنید...</option>
                                    </select>
                                    @error('bank_account_id')
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
                                           value="{{ old('amount') }}"
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
                                        <option value="IRR" {{ old('currency') == 'IRR' ? 'selected' : '' }}>ریال</option>
                                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>دلار</option>
                                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>یورو</option>
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
                                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>واریز بانکی</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>نقدی</option>
                                        <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>چک</option>
                                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>کارت</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="payment_type_id" class="form-label">نوع پرداخت <span class="text-danger">*</span></label>
                                    <select name="payment_type_id" id="payment_type_id" class="form-control @error('payment_type_id') is-invalid @enderror" required>
                                        <option value="">انتخاب کنید...</option>
                                        @foreach($paymentTypes as $paymentType)
                                            <option value="{{ $paymentType->id }}"
                                                    {{ old('payment_type_id') == $paymentType->id ? 'selected' : '' }}
                                                    data-requires-receipt="{{ $paymentType->requires_receipt ? 'true' : 'false' }}"
                                                    data-color="{{ $paymentType->color }}"
                                                    data-icon="{{ $paymentType->icon }}">
                                                {!! $paymentType->icon_html !!} {{ $paymentType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="payment_date" class="form-label">تاریخ پرداخت <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="payment_date"
                                           id="payment_date"
                                           class="form-control @error('payment_date') is-invalid @enderror"
                                           value="{{ old('payment_date', \Morilog\Jalali\Jalalian::now()->format('Y/m/d')) }}"
                                           placeholder="1403/01/01"
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
                                           value="{{ old('reference_number') }}"
                                           placeholder="شماره پیگیری، شماره چک، etc.">
                                    @error('reference_number')
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
                                      placeholder="توضیحات اضافی در مورد پرداخت...">{{ old('description') }}</textarea>
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
                                      placeholder="یادداشت‌های داخلی...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3" id="receipts-section">
                            <label for="receipts" class="form-label">
                                فیش واریز
                                <span id="receipt-required" class="text-danger" style="display: none;">*</span>
                            </label>
                            <input type="file"
                                   name="receipts[]"
                                   id="receipts"
                                   class="form-control @error('receipts.*') is-invalid @enderror"
                                   multiple
                                   accept="image/*,.pdf">
                            <small class="form-text text-muted">می‌توانید چندین فایل انتخاب کنید (JPG, PNG, PDF)</small>
                            <div id="receipt-warning" class="alert alert-warning mt-2" style="display: none;">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                این نوع پرداخت نیاز به فیش واریز دارد.
                            </div>
                            @error('receipts.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                ثبت پرداخت
                            </button>
                            <a href="{{ route('panel.projects.payments.index', $project) }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-times mr-1"></i>
                                انصراف
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        راهنما
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">نوع پرداخت:</h6>
                        <ul class="list-unstyled small">
                            <li><strong>حقوق:</strong> پرداخت ماهانه پرسنل</li>
                            <li><strong>پاداش:</strong> پاداش و مزایا</li>
                            <li><strong>پیش‌پرداخت:</strong> پرداخت پیش از انجام کار</li>
                            <li><strong>هزینه:</strong> هزینه‌های عملیاتی</li>
                            <li><strong>قراردادی:</strong> پرداخت به پیمانکاران</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">روش پرداخت:</h6>
                        <ul class="list-unstyled small">
                            <li><strong>واریز بانکی:</strong> انتقال به حساب بانکی</li>
                            <li><strong>نقدی:</strong> پرداخت نقدی</li>
                            <li><strong>چک:</strong> پرداخت با چک</li>
                            <li><strong>کارت:</strong> پرداخت با کارت</li>
                        </ul>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb mr-1"></i>
                        <small>حتماً فیش واریز را آپلود کنید تا پرداخت قابل تایید باشد.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('paymentForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Check if all required fields are filled
            const requiredFields = form.querySelectorAll('[required]');
            let allFilled = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    allFilled = false;
                }
            });

            if (!allFilled) {
                e.preventDefault();
                alert('لطفاً تمام فیلدهای الزامی را پر کنید');
                return false;
            }
        });
    }

    const paymentTypeSelect = document.getElementById('payment_type_id');
    const receiptRequired = document.getElementById('receipt-required');
    const receiptWarning = document.getElementById('receipt-warning');
    const receiptsInput = document.getElementById('receipts');

    function updateReceiptRequirement() {
        const selectedOption = paymentTypeSelect.options[paymentTypeSelect.selectedIndex];
        const requiresReceipt = selectedOption.getAttribute('data-requires-receipt') === 'true';

        if (requiresReceipt) {
            receiptRequired.style.display = 'inline';
            receiptWarning.style.display = 'block';
            receiptsInput.required = true;
        } else {
            receiptRequired.style.display = 'none';
            receiptWarning.style.display = 'none';
            receiptsInput.required = false;
        }
    }

    paymentTypeSelect.addEventListener('change', updateReceiptRequirement);

    // Initialize on page load
    updateReceiptRequirement();

    // Bank accounts loading functionality
    const recipientSelect = document.getElementById('recipient_id');
    const bankAccountSelect = document.getElementById('bank_account_id');

    recipientSelect.addEventListener('change', function() {
        const selectedRecipientId = this.value;
        bankAccountSelect.innerHTML = '<option value="">در حال بارگذاری...</option>';

        if (selectedRecipientId) {
            // Load bank accounts via AJAX
            fetch(`/panel/payment-recipients/${selectedRecipientId}/bank-accounts`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                bankAccountSelect.innerHTML = '<option value="">انتخاب شماره حساب...</option>';

                if (data.success && data.bank_accounts && data.bank_accounts.length > 0) {
                    data.bank_accounts.forEach(account => {
                        const option = document.createElement('option');
                        option.value = account.id;
                        option.textContent = `${account.bank_name} - ${account.account_number}`;
                        bankAccountSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'شماره حسابی ثبت نشده';
                    bankAccountSelect.appendChild(option);
                }
            })
            .catch(error => {
                console.error('Error loading bank accounts:', error);
                bankAccountSelect.innerHTML = '<option value="">خطا در بارگذاری</option>';
            });
        } else {
            bankAccountSelect.innerHTML = '<option value="">ابتدا دریافت‌کننده را انتخاب کنید...</option>';
        }
    });

    // Persian date picker
    if (typeof $.fn.persianDatepicker !== 'undefined') {
        $('#payment_date').persianDatepicker({
            format: 'YYYY/MM/DD',
            altField: '#payment_date_alt',
            altFormat: 'YYYY/MM/DD',
            observer: true,
            timePicker: {
                enabled: false
            }
        });
    }
});
</script>
@endsection
