<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'project_id',
        'employee_id',
        'attendance_date',
        'status',
        'check_in_time',
        'check_out_time',
        'hours_worked',
        'salary_earned',
        'notes'
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'check_in_time' => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
        'salary_earned' => 'decimal:2'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function projectEmployee()
    {
        return $this->belongsTo(ProjectEmployee::class, 'employee_id', 'employee_id')
                    ->where('project_id', $this->project_id);
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'present' => 'حاضر',
            'absent' => 'غایب',
            'late' => 'تأخیر',
            'half_day' => 'نیمه روز',
            default => 'نامشخص'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'present' => 'success',
            'absent' => 'danger',
            'late' => 'warning',
            'half_day' => 'info',
            default => 'secondary'
        };
    }

    public function getFormattedHoursWorkedAttribute()
    {
        if (!$this->hours_worked) return '0 ساعت';

        $hours = floor($this->hours_worked / 60);
        $minutes = $this->hours_worked % 60;

        if ($minutes > 0) {
            return $hours . ' ساعت و ' . $minutes . ' دقیقه';
        }

        return $hours . ' ساعت';
    }
}
