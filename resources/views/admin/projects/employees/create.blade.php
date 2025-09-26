@extends('admin.layout')

@section('title', 'افزودن کارمند به پروژه - ' . $project->name)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">افزودن کارمند به پروژه</h1>
            <p class="page-subtitle">{{ $project->name }} - {{ $project->contract_number }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                بازگشت به پروژه
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">اطلاعات کارمند و شرایط کاری</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('projects.employees.store', $project) }}" method="POST">
            @csrf

            <div class="form-grid">
                <!-- Employee Selection -->
                <div class="form-group">
                    <label for="employee_id" class="form-label">انتخاب کارمند *</label>
                    <select id="employee_id" name="employee_id" class="form-select" required>
                        <option value="">انتخاب کارمند</option>
                        @foreach($availableEmployees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->full_name }} - {{ $employee->employee_code }}
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Salary Type -->
                <div class="form-group">
                    <label for="salary_type" class="form-label">نوع حقوق *</label>
                    <select id="salary_type" name="salary_type" class="form-select" required onchange="toggleSalaryFields()">
                        <option value="">انتخاب نوع حقوق</option>
                        <option value="monthly" {{ old('salary_type') == 'monthly' ? 'selected' : '' }}>ماهیانه</option>
                        <option value="daily" {{ old('salary_type') == 'daily' ? 'selected' : '' }}>روزانه</option>
                    </select>
                    @error('salary_type')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Monthly Salary -->
                <div class="form-group" id="monthly-salary-group" style="display: none;">
                    <label for="salary_amount" class="form-label">مبلغ حقوق ماهیانه (تومان) *</label>
                    <input type="number" id="salary_amount" name="salary_amount" class="form-input"
                           value="{{ old('salary_amount') }}" placeholder="مثال: 15000000" min="0" step="1000">
                    @error('salary_amount')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Daily Salary -->
                <div class="form-group" id="daily-salary-group" style="display: none;">
                    <label for="daily_salary" class="form-label">مبلغ حقوق روزانه (تومان) *</label>
                    <input type="number" id="daily_salary" name="daily_salary" class="form-input"
                           value="{{ old('daily_salary') }}" placeholder="مثال: 500000" min="0" step="1000">
                    @error('daily_salary')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Working Days Per Month -->
                <div class="form-group">
                    <label for="working_days_per_month" class="form-label">تعداد روزهای کاری در ماه *</label>
                    <input type="number" id="working_days_per_month" name="working_days_per_month" class="form-input"
                           value="{{ old('working_days_per_month', 30) }}" placeholder="30" min="1" max="31" required>
                    @error('working_days_per_month')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Absence Deduction Rate -->
                <div class="form-group">
                    <label for="absence_deduction_rate" class="form-label">درصد کسر غیبت *</label>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="number" id="absence_deduction_rate" name="absence_deduction_rate" class="form-input"
                               value="{{ old('absence_deduction_rate', 100) }}" placeholder="100" min="0" max="100" step="0.01" required>
                        <span style="color: #6b7280; font-size: 0.875rem;">درصد</span>
                    </div>
                    <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">
                        مثال: 100% یعنی در صورت غیبت، کل حقوق روز کسر می‌شود
                    </div>
                    @error('absence_deduction_rate')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Start Date -->
                <div class="form-group">
                    <label for="start_date" class="form-label">تاریخ شروع همکاری *</label>
                    <input type="date" id="start_date" name="start_date" class="form-input"
                           value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- End Date -->
                <div class="form-group">
                    <label for="end_date" class="form-label">تاریخ پایان همکاری</label>
                    <input type="date" id="end_date" name="end_date" class="form-input"
                           value="{{ old('end_date') }}">
                    <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">
                        اختیاری - در صورت خالی بودن، همکاری نامحدود در نظر گرفته می‌شود
                    </div>
                    @error('end_date')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="form-group full-width">
                    <label for="notes" class="form-label">یادداشت‌ها</label>
                    <textarea id="notes" name="notes" class="form-textarea" rows="3"
                              placeholder="توضیحات اضافی در مورد شرایط کاری...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    اختصاص کارمند به پروژه
                </button>
                <a href="{{ route('projects.show', $project) }}" class="btn btn-light">انصراف</a>
            </div>
        </form>
    </div>
</div>

<style>
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-input,
.form-select,
.form-textarea {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-error {
    color: #dc2626;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
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

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }
}
</style>

<script>
function toggleSalaryFields() {
    const salaryType = document.getElementById('salary_type').value;
    const monthlyGroup = document.getElementById('monthly-salary-group');
    const dailyGroup = document.getElementById('daily-salary-group');

    if (salaryType === 'monthly') {
        monthlyGroup.style.display = 'block';
        dailyGroup.style.display = 'none';
        document.getElementById('salary_amount').required = true;
        document.getElementById('daily_salary').required = false;
    } else if (salaryType === 'daily') {
        monthlyGroup.style.display = 'none';
        dailyGroup.style.display = 'block';
        document.getElementById('salary_amount').required = false;
        document.getElementById('daily_salary').required = true;
    } else {
        monthlyGroup.style.display = 'none';
        dailyGroup.style.display = 'none';
        document.getElementById('salary_amount').required = false;
        document.getElementById('daily_salary').required = false;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleSalaryFields();
});
</script>
@endsection
