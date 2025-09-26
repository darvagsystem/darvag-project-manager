<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_code',
        'first_name',
        'last_name',
        'national_code',
        'birth_date',
        'marital_status',
        'education',
        'status',
        'phone',
        'mobile',
        'email',
        'address',
        'emergency_contact',
        'avatar',
        'notes'
    ];

    /**
     * Boot method to automatically generate employee code
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            \Log::info('Employee creating event triggered', [
                'employee_code' => $employee->employee_code,
                'national_code' => $employee->national_code
            ]);

            if (empty($employee->employee_code) && !empty($employee->national_code)) {
                $employee->employee_code = 'DVG' . $employee->national_code;
                \Log::info('Generated employee code: ' . $employee->employee_code);
            }
        });
    }

    /**
     * Get the bank accounts for the employee.
     */
    public function bankAccounts()
    {
        return $this->hasMany(EmployeeBankAccount::class);
    }

    /**
     * Get the default bank account for the employee.
     */
    public function defaultBankAccount()
    {
        return $this->hasOne(EmployeeBankAccount::class)->where('is_default', true);
    }

    /**
     * Get the documents for the employee.
     */
    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    /**
     * Get the projects assigned to this employee.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_employees')
                    ->withPivot([
                        'salary_type', 'salary_amount', 'working_days_per_month',
                        'daily_salary', 'absence_deduction_rate', 'start_date',
                        'end_date', 'is_active', 'notes'
                    ])
                    ->withTimestamps();
    }

    /**
     * Get the project employees pivot records.
     */
    public function projectEmployees()
    {
        return $this->hasMany(ProjectEmployee::class);
    }

    /**
     * Get the attendances for this employee.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Scope a query to only include active employees.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive employees.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Get the employee's full name.
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the formatted marital status.
     */
    public function getFormattedMaritalStatusAttribute()
    {
        return match($this->marital_status) {
            'married' => 'متأهل',
            'single' => 'مجرد',
            'divorced' => 'مطلقه',
            'widowed' => 'بیوه',
            default => 'نامشخص'
        };
    }

    /**
     * Get the formatted education level.
     */
    public function getFormattedEducationAttribute()
    {
        return match($this->education) {
            'illiterate' => 'بی‌سواد',
            'elementary' => 'ابتدایی',
            'middle_school' => 'راهنمایی',
            'high_school' => 'دبیرستان',
            'diploma' => 'دیپلم',
            'associate' => 'فوق دیپلم',
            'bachelor' => 'کارشناسی',
            'master' => 'کارشناسی ارشد',
            'phd' => 'دکتری',
            default => 'نامشخص'
        };
    }

    /**
     * Get the formatted status.
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'active' => 'فعال',
            'vacation' => 'مرخصی',
            'inactive' => 'غیرفعال',
            'terminated' => 'خاتمه همکاری',
            default => $this->status
        };
    }

    /**
     * Generate employee code from national code
     */
    public static function generateEmployeeCode($nationalCode)
    {
        return 'DVG' . $nationalCode;
    }

    /**
     * Check if employee code already exists
     */
    public static function employeeCodeExists($employeeCode)
    {
        return static::where('employee_code', $employeeCode)->exists();
    }
}
