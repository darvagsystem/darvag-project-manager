<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_id',
        'contract_number',
        'initial_estimate',
        'final_amount',
        'contract_coefficient',
        'department',
        'contract_start_date',
        'contract_end_date',
        'actual_start_date',
        'actual_end_date',
        'status',
        'priority',
        'progress',
        'project_manager',
        'location',
        'category',
        'currency',
        'description',
        'notes'
    ];

    protected $casts = [
        'initial_estimate' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'contract_coefficient' => 'decimal:2',
        'progress' => 'integer'
    ];

    /**
     * Get the client that owns the project.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get project files and folders
     */
    public function files()
    {
        return $this->hasMany(FileManager::class);
    }

    /**
     * Get root folders for this project
     */
    public function rootFolders()
    {
        return $this->hasMany(FileManager::class)
            ->where('is_folder', true)
            ->whereNull('parent_id');
    }

    /**
     * Get root files for this project
     */
    public function rootFiles()
    {
        return $this->hasMany(FileManager::class)
            ->where('is_folder', false)
            ->whereNull('parent_id');
    }

    /**
     * Get the employees assigned to this project.
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'project_employees')
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
     * Get the attendances for this project.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the formatted status.
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'planning' => 'در حال برنامه‌ریزی',
            'in_progress' => 'در حال اجرا',
            'completed' => 'تکمیل شده',
            'paused' => 'متوقف شده',
            'cancelled' => 'لغو شده',
            default => 'نامشخص'
        };
    }

    /**
     * Get the formatted priority.
     */
    public function getFormattedPriorityAttribute()
    {
        return match($this->priority) {
            'low' => 'پایین',
            'normal' => 'عادی',
            'high' => 'بالا',
            'urgent' => 'فوری',
            default => 'عادی'
        };
    }

    /**
     * Get the formatted category.
     */
    public function getFormattedCategoryAttribute()
    {
        return match($this->category) {
            'construction' => 'ساخت و ساز',
            'industrial' => 'صنعتی',
            'infrastructure' => 'زیرساخت',
            'energy' => 'انرژی',
            'petrochemical' => 'پتروشیمی',
            'other' => 'سایر',
            default => 'نامشخص'
        };
    }

    /**
     * Get the formatted currency.
     */
    public function getFormattedCurrencyAttribute()
    {
        return match($this->currency) {
            'IRR' => 'ریال',
            'USD' => 'دلار آمریکا',
            'EUR' => 'یورو',
            default => 'ریال'
        };
    }

    /**
     * Get the formatted initial estimate.
     */
    public function getFormattedInitialEstimateAttribute()
    {
        return number_format($this->initial_estimate) . ' ' . $this->formatted_currency;
    }

    /**
     * Get the formatted final amount.
     */
    public function getFormattedFinalAmountAttribute()
    {
        return number_format($this->final_amount) . ' ' . $this->formatted_currency;
    }

    /**
     * Get the progress percentage.
     */
    public function getProgressPercentageAttribute()
    {
        return $this->progress . '%';
    }

    /**
     * Get the project duration in days.
     */
    public function getDurationAttribute()
    {
        if ($this->contract_start_date && $this->contract_end_date) {
            // Since we're storing Persian dates as strings, we can't calculate duration
            return null;
        }
        return null;
    }

    /**
     * Get the actual duration in days.
     */
    public function getActualDurationAttribute()
    {
        if ($this->actual_start_date && $this->actual_end_date) {
            // Since we're storing Persian dates as strings, we can't calculate duration
            return null;
        }
        return null;
    }

    /**
     * Check if the project is overdue.
     */
    public function getIsOverdueAttribute()
    {
        // Since we're storing Persian dates as strings, we can't check if overdue
        return false;
    }

    /**
     * Scope for active projects.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope for completed projects.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for paused projects.
     */
    public function scopePaused($query)
    {
        return $query->where('status', 'paused');
    }

    /**
     * Scope for planning projects.
     */
    public function scopePlanning($query)
    {
        return $query->where('status', 'planning');
    }

    /**
     * Scope for high priority projects.
     */
    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    /**
     * Scope for overdue projects.
     */
    public function scopeOverdue($query)
    {
        // Since we're storing Persian dates as strings, we can't check overdue
        return $query->where('status', '!=', 'completed');
    }
}
