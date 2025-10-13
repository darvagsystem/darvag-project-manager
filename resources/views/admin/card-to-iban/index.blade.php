@extends('admin.layout')

@section('title', 'تبدیل شماره کارت به شبا')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-credit-card-convert me-2"></i>
                        تبدیل شماره کارت به شبا
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Form Section -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3 text-muted">اطلاعات کارت بانکی</h6>

                                    <form id="cardToIbanForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="card_number" class="form-label">شماره کارت</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="card_number"
                                                   name="card_number"
                                                   placeholder="1234-5678-9012-3456"
                                                   maxlength="19"
                                                   required>
                                            <div class="form-text">شماره کارت 16 رقمی خود را وارد کنید</div>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <button type="submit" class="btn btn-primary" id="convertBtn">
                                            <i class="mdi mdi-swap-horizontal me-2"></i>
                                            تبدیل به شبا
                                        </button>

                                        <button type="button" class="btn btn-secondary ms-2" id="clearBtn">
                                            <i class="mdi mdi-refresh me-2"></i>
                                            پاک کردن
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Result Section -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm" id="resultCard" style="display: none;">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3 text-muted">نتیجه تبدیل</h6>

                                    <div id="resultContent">
                                        <!-- Results will be populated here -->
                                    </div>

                                    <div class="mt-3">
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="copyIbanBtn">
                                            <i class="mdi mdi-content-copy me-2"></i>
                                            کپی شبا
                                        </button>

                                        <button type="button" class="btn btn-outline-info btn-sm ms-2" id="viewLogsBtn">
                                            <i class="mdi mdi-file-document-outline me-2"></i>
                                            مشاهده لاگ‌ها
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Error Section -->
                            <div class="card border-danger" id="errorCard" style="display: none;">
                                <div class="card-body text-danger">
                                    <h6 class="card-subtitle mb-2 text-danger">خطا</h6>
                                    <p id="errorMessage" class="mb-0"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="mdi mdi-information-outline me-2"></i>
                                        اطلاعات مهم
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="mdi mdi-check-circle text-success me-2"></i>
                                    استفاده از API معتبر دیجی‌کالا برای تبدیل دقیق
                                </li>
                                <li class="mb-2">
                                    <i class="mdi mdi-check-circle text-success me-2"></i>
                                    نمایش نام صاحب کارت (در صورت وجود)
                                </li>
                                <li class="mb-2">
                                    <i class="mdi mdi-check-circle text-success me-2"></i>
                                    پشتیبانی از تمامی بانک‌های ایران
                                </li>
                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2">
                                                    <i class="mdi mdi-alert-circle text-warning me-2"></i>
                                                    شبای تولید شده ممکن است نیاز به تأیید بانک داشته باشد
                                                </li>
                                                <li class="mb-2">
                                                    <i class="mdi mdi-alert-circle text-warning me-2"></i>
                                                    برای انتقال وجه حتماً شبا را با بانک تأیید کنید
                                                </li>
                                                <li class="mb-2">
                                                    <i class="mdi mdi-shield-check text-info me-2"></i>
                                                    اطلاعات شما در سیستم ذخیره نمی‌شود
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Supported Banks -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-0">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="mdi mdi-bank me-2"></i>
                                        بانک‌های پشتیبانی شده
                                    </h6>
                                    <div class="row" id="supportedBanks">
                                        <!-- Banks will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logs Modal -->
<div class="modal fade" id="logsModal" tabindex="-1" aria-labelledby="logsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logsModalLabel">
                    <i class="mdi mdi-file-document-outline me-2"></i>
                    لاگ‌های سیستم
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="logsContent">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">در حال بارگذاری...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                <button type="button" class="btn btn-primary" id="refreshLogsBtn">
                    <i class="mdi mdi-refresh me-2"></i>
                    به‌روزرسانی
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.btn {
    border-radius: 6px;
}

.result-item {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 10px;
}

.result-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
}

.result-value {
    font-family: 'Courier New', monospace;
    font-size: 14px;
    color: #212529;
    word-break: break-all;
}

.bank-item {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 8px 12px;
    margin-bottom: 8px;
    font-size: 13px;
}

.loading {
    opacity: 0.6;
    pointer-events: none;
}

.fade-in {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('cardToIbanForm');
    const cardNumberInput = document.getElementById('card_number');
    const convertBtn = document.getElementById('convertBtn');
    const clearBtn = document.getElementById('clearBtn');
    const resultCard = document.getElementById('resultCard');
    const errorCard = document.getElementById('errorCard');
    const resultContent = document.getElementById('resultContent');
    const errorMessage = document.getElementById('errorMessage');
    const copyIbanBtn = document.getElementById('copyIbanBtn');
    const viewLogsBtn = document.getElementById('viewLogsBtn');
    const refreshLogsBtn = document.getElementById('refreshLogsBtn');
    const logsModal = new bootstrap.Modal(document.getElementById('logsModal'));

    let currentIban = '';

    // Format card number input
    cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        let formattedValue = value.replace(/(\d{4})(?=\d)/g, '$1-');

        if (formattedValue.length <= 19) {
            e.target.value = formattedValue;
        }

        // Remove validation classes when user types
        e.target.classList.remove('is-invalid', 'is-valid');
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const cardNumber = cardNumberInput.value.replace(/\D/g, '');

        if (cardNumber.length < 16) {
            showError('شماره کارت باید حداقل 16 رقم باشد');
            cardNumberInput.classList.add('is-invalid');
            return;
        }

        convertCardToIban(cardNumber);
    });

    // Clear button
    clearBtn.addEventListener('click', function() {
        form.reset();
        hideResults();
        cardNumberInput.classList.remove('is-invalid', 'is-valid');
        cardNumberInput.focus();
    });

    // Copy IBAN button
    copyIbanBtn.addEventListener('click', function() {
        if (currentIban) {
            navigator.clipboard.writeText(currentIban).then(function() {
                // Show success message
                const originalText = copyIbanBtn.innerHTML;
                copyIbanBtn.innerHTML = '<i class="mdi mdi-check me-2"></i>کپی شد!';
                copyIbanBtn.classList.add('btn-success');
                copyIbanBtn.classList.remove('btn-outline-primary');

                setTimeout(function() {
                    copyIbanBtn.innerHTML = originalText;
                    copyIbanBtn.classList.remove('btn-success');
                    copyIbanBtn.classList.add('btn-outline-primary');
                }, 2000);
            });
        }
    });

    // View logs button
    viewLogsBtn.addEventListener('click', function() {
        logsModal.show();
        loadLogs();
    });

    // Refresh logs button
    refreshLogsBtn.addEventListener('click', function() {
        loadLogs();
    });

    // Convert card to IBAN
    function convertCardToIban(cardNumber) {
        setLoading(true);
        hideResults();

        fetch('{{ route("panel.card-to-iban.convert") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                card_number: cardNumber
            })
        })
        .then(response => response.json())
        .then(data => {
            setLoading(false);

            if (data.success) {
                showResult(data.data);
                cardNumberInput.classList.add('is-valid');
                cardNumberInput.classList.remove('is-invalid');
            } else {
                showError(data.message);
                cardNumberInput.classList.add('is-invalid');
                cardNumberInput.classList.remove('is-valid');
            }
        })
        .catch(error => {
            setLoading(false);
            showError('خطا در برقراری ارتباط با سرور');
            console.error('Error:', error);
        });
    }

    // Show result
    function showResult(data) {
        currentIban = data.iban;

        let ownerHtml = '';
        if (data.owner && data.owner !== 'نامشخص') {
            ownerHtml = `
                <div class="result-item">
                    <div class="result-label">نام صاحب کارت:</div>
                    <div class="result-value">${data.owner}</div>
                </div>
            `;
        }

        let fallbackWarning = '';
        if (data.fallback) {
            fallbackWarning = `
                <div class="alert alert-warning mt-2" style="font-size: 13px;">
                    <i class="mdi mdi-alert me-2"></i>
                    این اطلاعات با روش محلی تولید شده است. لطفاً قبل از استفاده با بانک تأیید کنید.
                </div>
            `;
        }

        resultContent.innerHTML = `
            <div class="result-item">
                <div class="result-label">شماره کارت:</div>
                <div class="result-value">${data.card_number}</div>
            </div>
            ${ownerHtml}
            <div class="result-item">
                <div class="result-label">شماره شبا:</div>
                <div class="result-value">${data.iban}</div>
            </div>
            <div class="result-item">
                <div class="result-label">نام بانک:</div>
                <div class="result-value">${data.bank_name}</div>
            </div>
            <div class="result-item">
                <div class="result-label">کد بانک:</div>
                <div class="result-value">${data.bank_code}</div>
            </div>
            ${fallbackWarning}
        `;

        resultCard.style.display = 'block';
        resultCard.classList.add('fade-in');
        errorCard.style.display = 'none';
    }

    // Show error
    function showError(message) {
        errorMessage.textContent = message;
        errorCard.style.display = 'block';
        errorCard.classList.add('fade-in');
        resultCard.style.display = 'none';
        currentIban = '';
    }

    // Hide results
    function hideResults() {
        resultCard.style.display = 'none';
        errorCard.style.display = 'none';
    }

    // Set loading state
    function setLoading(loading) {
        if (loading) {
            convertBtn.disabled = true;
            convertBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin me-2"></i>در حال تبدیل...';
            form.classList.add('loading');
        } else {
            convertBtn.disabled = false;
            convertBtn.innerHTML = '<i class="mdi mdi-swap-horizontal me-2"></i>تبدیل به شبا';
            form.classList.remove('loading');
        }
    }

    // Load supported banks
    function loadSupportedBanks() {
        fetch('{{ route("panel.card-to-iban.banks") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const banksContainer = document.getElementById('supportedBanks');
                let banksHtml = '';

                data.data.forEach(bank => {
                    banksHtml += `
                        <div class="col-md-3 col-sm-6 mb-2">
                            <div class="bank-item">
                                <strong>${bank.name}</strong><br>
                                <small class="text-muted">کد: ${bank.code}</small>
                            </div>
                        </div>
                    `;
                });

                banksContainer.innerHTML = banksHtml;
            }
        })
        .catch(error => {
            console.error('Error loading banks:', error);
        });
    }

    // Load logs
    function loadLogs() {
        const logsContent = document.getElementById('logsContent');
        logsContent.innerHTML = `
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">در حال بارگذاری...</span>
                </div>
            </div>
        `;

        fetch('{{ route("panel.card-to-iban.card-to-iban-logs") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.logs && data.logs.length > 0) {
                    let logsHtml = '<div class="logs-container" style="max-height: 400px; overflow-y: auto;">';
                    data.logs.forEach(log => {
                        const logClass = log.includes('ERROR') ? 'text-danger' :
                                       log.includes('WARNING') ? 'text-warning' :
                                       log.includes('INFO') ? 'text-info' : '';
                        logsHtml += `<div class="log-line ${logClass}" style="font-family: monospace; font-size: 12px; margin-bottom: 5px; padding: 5px; background: #f8f9fa; border-radius: 3px;">${log}</div>`;
                    });
                    logsHtml += '</div>';
                    logsContent.innerHTML = logsHtml;
                } else {
                    logsContent.innerHTML = '<div class="alert alert-info">هیچ لاگی یافت نشد</div>';
                }
            } else {
                logsContent.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => {
            logsContent.innerHTML = '<div class="alert alert-danger">خطا در بارگذاری لاگ‌ها</div>';
            console.error('Error loading logs:', error);
        });
    }

    // Load banks on page load
    loadSupportedBanks();
});
</script>
@endpush
