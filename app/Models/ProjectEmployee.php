<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectEmployee extends Model
{
    protected $fillable = [
        'project_id',
        'employee_id',
        'salary_type',
        'salary_amount',
        'working_days_per_month',
        'daily_salary',
        'absence_deduction_rate',
        'start_date',
        'end_date',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'salary_amount' => 'decimal:2',
        'daily_salary' => 'decimal:2',
        'absence_deduction_rate' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }


    public function getFormattedSalaryAttribute()
    {
        if ($this->salary_type === 'monthly') {
            return number_format($this->salary_amount) . ' تومان (ماهیانه)';
        } else {
            return number_format($this->daily_salary) . ' تومان (روزانه)';
        }
    }

    public function getSalaryTypeTextAttribute()
    {
        return $this->salary_type === 'monthly' ? 'ماهیانه' : 'روزانه';
    }

    public function getFormattedStartDateAttribute()
    {
        return $this->start_date ? \App\Services\PersianDateService::carbonToPersian($this->start_date) : null;
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? \App\Services\PersianDateService::carbonToPersian($this->end_date) : null;
    }

    public function getSalaryAmountFormattedAttribute()
    {
        if ($this->salary_type === 'monthly') {
            return number_format($this->salary_amount) . ' تومان';
        } else {
            return number_format($this->daily_salary) . ' تومان';
        }
    }

    public function getWorkingDaysTextAttribute()
    {
        return $this->working_days_per_month . ' روز';
    }

    public function getAbsenceDeductionTextAttribute()
    {
        return $this->absence_deduction_rate . '%';
    }
}
