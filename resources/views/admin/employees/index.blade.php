@extends('admin.layout')

@section('title', 'مدیریت پرسنل')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">مدیریت پرسنل</h1>
            <p class="page-subtitle">اطلاعات کامل کارکنان شرکت</p>
        </div>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            افزودن کارمند جدید
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 30px;">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $employees->count() }}</div>
        <div class="stat-label">کل پرسنل</div>
    </div>

    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $employees->where('status', 'active')->count() }}</div>
        <div class="stat-label">پرسنل فعال</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $employees->where('status', 'vacation')->count() }}</div>
        <div class="stat-label">در مرخصی</div>
    </div>

    <div class="stat-card accent">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $employees->where('status', 'terminated')->count() }}</div>
        <div class="stat-label">خاتمه همکاری</div>
    </div>
</div>

<!-- Employees Table -->
<div class="content-card">
    <div class="card-header">
        <div>
            <h3 class="card-title">لیست پرسنل</h3>
            <p class="card-subtitle">اطلاعات کامل کارکنان شرکت</p>
        </div>
        <div class="filter-buttons">
            <button class="filter-btn active" data-status="all">همه</button>
            <button class="filter-btn" data-status="active">فعال</button>
            <button class="filter-btn" data-status="vacation">مرخصی</button>
            <button class="filter-btn" data-status="inactive">غیرفعال</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="employees-table">
                <thead>
                    <tr>
                        <th>مشخصات</th>
                        <th>اطلاعات شخصی</th>
                        <th>تماس</th>
                        <th>تحصیلات</th>
                        <th>وضعیت</th>
                        <th>مدیریت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                    <tr class="employee-row" data-status="{{ $employee->status }}" data-employee-id="{{ $employee->id }}">
                        <td>
                            <div class="employee-info">
                                <div class="employee-avatar">
                                    @if($employee->avatar && $employee->avatar !== 'default-avatar.png' && file_exists(public_path('storage/' . $employee->avatar)))
                                        <img src="{{ asset('storage/' . $employee->avatar) }}" alt="{{ $employee->full_name }}">
                                    @else
                                        <div class="no-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="employee-details">
                                    <div class="employee-name">{{ $employee->full_name }}</div>
                                    <div class="employee-code">{{ $employee->employee_code }}</div>
                                    <div class="employee-national">{{ $employee->national_code }}</div>
                                    <div class="employee-birth">{{ $employee->birth_date ?? 'تاریخ تولد ثبت نشده' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="job-info">
                                <div class="job-hire-date">تاریخ ثبت: {{ $employee->created_at->format('Y/m/d') }}</div>
                                <div class="marital-status">{{ $employee->formatted_marital_status }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="contact-info">
                                @if($employee->phone)
                                <div class="contact-item">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <a href="tel:{{ $employee->phone }}">{{ $employee->phone }}</a>
                                </div>
                                @endif
                                @if($employee->mobile)
                                <div class="contact-item">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <a href="tel:{{ $employee->mobile }}">{{ $employee->mobile }}</a>
                                </div>
                                @endif
                                @if($employee->email)
                                <div class="contact-item">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="education-info">
                                <div class="education-level">{{ $employee->formatted_education }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="employee-status status-{{ $employee->status }}">
                                {{ $employee->formatted_status }}
                            </span>
                        </td>
                        <td>
                            <div class="management-links">
                                <a href="{{ route('employees.bank-accounts', $employee->id) }}" class="management-link" title="حساب‌های بانکی">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    حساب‌ها
                                </a>
                                <a href="{{ route('employees.documents', $employee->id) }}" class="management-link" title="مدارک">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    مدارک
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-edit" title="ویرایش">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button class="btn btn-sm btn-view" title="مشاهده جزئیات" onclick="showEmployeeProfile({{ $employee->id }})">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button class="btn btn-sm btn-delete" title="حذف" onclick="confirmDelete({{ $employee->id }}, '{{ $employee->full_name }}')">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Employee Profile Modal -->
<div id="employeeProfileModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">پروفایل کارمند</h2>
            <button class="modal-close" onclick="closeEmployeeProfile()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="profileContent" class="modal-body">
            <!-- Profile content will be loaded here -->
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-container modal-sm">
        <div class="modal-header">
            <h2 class="modal-title">تایید حذف</h2>
            <button class="modal-close" onclick="closeDeleteModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="delete-warning">
                <div class="warning-icon">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3>آیا از حذف کارمند اطمینان دارید؟</h3>
                <p id="deleteEmployeeName"></p>
                <p class="warning-text">این عمل قابل بازگشت نیست و تمام اطلاعات مربوط به این کارمند حذف خواهد شد.</p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger" onclick="deleteEmployee()">حذف کارمند</button>
            <button class="btn btn-light" onclick="closeDeleteModal()">انصراف</button>
        </div>
    </div>
</div>

<!-- Hidden form for delete -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
.btn {
    display: inline-flex;
    align-items: center;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.filter-buttons {
    display: flex;
    gap: 10px;
}

.filter-btn {
    padding: 8px 16px;
    border: 1px solid var(--border-light);
    background: white;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-muted);
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    background: var(--bg-light);
}

.filter-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.employees-table {
    width: 100%;
    border-collapse: collapse;
}

.employees-table th,
.employees-table td {
    padding: 16px 12px;
    text-align: right;
    border-bottom: 1px solid var(--border-light);
    vertical-align: top;
}

.employees-table th {
    background: var(--bg-light);
    font-weight: 600;
    color: var(--text-dark);
    font-size: 14px;
}

.employee-row:hover {
    background: var(--bg-light);
}

.employee-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.employee-avatar {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
}

.employee-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.employee-details {
    flex: 1;
}

.employee-name {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 4px;
}

.employee-code,
.employee-national,
.employee-birth {
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 2px;
}

.job-info {
    line-height: 1.5;
}

.job-hire-date {
    font-weight: 500;
    color: var(--text-dark);
    margin-bottom: 4px;
}

.experience-info,
.marital-status {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 4px;
}

.contact-info {
    line-height: 1.6;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 4px;
    font-size: 13px;
}

.contact-item svg {
    color: var(--text-muted);
    flex-shrink: 0;
}

.contact-item a {
    color: var(--text-dark);
    text-decoration: none;
}

.contact-item a:hover {
    color: var(--primary-color);
}

.education-info {
    text-align: center;
}

.education-level {
    font-weight: 600;
    color: var(--text-dark);
    background: var(--bg-light);
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 13px;
}

.management-links {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.management-link {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    background: var(--bg-light);
    border-radius: 6px;
    text-decoration: none;
    color: var(--text-dark);
    font-size: 12px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.management-link:hover {
    background: var(--primary-light);
    color: var(--primary-color);
}

.employee-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
    display: inline-block;
}

.status-active {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
}

.status-vacation {
    background: rgba(251, 191, 36, 0.1);
    color: var(--warning-color);
}

.status-inactive {
    background: rgba(156, 163, 175, 0.1);
    color: var(--text-muted);
}

.status-terminated {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-color);
}

.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.btn-sm {
    padding: 8px;
    border-radius: 6px;
}

.btn-edit {
    background: var(--primary-light);
    color: var(--primary-color);
}

.btn-edit:hover {
    background: var(--primary-color);
    color: white;
}

.btn-view {
    background: var(--info-light);
    color: var(--info-color);
}

.btn-view:hover {
    background: var(--info-color);
    color: white;
}

.btn-delete {
    background: var(--error-light);
    color: var(--error-color);
}

.btn-delete:hover {
    background: var(--error-color);
    color: white;
}

.stats-grid {
    display: grid;
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    border: 1px solid var(--border-light);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-light);
    color: var(--primary-color);
}

.stat-card.success .stat-icon {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
}

.stat-card.warning .stat-icon {
    background: rgba(251, 191, 36, 0.1);
    color: var(--warning-color);
}

.stat-card.accent .stat-icon {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-color);
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 8px;
}

.stat-label {
    color: var(--text-muted);
    font-size: 14px;
    font-weight: 500;
}

.content-card {
    background: white;
    border-radius: 12px;
    border: 1px solid var(--border-light);
    overflow: hidden;
}

.card-header {
    padding: 24px;
    border-bottom: 1px solid var(--border-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 4px;
}

.card-subtitle {
    color: var(--text-muted);
    font-size: 14px;
}

.card-body {
    padding: 0;
}

.table-responsive {
    overflow-x: auto;
}

/* CSS Variables */
:root {
    --primary-color: #3B82F6;
    --primary-dark: #1D4ED8;
    --primary-light: rgba(59, 130, 246, 0.1);
    --success-color: #10B981;
    --warning-color: #F59E0B;
    --error-color: #EF4444;
    --info-color: #06B6D4;
    --error-light: rgba(239, 68, 68, 0.1);
    --info-light: rgba(6, 182, 212, 0.1);
    --text-dark: #1F2937;
    --text-muted: #6B7280;
    --bg-light: #F9FAFB;
    --border-light: #E5E7EB;
}

.no-avatar {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f9fafb;
    color: #9ca3af;
    font-size: 18px;
    border-radius: 10px;
}

.no-avatar i {
    margin-bottom: 4px;
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
    max-width: 800px;
    width: 100%;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    animation: modalSlideIn 0.3s ease-out;
}

.modal-container.modal-sm {
    max-width: 500px;
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
    border-bottom: 1px solid var(--border-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--bg-light);
}

.modal-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0;
}

.modal-close {
    width: 40px;
    height: 40px;
    border: none;
    background: transparent;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: var(--error-light);
    color: var(--error-color);
}

.modal-body {
    padding: 30px;
    max-height: 60vh;
    overflow-y: auto;
}

.modal-footer {
    padding: 20px 30px;
    border-top: 1px solid var(--border-light);
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    background: var(--bg-light);
}

/* Profile Modal Styles */
.profile-section {
    margin-bottom: 30px;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
    padding: 20px;
    background: var(--bg-light);
    border-radius: 12px;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 16px;
    overflow: hidden;
    border: 3px solid white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-info h3 {
    font-size: 24px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
}

.profile-code {
    font-size: 16px;
    color: var(--primary-color);
    font-weight: 500;
    margin-bottom: 4px;
}

.profile-status {
    display: inline-block;
}

.profile-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.profile-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: white;
    border: 1px solid var(--border-light);
    border-radius: 10px;
}

.profile-item-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-light);
    color: var(--primary-color);
    flex-shrink: 0;
}

.profile-item-content {
    flex: 1;
}

.profile-item-label {
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 2px;
}

.profile-item-value {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-dark);
}

/* Delete Modal Styles */
.delete-warning {
    text-align: center;
    padding: 20px;
}

.warning-icon {
    margin: 0 auto 20px;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: var(--error-light);
    color: var(--error-color);
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-warning h3 {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 12px;
}

.delete-warning p {
    color: var(--text-muted);
    margin-bottom: 8px;
}

.warning-text {
    font-size: 14px;
    color: var(--error-color);
    font-weight: 500;
}

.btn-danger {
    background: var(--error-color);
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

/* Loading Spinner */
.loading-spinner {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 3px solid var(--border-light);
    border-top: 3px solid var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Modal */
@media (max-width: 768px) {
    .modal-container {
        margin: 10px;
        max-height: 95vh;
    }
    
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-grid {
        grid-template-columns: 1fr;
    }
    
    .modal-footer {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
let currentEmployeeId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const employeeRows = document.querySelectorAll('.employee-row');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.getAttribute('data-status');

            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Filter rows
            employeeRows.forEach(row => {
                if (status === 'all' || row.getAttribute('data-status') === status) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
});

// Show employee profile modal
function showEmployeeProfile(employeeId) {
    const modal = document.getElementById('employeeProfileModal');
    const content = document.getElementById('profileContent');
    
    // Show modal
    modal.style.display = 'flex';
    
    // Show loading
    content.innerHTML = '<div class="loading-spinner"><div class="spinner"></div></div>';
    
    // Fetch employee data
    fetch(`/employees/${employeeId}`)
        .then(response => response.text())
        .then(html => {
            // Parse the response to extract the employee data
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Find employee data from the current page
            const employeeRow = document.querySelector(`[data-employee-id="${employeeId}"]`);
            if (employeeRow) {
                const employeeName = employeeRow.querySelector('.employee-name').textContent;
                const employeeCode = employeeRow.querySelector('.employee-code').textContent;
                const nationalCode = employeeRow.querySelector('.employee-national').textContent;
                const birthDate = employeeRow.querySelector('.employee-birth').textContent;
                const status = employeeRow.querySelector('.employee-status').textContent;
                const maritalStatus = employeeRow.querySelector('.marital-status').textContent;
                const education = employeeRow.querySelector('.education-level').textContent;
                const avatar = employeeRow.querySelector('.employee-avatar img')?.src || '';
                
                // Build profile content
                let profileHtml = `
                    <div class="profile-header">
                        <div class="profile-avatar">
                            ${avatar ? 
                                `<img src="${avatar}" alt="${employeeName}">` :
                                `<div class="no-avatar"><i class="fas fa-user"></i></div>`
                            }
                        </div>
                        <div class="profile-info">
                            <h3>${employeeName}</h3>
                            <div class="profile-code">${employeeCode}</div>
                            <span class="employee-status ${getStatusClass(status)}">${status}</span>
                        </div>
                    </div>
                    
                    <div class="profile-section">
                        <h4 style="margin-bottom: 16px; color: var(--text-dark);">اطلاعات شخصی</h4>
                        <div class="profile-grid">
                            <div class="profile-item">
                                <div class="profile-item-icon">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 112 2m-2 2v8m-4-4h8m-4-4h8"></path>
                                    </svg>
                                </div>
                                <div class="profile-item-content">
                                    <div class="profile-item-label">کد ملی</div>
                                    <div class="profile-item-value">${nationalCode}</div>
                                </div>
                            </div>
                            
                            <div class="profile-item">
                                <div class="profile-item-icon">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="profile-item-content">
                                    <div class="profile-item-label">تاریخ تولد</div>
                                    <div class="profile-item-value">${birthDate}</div>
                                </div>
                            </div>
                            
                            <div class="profile-item">
                                <div class="profile-item-icon">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <div class="profile-item-content">
                                    <div class="profile-item-label">وضعیت تأهل</div>
                                    <div class="profile-item-value">${maritalStatus}</div>
                                </div>
                            </div>
                            
                            <div class="profile-item">
                                <div class="profile-item-icon">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div class="profile-item-content">
                                    <div class="profile-item-label">تحصیلات</div>
                                    <div class="profile-item-value">${education}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Add contact info if available
                const contactItems = employeeRow.querySelectorAll('.contact-item');
                if (contactItems.length > 0) {
                    profileHtml += `
                        <div class="profile-section">
                            <h4 style="margin-bottom: 16px; color: var(--text-dark);">اطلاعات تماس</h4>
                            <div class="profile-grid">
                    `;
                    
                    contactItems.forEach(item => {
                        const link = item.querySelector('a');
                        const text = link ? link.textContent : item.textContent;
                        const isPhone = item.querySelector('svg path[d*="3 5a2"]') !== null;
                        const isMobile = item.querySelector('svg path[d*="12 18h"]') !== null;
                        const isEmail = item.querySelector('svg path[d*="3 8l7.89"]') !== null;
                        
                        let label = 'تماس';
                        let icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>';
                        
                        if (isPhone) {
                            label = 'تلفن ثابت';
                        } else if (isMobile) {
                            label = 'تلفن همراه';
                            icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>';
                        } else if (isEmail) {
                            label = 'ایمیل';
                            icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>';
                        }
                        
                        profileHtml += `
                            <div class="profile-item">
                                <div class="profile-item-icon">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        ${icon}
                                    </svg>
                                </div>
                                <div class="profile-item-content">
                                    <div class="profile-item-label">${label}</div>
                                    <div class="profile-item-value">${text}</div>
                                </div>
                            </div>
                        `;
                    });
                    
                    profileHtml += '</div></div>';
                }
                
                content.innerHTML = profileHtml;
            } else {
                content.innerHTML = '<p>خطا در بارگذاری اطلاعات کارمند</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = '<p>خطا در بارگذاری اطلاعات کارمند</p>';
        });
}

// Close employee profile modal
function closeEmployeeProfile() {
    document.getElementById('employeeProfileModal').style.display = 'none';
}

// Confirm delete
function confirmDelete(employeeId, employeeName) {
    currentEmployeeId = employeeId;
    document.getElementById('deleteEmployeeName').textContent = `کارمند: ${employeeName}`;
    document.getElementById('deleteModal').style.display = 'flex';
}

// Close delete modal
function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    currentEmployeeId = null;
}

// Delete employee
function deleteEmployee() {
    if (currentEmployeeId) {
        const form = document.getElementById('deleteForm');
        form.action = `/employees/${currentEmployeeId}`;
        form.submit();
    }
}

// Get status class for styling
function getStatusClass(status) {
    const statusMap = {
        'فعال': 'status-active',
        'مرخصی': 'status-vacation', 
        'غیرفعال': 'status-inactive',
        'خاتمه همکاری': 'status-terminated'
    };
    return statusMap[status] || 'status-active';
}

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        closeEmployeeProfile();
        closeDeleteModal();
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEmployeeProfile();
        closeDeleteModal();
    }
});
</script>
@endpush
