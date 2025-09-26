@extends('admin.layout')

@section('title', 'ثبت حضور و غیاب - ' . $project->name)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">ثبت حضور و غیاب</h1>
            <p class="page-subtitle">{{ $project->name }} - {{ $selectedDate }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('projects.attendance.index', $project) }}?date={{ $selectedDate }}" class="btn btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                بازگشت
            </a>
        </div>
    </div>
</div>

@if($projectEmployees->count() > 0)
    <form action="{{ route('projects.attendance.store', $project) }}" method="POST" id="attendanceForm">
        @csrf
        <input type="hidden" name="attendance_date" value="{{ $selectedDate }}">

        <div class="attendance-form-grid">
            @foreach($projectEmployees as $projectEmployee)
                @php
                    $existingAttendance = $attendances->get($projectEmployee->employee_id);
                @endphp
                <div class="attendance-form-card">
                    <div class="employee-header">
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
                    </div>

                    <div class="attendance-form-fields">
                        <!-- Status Selection -->
                        <div class="form-group">
                            <label class="form-label">وضعیت حضور *</label>
                            <div class="status-options">
                                <label class="status-option">
                                    <input type="radio" name="attendances[{{ $projectEmployee->employee_id }}][status]"
                                           value="present" {{ ($existingAttendance && $existingAttendance->status == 'present') ? 'checked' : '' }} required>
                                    <span class="status-badge status-present">حاضر</span>
                                </label>
                                <label class="status-option">
                                    <input type="radio" name="attendances[{{ $projectEmployee->employee_id }}][status]"
                                           value="absent" {{ ($existingAttendance && $existingAttendance->status == 'absent') ? 'checked' : '' }}>
                                    <span class="status-badge status-absent">غایب</span>
                                </label>
                                <label class="status-option">
                                    <input type="radio" name="attendances[{{ $projectEmployee->employee_id }}][status]"
                                           value="late" {{ ($existingAttendance && $existingAttendance->status == 'late') ? 'checked' : '' }}>
                                    <span class="status-badge status-late">تأخیر</span>
                                </label>
                                <label class="status-option">
                                    <input type="radio" name="attendances[{{ $projectEmployee->employee_id }}][status]"
                                           value="half_day" {{ ($existingAttendance && $existingAttendance->status == 'half_day') ? 'checked' : '' }}>
                                    <span class="status-badge status-half_day">نیمه روز</span>
                                </label>
                            </div>
                        </div>

                        <!-- Time Fields -->
                        <div class="time-fields">
                            <div class="form-group">
                                <label class="form-label">ساعت ورود</label>
                                <input type="time" name="attendances[{{ $projectEmployee->employee_id }}][check_in_time]"
                                       class="form-input" value="{{ $existingAttendance ? $existingAttendance->check_in_time : '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">ساعت خروج</label>
                                <input type="time" name="attendances[{{ $projectEmployee->employee_id }}][check_out_time]"
                                       class="form-input" value="{{ $existingAttendance ? $existingAttendance->check_out_time : '' }}">
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="form-group">
                            <label class="form-label">یادداشت</label>
                            <textarea name="attendances[{{ $projectEmployee->employee_id }}][notes]"
                                      class="form-textarea" rows="2"
                                      placeholder="توضیحات اضافی...">{{ $existingAttendance ? $existingAttendance->notes : '' }}</textarea>
                        </div>

                        <!-- Hidden employee_id -->
                        <input type="hidden" name="attendances[{{ $projectEmployee->employee_id }}][employee_id]" value="{{ $projectEmployee->employee_id }}">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-lg">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                ثبت حضور و غیاب
            </button>
            <a href="{{ route('projects.attendance.index', $project) }}?date={{ $selectedDate }}" class="btn btn-light btn-lg">انصراف</a>
        </div>
    </form>
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
.attendance-form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.attendance-form-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.attendance-form-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.employee-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f3f4f6;
}

.employee-info {
    display: flex;
    align-items: center;
    gap: 1rem;
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

.attendance-form-fields {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.status-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.status-option {
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.status-option:hover {
    border-color: #d1d5db;
    background: #f9fafb;
}

.status-option input[type="radio"] {
    margin: 0;
    margin-left: 0.5rem;
}

.status-option input[type="radio"]:checked + .status-badge {
    transform: scale(1.05);
    box-shadow: 0 0 0 2px #3b82f6;
}

.status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-align: center;
    transition: all 0.2s ease;
    flex: 1;
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

.time-fields {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-input,
.form-textarea {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 60px;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    padding: 2rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1rem;
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
    .attendance-form-grid {
        grid-template-columns: 1fr;
    }

    .status-options {
        grid-template-columns: 1fr;
    }

    .time-fields {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill check-in time with current time if not set
    const checkInInputs = document.querySelectorAll('input[name*="[check_in_time]"]');
    checkInInputs.forEach(input => {
        if (!input.value) {
            const now = new Date();
            const timeString = now.toTimeString().slice(0, 5);
            input.value = timeString;
        }
    });

    // Auto-calculate check-out time (8 hours later) when check-in is set
    const checkInInputsArray = Array.from(checkInInputs);
    checkInInputsArray.forEach((checkInInput, index) => {
        checkInInput.addEventListener('change', function() {
            const checkOutInput = document.querySelectorAll('input[name*="[check_out_time]"]')[index];
            if (this.value && !checkOutInput.value) {
                const checkInTime = new Date('2000-01-01T' + this.value);
                const checkOutTime = new Date(checkInTime.getTime() + 8 * 60 * 60 * 1000); // Add 8 hours
                checkOutInput.value = checkOutTime.toTimeString().slice(0, 5);
            }
        });
    });
});
</script>
@endsection
