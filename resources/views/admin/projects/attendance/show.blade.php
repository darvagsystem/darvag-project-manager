@extends('admin.layout')

@section('title', 'جزئیات حضور و غیاب - ' . $project->name)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">جزئیات حضور و غیاب</h1>
            <p class="page-subtitle">{{ $project->name }} - {{ $attendanceDate }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('projects.attendance.index', $project) }}?date={{ $attendanceDate }}" class="btn btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                بازگشت
            </a>
        </div>
    </div>
</div>

@if($attendances->count() > 0)
    <div class="attendance-details-grid">
        @foreach($attendances as $attendance)
            <div class="attendance-detail-card">
                <div class="attendance-header">
                    <div class="employee-info">
                        <div class="employee-avatar">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="employee-details">
                            <h3 class="employee-name">{{ $attendance->employee->full_name }}</h3>
                            <p class="employee-code">{{ $attendance->employee->employee_code }}</p>
                        </div>
                    </div>
                    <div class="attendance-status">
                        <span class="status-badge status-{{ $attendance->status }}">
                            {{ $attendance->status_text }}
                        </span>
                    </div>
                </div>

                <div class="attendance-details">
                    <div class="detail-section">
                        <h4 class="section-title">اطلاعات زمانی</h4>
                        <div class="detail-grid">
                            @if($attendance->check_in_time)
                            <div class="detail-item">
                                <span class="detail-label">ساعت ورود:</span>
                                <span class="detail-value">{{ $attendance->check_in_time }}</span>
                            </div>
                            @endif

                            @if($attendance->check_out_time)
                            <div class="detail-item">
                                <span class="detail-label">ساعت خروج:</span>
                                <span class="detail-value">{{ $attendance->check_out_time }}</span>
                            </div>
                            @endif

                            @if($attendance->hours_worked)
                            <div class="detail-item">
                                <span class="detail-label">ساعات کار:</span>
                                <span class="detail-value">{{ $attendance->formatted_hours_worked }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($attendance->salary_earned)
                    <div class="detail-section">
                        <h4 class="section-title">اطلاعات مالی</h4>
                        <div class="detail-grid">
                            <div class="detail-item highlight">
                                <span class="detail-label">حقوق روز:</span>
                                <span class="detail-value salary-amount">{{ number_format($attendance->salary_earned) }} تومان</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($attendance->notes)
                    <div class="detail-section">
                        <h4 class="section-title">یادداشت‌ها</h4>
                        <div class="notes-content">
                            {{ $attendance->notes }}
                        </div>
                    </div>
                    @endif
                </div>

                <div class="attendance-actions">
                    <a href="{{ route('projects.attendance.create', $project) }}?date={{ $attendanceDate }}" class="btn btn-sm btn-edit">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        ویرایش
                    </a>

                    <form action="{{ route('projects.attendance.destroy', [$project, $attendance]) }}" method="POST"
                          style="display: inline;"
                          onsubmit="return confirm('آیا از حذف این رکورد حضور و غیاب اطمینان دارید؟')">
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

    <!-- Summary Section -->
    <div class="attendance-summary">
        <h3 class="summary-title">خلاصه حضور و غیاب</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-icon present">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="summary-content">
                    <div class="summary-value">{{ $attendances->where('status', 'present')->count() }}</div>
                    <div class="summary-label">حاضر</div>
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-icon absent">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="summary-content">
                    <div class="summary-value">{{ $attendances->where('status', 'absent')->count() }}</div>
                    <div class="summary-label">غایب</div>
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-icon late">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="summary-content">
                    <div class="summary-value">{{ $attendances->where('status', 'late')->count() }}</div>
                    <div class="summary-label">تأخیر</div>
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-icon half-day">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18m9-9H3"></path>
                    </svg>
                </div>
                <div class="summary-content">
                    <div class="summary-value">{{ $attendances->where('status', 'half_day')->count() }}</div>
                    <div class="summary-label">نیمه روز</div>
                </div>
            </div>

            <div class="summary-item highlight">
                <div class="summary-icon salary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="summary-content">
                    <div class="summary-value">{{ number_format($attendances->sum('salary_earned')) }}</div>
                    <div class="summary-label">تومان (کل حقوق)</div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h3>هیچ رکورد حضور و غیابی برای این تاریخ ثبت نشده</h3>
        <p>برای ثبت حضور و غیاب کارمندان، روی دکمه زیر کلیک کنید.</p>
        <a href="{{ route('projects.attendance.create', $project) }}?date={{ $attendanceDate }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            ثبت حضور و غیاب
        </a>
    </div>
@endif

<style>
.attendance-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.attendance-detail-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.attendance-detail-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.attendance-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
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

.attendance-details {
    margin-bottom: 1.5rem;
}

.detail-section {
    margin-bottom: 1.5rem;
}

.detail-section:last-child {
    margin-bottom: 0;
}

.section-title {
    font-size: 1rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.75rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
}

.detail-item.highlight {
    background: #f0f9ff;
    border-color: #3b82f6;
}

.detail-label {
    font-size: 0.75rem;
    color: #6b7280;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-value {
    font-size: 0.875rem;
    color: #111827;
    font-weight: 600;
}

.detail-value.salary-amount {
    color: #059669;
    font-size: 1rem;
}

.notes-content {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    color: #374151;
    line-height: 1.6;
}

.attendance-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    padding-top: 1rem;
    border-top: 1px solid #f3f4f6;
}

.attendance-summary {
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 2rem;
    margin-bottom: 2rem;
}

.summary-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 1.5rem;
    text-align: center;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    transition: all 0.2s ease;
}

.summary-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.summary-item.highlight {
    background: #f0f9ff;
    border-color: #3b82f6;
}

.summary-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.summary-icon.present {
    background: #10b981;
}

.summary-icon.absent {
    background: #ef4444;
}

.summary-icon.late {
    background: #f59e0b;
}

.summary-icon.half-day {
    background: #3b82f6;
}

.summary-icon.salary {
    background: #059669;
}

.summary-content {
    flex: 1;
}

.summary-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.25rem;
}

.summary-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
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

.btn-edit {
    background: #f59e0b;
    color: white;
}

.btn-edit:hover {
    background: #d97706;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
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
    .attendance-details-grid {
        grid-template-columns: 1fr;
    }

    .summary-grid {
        grid-template-columns: repeat(2, 1fr);
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
