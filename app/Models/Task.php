<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'type',
        'due_date',
        'due_time',
        'estimated_hours',
        'actual_hours',
        'project_id',
        'assigned_to',
        'created_by',
        'tags',
        'notes',
        'is_reminder',
        'reminder_at',
        'is_recurring',
        'recurring_settings'
    ];

    protected $casts = [
        'tags' => 'array',
        'recurring_settings' => 'array',
        'due_date' => 'date',
        'due_time' => 'datetime:H:i',
        'reminder_at' => 'datetime',
        'is_reminder' => 'boolean',
        'is_recurring' => 'boolean'
    ];

    // روابط
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessors
    public function getPriorityTextAttribute()
    {
        return match($this->priority) {
            'low' => 'کم',
            'medium' => 'متوسط',
            'high' => 'زیاد',
            'urgent' => 'فوری',
            default => 'نامشخص'
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'در انتظار',
            'in_progress' => 'در حال انجام',
            'completed' => 'تکمیل شده',
            'cancelled' => 'لغو شده',
            default => 'نامشخص'
        };
    }

    public function getTypeTextAttribute()
    {
        return match($this->type) {
            'task' => 'کار',
            'reminder' => 'یادآوری',
            'meeting' => 'جلسه',
            'deadline' => 'مهلت',
            default => 'نامشخص'
        };
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            'urgent' => 'dark',
            default => 'secondary'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'secondary',
            'in_progress' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    public function getDueDateTimeAttribute()
    {
        if ($this->due_date && $this->due_time) {
            return Carbon::parse($this->due_date . ' ' . $this->due_time);
        }
        return $this->due_date ? Carbon::parse($this->due_date) : null;
    }

    public function getIsOverdueAttribute()
    {
        if (!$this->due_date) return false;

        $dueDateTime = $this->due_date_time;
        if (!$dueDateTime) return false;

        return $dueDateTime->isPast() && $this->status !== 'completed';
    }

    public function getDaysUntilDueAttribute()
    {
        if (!$this->due_date) return null;

        $dueDateTime = $this->due_date_time;
        if (!$dueDateTime) return null;

        return Carbon::now()->diffInDays($dueDateTime, false);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', Carbon::now()->toDateString())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    public function scopeDueToday($query)
    {
        return $query->where('due_date', Carbon::now()->toDateString());
    }

    public function scopeDueThisWeek($query)
    {
        return $query->whereBetween('due_date', [
            Carbon::now()->startOfWeek()->toDateString(),
            Carbon::now()->endOfWeek()->toDateString()
        ]);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeReminders($query)
    {
        return $query->where('is_reminder', true);
    }

    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }
}
