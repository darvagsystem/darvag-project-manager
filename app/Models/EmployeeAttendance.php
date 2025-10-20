<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\PersianDateService;

class EmployeeAttendance extends Model
{
    protected $fillable = [
        'project_id',
        'employee_id',
        'project_employee_id',
        'attendance_date',
        'persian_date',
        'status',
        'check_in_time',
        'check_out_time',
        'working_hours',
        'overtime_hours',
        'useful_hours',
        'notes'
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'check_in_time' => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
        'working_hours' => 'integer'
    ];

    /**
     * Get the project that owns the attendance.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the employee that owns the attendance.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the project employee assignment.
     */
    public function projectEmployee(): BelongsTo
    {
        return $this->belongsTo(ProjectEmployee::class);
    }

    /**
     * Get the formatted status.
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'present' => 'حاضر',
            'absent' => 'غایب',
            'late' => 'تأخیر',
            'half_day' => 'نیم روز',
            'vacation' => 'مرخصی',
            'sick_leave' => 'مرخصی استعلاجی',
            default => 'نامشخص'
        };
    }

    /**
     * Get the status color class.
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'present' => 'success',
            'absent' => 'danger',
            'late' => 'warning',
            'half_day' => 'info',
            'vacation' => 'primary',
            'sick_leave' => 'secondary',
            default => 'secondary'
        };
    }

    /**
     * Get formatted working hours.
     */
    public function getFormattedWorkingHoursAttribute()
    {
        if (!$this->working_hours) {
            return 'نامشخص';
        }

        $hours = floor($this->working_hours / 60);
        $minutes = $this->working_hours % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours} ساعت و {$minutes} دقیقه";
        } elseif ($hours > 0) {
            return "{$hours} ساعت";
        } else {
            return "{$minutes} دقیقه";
        }
    }

    /**
     * Get formatted check-in time.
     */
    public function getFormattedCheckInTimeAttribute()
    {
        return $this->check_in_time ? $this->check_in_time->format('H:i') : 'نامشخص';
    }

    /**
     * Get formatted check-out time.
     */
    public function getFormattedCheckOutTimeAttribute()
    {
        return $this->check_out_time ? $this->check_out_time->format('H:i') : 'نامشخص';
    }

    /**
     * Calculate working hours from check-in and check-out times.
     */
    public function calculateWorkingHours()
    {
        if (!$this->check_in_time || !$this->check_out_time) {
            return null;
        }

        $checkIn = \Carbon\Carbon::parse($this->check_in_time);
        $checkOut = \Carbon\Carbon::parse($this->check_out_time);

        if ($checkOut->lessThan($checkIn)) {
            // Handle overnight shifts
            $checkOut->addDay();
        }

        return $checkOut->diffInMinutes($checkIn);
    }

    /**
     * Scope for a specific project.
     */
    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    /**
     * Scope for a specific employee.
     */
    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    /**
     * Scope for a specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('attendance_date', $date);
    }

    /**
     * Scope for a date range.
     */
    public function scopeForDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('attendance_date', [$startDate, $endDate]);
    }

    /**
     * Scope for present employees.
     */
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    /**
     * Scope for absent employees.
     */
    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }
}
