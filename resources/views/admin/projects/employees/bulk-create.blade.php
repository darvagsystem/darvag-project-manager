@extends('admin.layout')

@section('title', 'افزودن دسته‌ای کارمندان به پروژه - ' . $project->name)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">افزودن دسته‌ای کارمندان به پروژه</h1>
            <p class="page-subtitle">{{ $project->name }} - {{ $project->contract_number }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('panel.projects.employees.index', $project) }}" class="btn btn-outline-primary">
                <i class="mdi mdi-account-multiple me-1"></i>
                لیست کارمندان پروژه
            </a>
            <a href="{{ route('panel.projects.show', $project) }}" class="btn btn-secondary">
                <i class="mdi mdi-arrow-left me-1"></i>
                بازگشت به پروژه
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Employee Selection -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">انتخاب کارمندان</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="employee_search" class="form-label">جستجوی کارمند</label>
                    <input type="text" id="employee_search" class="form-control" placeholder="نام، کد پرسنلی، کد ملی...">
                </div>

                <div class="employee-list" style="max-height: 400px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 6px; padding: 10px;">
                    @foreach($availableEmployees as $employee)
                        <div class="employee-item" data-employee-id="{{ $employee->id }}" data-search="{{ strtolower($employee->full_name . ' ' . $employee->employee_code . ' ' . $employee->national_code) }}">
                            <label class="employee-checkbox">
                                <input type="checkbox" name="employee_ids[]" value="{{ $employee->id }}" class="employee-checkbox-input">
                                <div class="employee-info">
                                    <div class="employee-name">{{ $employee->full_name }}</div>
                                    <div class="employee-details">
                                        <span class="employee-code">{{ $employee->employee_code }}</span>
                                        <span class="employee-national">{{ $employee->national_code }}</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll()">انتخاب همه</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">لغو انتخاب همه</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Work Conditions -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">شرایط کاری</h3>
                <div class="card-tools">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="individual-salary-toggle">
                        <label class="form-check-label" for="individual-salary-toggle">
                            حقوق فردی
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('panel.projects.employees.bulk-store', $project) }}" method="POST" id="bulk-form">
                    @csrf
                    
                    <!-- Common Conditions -->
                    <div id="common-conditions">
                        <h5 class="mb-3">شرایط مشترک</h5>
                        
                        <!-- Working Days Per Month -->
                        <div class="mb-3">
                            <label for="working_days_per_month" class="form-label">تعداد روزهای کاری در ماه *</label>
                            <input type="number" id="working_days_per_month" name="working_days_per_month" class="form-control" value="30" min="1" max="31" required>
                        </div>

                        <!-- Absence Deduction Rate -->
                        <div class="mb-3">
                            <label for="absence_deduction_rate" class="form-label">درصد کسر غیبت *</label>
                            <div class="input-group">
                                <input type="number" id="absence_deduction_rate" name="absence_deduction_rate" class="form-control" value="100" min="0" max="100" step="0.01" required>
                                <span class="input-group-text">درصد</span>
                            </div>
                            <div class="form-text">مثال: 100% یعنی در صورت غیبت، کل حقوق روز کسر می‌شود</div>
                        </div>

                        <!-- Start Date -->
                        <div class="mb-3">
                            <label for="start_date" class="form-label">تاریخ شروع همکاری *</label>
                            <input type="text" id="start_date" name="start_date" class="form-control persian-date" placeholder="1403/01/15" required>
                        </div>

                        <!-- End Date -->
                        <div class="mb-3">
                            <label for="end_date" class="form-label">تاریخ پایان همکاری</label>
                            <input type="text" id="end_date" name="end_date" class="form-control persian-date" placeholder="1403/12/30">
                            <div class="form-text">اختیاری - در صورت خالی بودن، همکاری نامحدود در نظر گرفته می‌شود</div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">یادداشت‌ها</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="توضیحات اضافی در مورد شرایط کاری..."></textarea>
                        </div>
                    </div>

                    <!-- Individual Salary Settings -->
                    <div id="individual-conditions" style="display: none;">
                        <h5 class="mb-3">تنظیمات حقوق فردی</h5>
                        <div id="individual-salary-forms"></div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                            <i class="mdi mdi-account-multiple-plus me-1"></i>
                            <span id="submit-text">افزودن کارمندان انتخاب شده</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Selected Employees Summary -->
<div class="card mt-4" id="selected-summary" style="display: none;">
    <div class="card-header">
        <h3 class="card-title">کارمندان انتخاب شده</h3>
    </div>
    <div class="card-body">
        <div id="selected-employees-list"></div>
    </div>
</div>

<style>
.employee-item {
    padding: 10px;
    border-bottom: 1px solid #f3f4f6;
    transition: background-color 0.2s;
}

.employee-item:hover {
    background-color: #f9fafb;
}

.employee-item:last-child {
    border-bottom: none;
}

.employee-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
    margin: 0;
}

.employee-checkbox-input {
    margin-left: 10px;
}

.employee-info {
    flex: 1;
}

.employee-name {
    font-weight: 600;
    color: #374151;
    margin-bottom: 4px;
}

.employee-details {
    display: flex;
    gap: 15px;
    font-size: 0.875rem;
    color: #6b7280;
}

.employee-code {
    font-weight: 500;
}

.selected-employee {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 12px;
    background: #f0f9ff;
    border: 1px solid #0ea5e9;
    border-radius: 6px;
    margin-bottom: 8px;
}

.selected-employee-name {
    font-weight: 500;
    color: #0c4a6e;
}

.remove-employee {
    background: none;
    border: none;
    color: #dc2626;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.remove-employee:hover {
    background-color: #fef2f2;
}

.hidden {
    display: none !important;
}

.individual-salary-form {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: #f9fafb;
}

.individual-salary-form .card {
    border: none;
    background: transparent;
}

.individual-salary-form .card-header {
    background: #f3f4f6;
    border-bottom: 1px solid #e5e7eb;
    padding: 12px 16px;
}

.individual-salary-form .card-body {
    padding: 16px;
}

.form-check-input:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
}

.card-tools {
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-check {
    margin: 0;
}

.form-check-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
}
</style>

<script>
let selectedEmployees = [];

document.addEventListener('DOMContentLoaded', function() {
    initializeEmployeeSearch();
    initializeEmployeeSelection();
    initializeMoneyInputs();
    initializeDatePickers();
    initializeIndividualSalaryToggle();
});

function initializeEmployeeSearch() {
    const searchInput = document.getElementById('employee_search');
    const employeeItems = document.querySelectorAll('.employee-item');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        employeeItems.forEach(item => {
            const searchData = item.getAttribute('data-search');
            if (searchData.includes(searchTerm)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    });
}

function initializeEmployeeSelection() {
    const checkboxes = document.querySelectorAll('.employee-checkbox-input');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const employeeId = this.value;
            const employeeItem = this.closest('.employee-item');
            const employeeName = employeeItem.querySelector('.employee-name').textContent;

            if (this.checked) {
                if (!selectedEmployees.find(emp => emp.id === employeeId)) {
                    selectedEmployees.push({
                        id: employeeId,
                        name: employeeName
                    });
                }
            } else {
                selectedEmployees = selectedEmployees.filter(emp => emp.id !== employeeId);
            }

            updateSelectedSummary();
            updateSubmitButton();
        });
    });
}

function updateSelectedSummary() {
    const summaryCard = document.getElementById('selected-summary');
    const summaryList = document.getElementById('selected-employees-list');
    
    if (selectedEmployees.length > 0) {
        summaryCard.style.display = 'block';
        summaryList.innerHTML = selectedEmployees.map(emp => `
            <div class="selected-employee">
                <span class="selected-employee-name">${emp.name}</span>
                <button type="button" class="remove-employee" onclick="removeEmployee('${emp.id}')">
                    <i class="mdi mdi-close"></i>
                </button>
            </div>
        `).join('');
        
        // Update individual salary forms if enabled
        updateIndividualSalaryForms();
    } else {
        summaryCard.style.display = 'none';
        document.getElementById('individual-salary-forms').innerHTML = '';
    }
}

function removeEmployee(employeeId) {
    selectedEmployees = selectedEmployees.filter(emp => emp.id !== employeeId);

    // Uncheck the checkbox
    const checkbox = document.querySelector(`input[value="${employeeId}"]`);
    if (checkbox) {
        checkbox.checked = false;
    }

    updateSelectedSummary();
    updateSubmitButton();
}

function updateSubmitButton() {
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');

    if (selectedEmployees.length > 0) {
        submitBtn.disabled = false;
        submitText.textContent = `افزودن ${selectedEmployees.length} کارمند`;
    } else {
        submitBtn.disabled = true;
        submitText.textContent = 'افزودن کارمندان انتخاب شده';
    }
}

function selectAll() {
    const visibleCheckboxes = document.querySelectorAll('.employee-item:not(.hidden) .employee-checkbox-input');
    visibleCheckboxes.forEach(checkbox => {
        if (!checkbox.checked) {
            checkbox.checked = true;
            checkbox.dispatchEvent(new Event('change'));
        }
    });
}

function deselectAll() {
    const checkboxes = document.querySelectorAll('.employee-checkbox-input');
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            checkbox.checked = false;
            checkbox.dispatchEvent(new Event('change'));
        }
    });
}

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

// Money formatting functions
function formatMoney(value) {
    const numericValue = value.replace(/[^\d]/g, '');
    return numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function parseMoney(value) {
    return parseInt(value.replace(/[^\d]/g, '')) || 0;
}

function initializeMoneyInputs() {
    const moneyInputs = document.querySelectorAll('.money-input');

    moneyInputs.forEach(input => {
        input.addEventListener('input', function() {
            const cursorPosition = this.selectionStart;
            const oldValue = this.value;
            const newValue = formatMoney(this.value);

            this.value = newValue;

            const newCursorPosition = cursorPosition + (newValue.length - oldValue.length);
            this.setSelectionRange(newCursorPosition, newCursorPosition);

            const hiddenField = this.nextElementSibling;
            if (hiddenField && hiddenField.type === 'hidden') {
                hiddenField.value = parseMoney(this.value);
            }
        });
    });
}

function initializeDatePickers() {
    // Initialize Persian date picker for start date
    const startDateInput = document.getElementById('start_date');
    if (startDateInput) {
        startDateInput.addEventListener('click', function() {
            if (!this.persianDatePicker) {
                this.persianDatePicker = new PersianDatePicker(this, {
                    format: 'YYYY/MM/DD',
                    altField: '#start_date',
                    altFormat: 'YYYY/MM/DD',
                    calendar: {
                        persian: {
                            locale: 'fa',
                            showHint: true,
                            leapYearMode: 'algorithmic'
                        }
                    },
                    checkDate: function(unix) {
                        return unix < Date.now();
                    }
                });
            }
        });
    }

    // Initialize Persian date picker for end date
    const endDateInput = document.getElementById('end_date');
    if (endDateInput) {
        endDateInput.addEventListener('click', function() {
            if (!this.persianDatePicker) {
                this.persianDatePicker = new PersianDatePicker(this, {
                    format: 'YYYY/MM/DD',
                    altField: '#end_date',
                    altFormat: 'YYYY/MM/DD',
                    calendar: {
                        persian: {
                            locale: 'fa',
                            showHint: true,
                            leapYearMode: 'algorithmic'
                        }
                    },
                    checkDate: function(unix) {
                        const startDate = document.getElementById('start_date').value;
                        if (startDate) {
                            const startTimestamp = new PersianDate(startDate).valueOf();
                            return unix >= startTimestamp;
                        }
                        return true;
                    }
                });
            }
        });
    }
}

// Individual Salary Toggle
function initializeIndividualSalaryToggle() {
    const toggle = document.getElementById('individual-salary-toggle');
    const commonConditions = document.getElementById('common-conditions');
    const individualConditions = document.getElementById('individual-conditions');
    
    toggle.addEventListener('change', function() {
        if (this.checked) {
            commonConditions.style.display = 'none';
            individualConditions.style.display = 'block';
            updateIndividualSalaryForms();
        } else {
            commonConditions.style.display = 'block';
            individualConditions.style.display = 'none';
            document.getElementById('individual-salary-forms').innerHTML = '';
        }
    });
}

function updateIndividualSalaryForms() {
    const formsContainer = document.getElementById('individual-salary-forms');
    const isIndividualMode = document.getElementById('individual-salary-toggle').checked;
    
    if (!isIndividualMode || selectedEmployees.length === 0) {
        formsContainer.innerHTML = '';
        return;
    }
    
    formsContainer.innerHTML = selectedEmployees.map(emp => `
        <div class="individual-salary-form mb-4" data-employee-id="${emp.id}">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">${emp.name}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">نوع حقوق *</label>
                            <select name="employee_salary_type[${emp.id}]" class="form-select" required onchange="toggleIndividualSalaryFields('${emp.id}')">
                                <option value="">انتخاب نوع حقوق</option>
                                <option value="monthly">ماهیانه</option>
                                <option value="daily">روزانه</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div id="monthly-salary-${emp.id}" style="display: none;">
                                <label class="form-label">مبلغ حقوق ماهیانه (تومان) *</label>
                                <input type="text" name="employee_salary_amount[${emp.id}]" class="form-control money-input" placeholder="مثال: 15,000,000">
                                <input type="hidden" name="employee_salary_amount_raw[${emp.id}]">
                            </div>
                            <div id="daily-salary-${emp.id}" style="display: none;">
                                <label class="form-label">مبلغ حقوق روزانه (تومان) *</label>
                                <input type="text" name="employee_daily_salary[${emp.id}]" class="form-control money-input" placeholder="مثال: 500,000">
                                <input type="hidden" name="employee_daily_salary_raw[${emp.id}]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
    
    // Re-initialize money inputs for new forms
    initializeMoneyInputs();
}

function toggleIndividualSalaryFields(employeeId) {
    const salaryType = document.querySelector(`select[name="employee_salary_type[${employeeId}]"]`).value;
    const monthlyGroup = document.getElementById(`monthly-salary-${employeeId}`);
    const dailyGroup = document.getElementById(`daily-salary-${employeeId}`);
    
    if (salaryType === 'monthly') {
        monthlyGroup.style.display = 'block';
        dailyGroup.style.display = 'none';
        monthlyGroup.querySelector('input[name^="employee_salary_amount"]').required = true;
        dailyGroup.querySelector('input[name^="employee_daily_salary"]').required = false;
    } else if (salaryType === 'daily') {
        monthlyGroup.style.display = 'none';
        dailyGroup.style.display = 'block';
        monthlyGroup.querySelector('input[name^="employee_salary_amount"]').required = false;
        dailyGroup.querySelector('input[name^="employee_daily_salary"]').required = true;
    } else {
        monthlyGroup.style.display = 'none';
        dailyGroup.style.display = 'none';
        monthlyGroup.querySelector('input[name^="employee_salary_amount"]').required = false;
        dailyGroup.querySelector('input[name^="employee_daily_salary"]').required = false;
    }
}

// Form submission
document.getElementById('bulk-form').addEventListener('submit', function(e) {
    if (selectedEmployees.length === 0) {
        e.preventDefault();
        alert('لطفاً حداقل یک کارمند انتخاب کنید.');
        return;
    }
    
    // Add selected employee IDs to form
    selectedEmployees.forEach(emp => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'employee_ids[]';
        input.value = emp.id;
        this.appendChild(input);
    });
    
    // Add individual salary data if enabled
    const isIndividualMode = document.getElementById('individual-salary-toggle').checked;
    if (isIndividualMode) {
        const individualDataInput = document.createElement('input');
        individualDataInput.type = 'hidden';
        individualDataInput.name = 'individual_salary_mode';
        individualDataInput.value = '1';
        this.appendChild(individualDataInput);
    }
});
</script>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('js/persian-date-simple.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/persian-date-simple.js') }}"></script>
@endpush
