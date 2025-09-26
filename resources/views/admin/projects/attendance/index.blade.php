@extends('admin.layout')

@section('title', 'حضور و غیاب - ' . $project->name)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">حضور و غیاب</h1>
            <p class="page-subtitle">{{ $project->name }} - {{ $project->contract_number }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('projects.employees.index', $project) }}" class="btn btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                مدیریت کارمندان
            </a>
            <a href="{{ route('projects.show', $project) }}" class="btn btn-light">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                بازگشت به پروژه
            </a>
        </div>
    </div>
</div>

<!-- Date Selector -->
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-body">
        <form method="GET" action="{{ route('projects.attendance.index', $project) }}" class="date-selector-form">
            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <label for="date" style="font-weight: 600; color: #374151;">تاریخ:</label>
                    <input type="date" id="date" name="date" value="{{ $selectedDate }}"
                           class="form-input" style="padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    مشاهده
                </button>
                <a href="{{ route('projects.attendance.create', $project) }}?date={{ $selectedDate }}" class="btn btn-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    ثبت حضور و غیاب
                </a>
            </div>
        </form>
    </div>
</div>

@if($projectEmployees->count() > 0)
    <div class="attendance-grid">
        @foreach($projectEmployees as $projectEmployee)
            @php
                $attendance = $attendances->get($projectEmployee->employee_id);
            @endphp
            <div class="attendance-card {{ $attendance ? 'has-attendance' : 'no-attendance' }}">
                <div class="attendance-header">
                    <div class="employee-info">
                        <div class="employee-avatar">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="employee-details">
                            <h3 class="employee-name">{{ $projectEmployee->employee->full_name }}</h3>
                            <p class="employee-code">{{ $projectEmployee->employee->employee_code }}</p>
                            <p class="salary-info">{{ $projectEmployee->formatted_salary }}</p>
                        </div>
                    </div>
                    <div class="attendance-status">
                        @if($attendance)
                            <span class="status-badge status-{{ $attendance->status }}">
                                {{ $attendance->status_text }}
                            </span>
                        @else
                            <span class="status-badge status-pending">ثبت نشده</span>
                        @endif
                    </div>
                </div>

                @if($attendance)
                    <div class="attendance-details">
                        @if($attendance->check_in_time)
                        <div class="detail-row">
                            <span class="detail-label">ساعت ورود:</span>
                            <span class="detail-value">{{ $attendance->check_in_time }}</span>
                        </div>
                        @endif

                        @if($attendance->check_out_time)
                        <div class="detail-row">
                            <span class="detail-label">ساعت خروج:</span>
                            <span class="detail-value">{{ $attendance->check_out_time }}</span>
                        </div>
                        @endif

                        @if($attendance->hours_worked)
                        <div class="detail-row">
                            <span class="detail-label">ساعات کار:</span>
                            <span class="detail-value">{{ $attendance->formatted_hours_worked }}</span>
                        </div>
                        @endif

                        @if($attendance->salary_earned)
                        <div class="detail-row">
                            <span class="detail-label">حقوق روز:</span>
                            <span class="detail-value">{{ number_format($attendance->salary_earned) }} تومان</span>
                        </div>
                        @endif

                        @if($attendance->notes)
                        <div class="detail-row full-width">
                            <span class="detail-label">یادداشت:</span>
                            <span class="detail-value">{{ $attendance->notes }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="attendance-actions">
                        <a href="{{ route('projects.attendance.show', [$project, $selectedDate]) }}" class="btn btn-sm btn-info">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            مشاهده جزئیات
                        </a>
                    </div>
                @else
                    <div class="no-attendance-message">
                        <p>هنوز حضور و غیاب این کارمند برای این تاریخ ثبت نشده است.</p>
                        <a href="{{ route('projects.attendance.create', $project) }}?date={{ $selectedDate }}" class="btn btn-sm btn-primary">
                            ثبت حضور و غیاب
                        </a>
                    </div>
                @endif
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
        <h3>هیچ کارمند فعالی در این پروژه وجود ندارد</h3>
        <p>ابتدا کارمندان را به پروژه اضافه کنید تا بتوانید حضور و غیاب آن‌ها را ثبت کنید.</p>
        <a href="{{ route('projects.employees.create', $project) }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            افزودن کارمند
        </a>
    </div>
@endif

<style>
.attendance-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.attendance-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.attendance-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.attendance-card.has-attendance {
    border-left: 4px solid #10b981;
}

.attendance-card.no-attendance {
    border-left: 4px solid #f59e0b;
}

.attendance-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f3f4f6;
}

.employee-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
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

.employee-details {
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
    margin: 0 0 0.25rem 0;
}

.salary-info {
    font-size: 0.75rem;
    color: #059669;
    font-weight: 500;
    margin: 0;
}

.attendance-status {
    display: flex;
    align-items: center;
}

.status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-align: center;
}

.status-present {
    background: #d1fae5;
    color: #059669;
}

.status-absent {
    background: #fee2e2;
    color: #dc2626;
}

.status-late {
    background: #fef3c7;
    color: #d97706;
}

.status-half_day {
    background: #dbeafe;
    color: #2563eb;
}

.status-pending {
    background: #f3f4f6;
    color: #6b7280;
}

.attendance-details {
    margin-bottom: 1rem;
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

.attendance-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.no-attendance-message {
    text-align: center;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px dashed #d1d5db;
}

.no-attendance-message p {
    color: #6b7280;
    margin-bottom: 1rem;
    margin: 0 0 1rem 0;
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

.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover {
    background: #059669;
}

.btn-info {
    background: #06b6d4;
    color: white;
}

.btn-info:hover {
    background: #0891b2;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-light {
    background: #f8fafc;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-light:hover {
    background: #f1f5f9;
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
    .attendance-grid {
        grid-template-columns: 1fr;
    }

    .attendance-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .attendance-actions {
        flex-direction: column;
    }

    .btn {
        justify-content: center;
    }
}
</style>
@endsection
