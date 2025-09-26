@extends('admin.layout')

@section('title', 'کارمندان پروژه - ' . $project->name)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">کارمندان پروژه</h1>
            <p class="page-subtitle">{{ $project->name }} - {{ $project->contract_number }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('projects.employees.create', $project) }}" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                افزودن کارمند
            </a>
            <a href="{{ route('projects.attendance.index', $project) }}" class="btn btn-success">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                حضور و غیاب
            </a>
            <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                بازگشت به پروژه
            </a>
        </div>
    </div>
</div>

@if($projectEmployees->count() > 0)
    <div class="employees-grid">
        @foreach($projectEmployees as $projectEmployee)
        <div class="employee-card {{ !$projectEmployee->is_active ? 'inactive' : '' }}">
            <div class="employee-header">
                <div class="employee-avatar">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="employee-info">
                    <h3 class="employee-name">{{ $projectEmployee->employee->full_name }}</h3>
                    <p class="employee-code">{{ $projectEmployee->employee->employee_code }}</p>
                </div>
                <div class="employee-status">
                    <span class="status-badge {{ $projectEmployee->is_active ? 'active' : 'inactive' }}">
                        {{ $projectEmployee->is_active ? 'فعال' : 'غیرفعال' }}
                    </span>
                </div>
            </div>

            <div class="employee-details">
                <div class="detail-row">
                    <span class="detail-label">نوع حقوق:</span>
                    <span class="detail-value">{{ $projectEmployee->salary_type_text }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">مبلغ حقوق:</span>
                    <span class="detail-value">{{ $projectEmployee->formatted_salary }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">روزهای کاری ماه:</span>
                    <span class="detail-value">{{ $projectEmployee->working_days_per_month }} روز</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">درصد کسر غیبت:</span>
                    <span class="detail-value">{{ $projectEmployee->absence_deduction_rate }}%</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">تاریخ شروع:</span>
                    <span class="detail-value">{{ $projectEmployee->start_date->format('Y/m/d') }}</span>
                </div>
                @if($projectEmployee->end_date)
                <div class="detail-row">
                    <span class="detail-label">تاریخ پایان:</span>
                    <span class="detail-value">{{ $projectEmployee->end_date->format('Y/m/d') }}</span>
                </div>
                @endif
                @if($projectEmployee->notes)
                <div class="detail-row full-width">
                    <span class="detail-label">یادداشت:</span>
                    <span class="detail-value">{{ $projectEmployee->notes }}</span>
                </div>
                @endif
            </div>

            <div class="employee-actions">
                <a href="{{ route('projects.employees.edit', [$project, $projectEmployee]) }}" class="btn btn-sm btn-edit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    ویرایش
                </a>

                <form action="{{ route('projects.employees.toggle-status', [$project, $projectEmployee]) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm {{ $projectEmployee->is_active ? 'btn-warning' : 'btn-success' }}">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                        {{ $projectEmployee->is_active ? 'غیرفعال کردن' : 'فعال کردن' }}
                    </button>
                </form>

                <form action="{{ route('projects.employees.destroy', [$project, $projectEmployee]) }}" method="POST"
                      style="display: inline;"
                      onsubmit="return confirm('آیا از حذف این کارمند از پروژه اطمینان دارید؟ این عمل تمام سوابق حضور و غیاب را نیز حذف خواهد کرد.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        حذف
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
        </div>
        <h3>هنوز کارمندی به این پروژه اختصاص داده نشده</h3>
        <p>برای شروع، اولین کارمند را به پروژه اضافه کنید.</p>
        <a href="{{ route('projects.employees.create', $project) }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            افزودن اولین کارمند
        </a>
    </div>
@endif

<style>
.employees-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.employee-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.employee-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.employee-card.inactive {
    opacity: 0.7;
    background: #f9fafb;
}

.employee-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f3f4f6;
}

.employee-avatar {
    width: 48px;
    height: 48px;
    background: #f3f4f6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
}

.employee-info {
    flex: 1;
}

.employee-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
    margin: 0 0 0.25rem 0;
}

.employee-code {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.employee-status {
    display: flex;
    align-items: center;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.active {
    background: #d1fae5;
    color: #059669;
}

.status-badge.inactive {
    background: #f3f4f6;
    color: #6b7280;
}

.employee-details {
    margin-bottom: 1.5rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f9fafb;
}

.detail-row.full-width {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.25rem;
}

.detail-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

.detail-value {
    font-size: 0.875rem;
    color: #111827;
    font-weight: 600;
}

.employee-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-edit {
    background: #f59e0b;
    color: white;
}

.btn-edit:hover {
    background: #d97706;
}

.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover {
    background: #059669;
}

.btn-warning {
    background: #f59e0b;
    color: white;
}

.btn-warning:hover {
    background: #d97706;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    border: 2px dashed #d1d5db;
}

.empty-icon {
    margin: 0 auto 1.5rem;
    width: 80px;
    height: 80px;
    background: #f3f4f6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .employees-grid {
        grid-template-columns: 1fr;
    }

    .employee-actions {
        flex-direction: column;
    }

    .btn {
        justify-content: center;
    }
}
</style>
@endsection
