@extends('admin.layout')

@section('title', 'لیست پرسنل')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <div class="breadcrumb">
                <a href="{{ route('panel.employees.index') }}" class="breadcrumb-link">مدیریت پرسنل</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('panel.employees.reports.index') }}" class="breadcrumb-link">گزارش‌ها</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">لیست پرسنل</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-list"></i>
                لیست پرسنل
            </h1>
            <p class="page-subtitle">
                گزارش کامل لیست پرسنل با جزئیات
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('panel.employees.reports.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-right"></i>
                بازگشت
            </a>
            <a href="{{ route('panel.employees.reports.employees-list', ['format' => 'print']) }}" target="_blank" class="btn btn-outline-light">
                <i class="fas fa-print"></i>
                پرینت
            </a>
            <a href="{{ route('panel.employees.reports.export', ['type' => 'employees_list', 'format' => 'csv']) }}" class="btn btn-outline-light">
                <i class="fas fa-download"></i>
                دانلود CSV
            </a>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card-box">
    <form method="GET" class="filters-form">
        <div class="filters-grid">
            <div class="form-group">
                <label for="status" class="form-label">وضعیت</label>
                <select id="status" name="status" class="form-select">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="department" class="form-label">بخش</label>
                <input type="text" id="department" name="department" class="form-input" value="{{ request('department') }}" placeholder="نام بخش">
            </div>
            
            <div class="form-group">
                <label for="has_bank_account" class="form-label">حساب بانکی</label>
                <select id="has_bank_account" name="has_bank_account" class="form-select">
                    <option value="">همه</option>
                    <option value="yes" {{ request('has_bank_account') == 'yes' ? 'selected' : '' }}>دارد</option>
                    <option value="no" {{ request('has_bank_account') == 'no' ? 'selected' : '' }}>ندارد</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    فیلتر
                </button>
                <a href="{{ route('panel.employees.reports.employees-list') }}" class="btn btn-light">
                    <i class="fas fa-times"></i>
                    پاک کردن
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Results -->
<div class="card-box">
    <div class="table-header">
        <h3>نتایج جستجو</h3>
        <div class="table-info">
            <span class="result-count">{{ $employees->count() }} نتیجه یافت شد</span>
        </div>
    </div>
    
    @if($employees->count() > 0)
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>نام کامل</th>
                    <th>کد پرسنلی</th>
                    <th>کد ملی</th>
                    <th>وضعیت</th>
                    <th>بخش</th>
                    <th>تاریخ استخدام</th>
                    <th>حساب‌های بانکی</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>
                        <div class="employee-info">
                            <div class="employee-avatar">
                                @if($employee->avatar)
                                    <img src="{{ asset('storage/' . $employee->avatar) }}" alt="{{ $employee->full_name }}">
                                @else
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="employee-details">
                                <div class="employee-name">{{ $employee->full_name }}</div>
                                <div class="employee-email">{{ $employee->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="employee-code">{{ $employee->employee_code }}</span>
                    </td>
                    <td>
                        <span class="national-code">{{ $employee->national_code }}</span>
                    </td>
                    <td>
                        <span class="status-badge status-{{ $employee->status }}">
                            <i class="fas fa-circle"></i>
                            {{ $employee->formatted_status }}
                        </span>
                    </td>
                    <td>
                        <span class="department">{{ $employee->department ?? '-' }}</span>
                    </td>
                    <td>
                        <span class="hire-date">{{ $employee->hire_date ? \Morilog\Jalali\Jalalian::fromCarbon($employee->hire_date)->format('Y/m/d') : '-' }}</span>
                    </td>
                    <td>
                        <div class="bank-accounts-info">
                            @if($employee->bankAccounts->count() > 0)
                                <span class="bank-count">{{ $employee->bankAccounts->count() }} حساب</span>
                                <div class="bank-names">
                                    @foreach($employee->bankAccounts->take(2) as $account)
                                        <span class="bank-name">{{ $account->bank->name }}</span>
                                    @endforeach
                                    @if($employee->bankAccounts->count() > 2)
                                        <span class="more-banks">+{{ $employee->bankAccounts->count() - 2 }} بیشتر</span>
                                    @endif
                                </div>
                            @else
                                <span class="no-accounts">ندارد</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('panel.employees.show', $employee->id) }}" class="btn btn-sm btn-outline-primary" title="مشاهده">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('panel.employees.bank-accounts', $employee->id) }}" class="btn btn-sm btn-outline-info" title="حساب‌های بانکی">
                                <i class="fas fa-credit-card"></i>
                            </a>
                            <a href="{{ route('panel.employees.reports.employee-detail', $employee->id) }}" class="btn btn-sm btn-outline-success" title="گزارش تفصیلی">
                                <i class="fas fa-chart-line"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-users"></i>
        </div>
        <h3>هیچ پرسنلی یافت نشد</h3>
        <p>با فیلترهای انتخابی هیچ پرسنلی یافت نشد.</p>
    </div>
    @endif
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
    gap: 12px;
    align-items: flex-start;
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

/* Card Box */
.card-box {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

/* Filters */
.filters-form {
    margin-bottom: 0;
}

.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    align-items: end;
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

.form-input,
.form-select {
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Table */
.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e5e7eb;
}

.table-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.table-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.result-count {
    font-size: 14px;
    color: #6b7280;
    background: #f3f4f6;
    padding: 6px 12px;
    border-radius: 6px;
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.data-table th {
    background: #f8fafc;
    color: #374151;
    font-weight: 600;
    padding: 12px 16px;
    text-align: right;
    border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
}

.data-table td {
    padding: 16px;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: top;
}

.data-table tr:hover {
    background: #f9fafb;
}

/* Employee Info */
.employee-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.employee-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.employee-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 16px;
}

.employee-details {
    flex: 1;
}

.employee-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 2px;
}

.employee-email {
    font-size: 12px;
    color: #6b7280;
}

.employee-code {
    font-family: 'Courier New', monospace;
    background: #f3f4f6;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}

.national-code {
    font-family: 'Courier New', monospace;
    font-size: 13px;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
}

.status-badge i {
    font-size: 8px;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
}

.status-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.department {
    font-size: 13px;
    color: #6b7280;
}

.hire-date {
    font-size: 13px;
    color: #6b7280;
}

/* Bank Accounts Info */
.bank-accounts-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.bank-count {
    font-size: 12px;
    font-weight: 600;
    color: #3b82f6;
}

.bank-names {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}

.bank-name {
    font-size: 11px;
    background: #e0e7ff;
    color: #3730a3;
    padding: 2px 6px;
    border-radius: 4px;
}

.more-banks {
    font-size: 11px;
    color: #6b7280;
    font-style: italic;
}

.no-accounts {
    font-size: 12px;
    color: #9ca3af;
    font-style: italic;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 6px;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    justify-content: center;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 11px;
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

.btn-outline-info {
    background: transparent;
    color: #06b6d4;
    border: 1px solid #06b6d4;
}

.btn-outline-info:hover {
    background: #06b6d4;
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

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-light {
    background: #f8fafc;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-light:hover {
    background: #f1f5f9;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 18px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 14px;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
    }

    .header-actions {
        width: 100%;
        justify-content: center;
    }

    .filters-grid {
        grid-template-columns: 1fr;
    }

    .table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endpush
