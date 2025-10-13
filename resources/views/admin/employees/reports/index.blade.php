@extends('admin.layout')

@section('title', 'گزارش‌های پرسنل')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <div class="breadcrumb">
                <a href="{{ route('panel.employees.index') }}" class="breadcrumb-link">مدیریت پرسنل</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">گزارش‌ها</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-chart-bar"></i>
                گزارش‌های پرسنل
            </h1>
            <p class="page-subtitle">
                تولید و مدیریت گزارش‌های مختلف پرسنل
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('panel.employees.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-right"></i>
                بازگشت
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $totalEmployees }}</div>
            <div class="stat-label">کل پرسنل</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-credit-card"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $employeesWithBankAccounts }}</div>
            <div class="stat-label">پرسنل با حساب بانکی</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-university"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $banks->count() }}</div>
            <div class="stat-label">بانک‌های فعال</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-percentage"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $totalEmployees > 0 ? round(($employeesWithBankAccounts / $totalEmployees) * 100, 1) : 0 }}%</div>
            <div class="stat-label">درصد پوشش حساب بانکی</div>
        </div>
    </div>
</div>

<!-- Reports Grid -->
<div class="reports-grid">
    <!-- Employees List Report -->
    <div class="report-card">
        <div class="report-header">
            <div class="report-icon">
                <i class="fas fa-list"></i>
            </div>
            <div class="report-info">
                <h3>لیست پرسنل</h3>
                <p>گزارش کامل لیست پرسنل با جزئیات</p>
            </div>
        </div>
        <div class="report-actions">
            <a href="{{ route('panel.employees.reports.employees-list') }}" class="btn btn-primary">
                <i class="fas fa-eye"></i>
                مشاهده
            </a>
            <a href="{{ route('panel.employees.reports.employees-list', ['format' => 'print']) }}" target="_blank" class="btn btn-outline-primary">
                <i class="fas fa-print"></i>
                پرینت
            </a>
            <a href="{{ route('panel.employees.reports.export', ['type' => 'employees_list', 'format' => 'csv']) }}" class="btn btn-outline-success">
                <i class="fas fa-download"></i>
                دانلود CSV
            </a>
        </div>
    </div>

    <!-- Employees with Bank Accounts Report -->
    <div class="report-card">
        <div class="report-header">
            <div class="report-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="report-info">
                <h3>پرسنل با حساب بانکی</h3>
                <p>لیست پرسنلی که حساب بانکی دارند</p>
            </div>
        </div>
        <div class="report-actions">
            <a href="{{ route('panel.employees.reports.employees-with-bank-accounts') }}" class="btn btn-primary">
                <i class="fas fa-eye"></i>
                مشاهده
            </a>
            <a href="{{ route('panel.employees.reports.employees-with-bank-accounts', ['format' => 'print']) }}" target="_blank" class="btn btn-outline-primary">
                <i class="fas fa-print"></i>
                پرینت
            </a>
            <a href="{{ route('panel.employees.reports.export', ['type' => 'employees_with_bank_accounts', 'format' => 'csv']) }}" class="btn btn-outline-success">
                <i class="fas fa-download"></i>
                دانلود CSV
            </a>
        </div>
    </div>

    <!-- Bank Employees Report -->
    <div class="report-card">
        <div class="report-header">
            <div class="report-icon">
                <i class="fas fa-university"></i>
            </div>
            <div class="report-info">
                <h3>پرسنل بانک خاص</h3>
                <p>لیست پرسنل بر اساس بانک</p>
            </div>
        </div>
        <div class="report-actions">
            <button class="btn btn-primary" onclick="showBankSelectionModal()">
                <i class="fas fa-eye"></i>
                مشاهده
            </button>
            <button class="btn btn-outline-primary" onclick="showBankSelectionModal('print')">
                <i class="fas fa-print"></i>
                پرینت
            </button>
            <button class="btn btn-outline-success" onclick="showBankSelectionModal('export')">
                <i class="fas fa-download"></i>
                دانلود CSV
            </button>
        </div>
    </div>

    <!-- Bank Accounts Summary Report -->
    <div class="report-card">
        <div class="report-header">
            <div class="report-icon">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="report-info">
                <h3>خلاصه حساب‌های بانکی</h3>
                <p>گزارش کامل حساب‌های بانکی</p>
            </div>
        </div>
        <div class="report-actions">
            <a href="{{ route('panel.employees.reports.bank-accounts-summary') }}" class="btn btn-primary">
                <i class="fas fa-eye"></i>
                مشاهده
            </a>
            <a href="{{ route('panel.employees.reports.bank-accounts-summary', ['format' => 'print']) }}" target="_blank" class="btn btn-outline-primary">
                <i class="fas fa-print"></i>
                پرینت
            </a>
            <a href="{{ route('panel.employees.reports.export', ['type' => 'bank_accounts_summary', 'format' => 'csv']) }}" class="btn btn-outline-success">
                <i class="fas fa-download"></i>
                دانلود CSV
            </a>
        </div>
    </div>
</div>

<!-- Bank Selection Modal -->
<div id="bankSelectionModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">انتخاب بانک</h2>
            <button class="modal-close" onclick="closeBankSelectionModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="bankSelectionForm">
                <div class="form-group">
                    <label for="selected_bank_id" class="form-label">انتخاب بانک *</label>
                    <select id="selected_bank_id" name="bank_id" class="form-select" required>
                        <option value="">انتخاب بانک</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="proceedWithBankSelection()">
                ادامه
            </button>
            <button type="button" class="btn btn-light" onclick="closeBankSelectionModal()">
                انصراف
            </button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 16px;
    margin-bottom: 30px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 30px;
}

.header-info {
    flex: 1;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    font-size: 14px;
    opacity: 0.9;
}

.breadcrumb-link {
    color: white;
    text-decoration: none;
    transition: opacity 0.3s ease;
}

.breadcrumb-link:hover {
    opacity: 0.8;
}

.breadcrumb-separator {
    opacity: 0.6;
}

.breadcrumb-current {
    opacity: 0.8;
    font-weight: 500;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 8px 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-title i {
    font-size: 24px;
    opacity: 0.9;
}

.page-subtitle {
    font-size: 16px;
    margin: 0;
    opacity: 0.9;
}

.header-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    align-items: flex-end;
}

.btn-outline-light {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
}

.btn-outline-light:hover {
    background: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.5);
    color: white;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 32px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 14px;
    color: #6b7280;
    font-weight: 500;
}

/* Reports Grid */
.reports-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 24px;
}

.report-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.report-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.report-header {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 20px;
}

.report-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    flex-shrink: 0;
}

.report-info {
    flex: 1;
}

.report-info h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 8px 0;
}

.report-info p {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
    line-height: 1.5;
}

.report-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    justify-content: center;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-outline-primary {
    background: transparent;
    color: #3b82f6;
    border: 1px solid #3b82f6;
}

.btn-outline-primary:hover {
    background: #3b82f6;
    color: white;
}

.btn-outline-success {
    background: transparent;
    color: #10b981;
    border: 1px solid #10b981;
}

.btn-outline-success:hover {
    background: #10b981;
    color: white;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.modal-container {
    background: white;
    border-radius: 16px;
    max-width: 500px;
    width: 100%;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal-header {
    padding: 24px 30px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f9fafb;
}

.modal-title {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.modal-close {
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: #fee2e2;
    color: #dc2626;
}

.modal-body {
    padding: 30px;
}

.modal-footer {
    padding: 20px 30px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    background: #f9fafb;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-select {
    padding: 12px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-light {
    background: #f8fafc;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-light:hover {
    background: #f1f5f9;
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .reports-grid {
        grid-template-columns: 1fr;
    }

    .header-content {
        flex-direction: column;
        text-align: center;
    }

    .header-actions {
        align-items: center;
    }

    .report-actions {
        flex-direction: column;
    }

    .modal-container {
        margin: 10px;
        max-height: 95vh;
    }
}
</style>
@endpush

@push('scripts')
<script>
let currentAction = 'view';

function showBankSelectionModal(action = 'view') {
    currentAction = action;
    document.getElementById('bankSelectionModal').style.display = 'flex';
}

function closeBankSelectionModal() {
    document.getElementById('bankSelectionModal').style.display = 'none';
    document.getElementById('selected_bank_id').value = '';
}

function proceedWithBankSelection() {
    const bankId = document.getElementById('selected_bank_id').value;

    if (!bankId) {
        alert('لطفاً یک بانک انتخاب کنید');
        return;
    }

    let url = '';

    switch (currentAction) {
        case 'view':
            url = `{{ route('panel.employees.reports.bank-employees') }}?bank_id=${bankId}`;
            break;
        case 'print':
            url = `{{ route('panel.employees.reports.bank-employees') }}?bank_id=${bankId}&format=print`;
            window.open(url, '_blank');
            closeBankSelectionModal();
            return;
        case 'export':
            url = `{{ route('panel.employees.reports.export') }}?type=bank_employees&bank_id=${bankId}&format=csv`;
            window.location.href = url;
            return;
    }

    window.location.href = url;
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        closeBankSelectionModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeBankSelectionModal();
    }
});
</script>
@endpush
