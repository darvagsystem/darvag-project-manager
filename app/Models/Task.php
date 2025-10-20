<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'start_date',
        'completed_date',
        'assigned_to',
        'created_by',
        'project_id',
        'category_id',
        'estimated_hours',
        'actual_hours',
        'progress',
        'notes'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'start_date' => 'datetime',
        'completed_date' => 'datetime',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
        'progress' => 'integer'
    ];

    /**
     * Get the user assigned to this task.
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the user who created this task.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the project this task belongs to.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the category this task belongs to.
     */
    public function category()
    {
        return $this->belongsTo(TaskCategory::class, 'category_id');
    }

    /**
     * Get the files attached to this task.
     */
    public function files()
    {
        return $this->hasMany(TaskFile::class);
    }

    /**
     * Get the comments for this task.
     */
    public function comments()
    {
        return $this->hasMany(TaskComment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the activity logs for this task.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'subject_id')
                    ->where('subject_type', self::class)
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Get the formatted status.
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'pending' => 'در انتظار',
            'in_progress' => 'در حال انجام',
            'completed' => 'تکمیل شده',
            'cancelled' => 'لغو شده',
            'on_hold' => 'در انتظار',
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
     * Get the progress percentage.
     */
    public function getProgressPercentageAttribute()
    {
        return $this->progress . '%';
    }

    /**
     * Check if the task is overdue.
     */
    public function getIsOverdueAttribute()
    {
        if ($this->status === 'completed' || !$this->due_date) {
            return false;
        }

        return now()->isAfter($this->due_date);
    }

    /**
     * Check if the task is assigned to a specific user.
     */
    public function isAssignedTo($userId)
    {
        return $this->assigned_to === $userId;
    }

    /**
     * Check if the task can be closed by a specific user.
     */
    public function canBeClosedBy($userId)
    {
        return $this->assigned_to === $userId || $this->created_by === $userId;
    }

    /**
     * Scope for tasks assigned to a specific user.
     */
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    /**
     * Scope for tasks created by a specific user.
     */
    public function scopeCreatedBy($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    /**
     * Scope for tasks with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for overdue tasks.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', 'completed')
                    ->where('due_date', '<', now());
    }

    /**
     * Scope for tasks related to a specific project.
     */
    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    /**
     * Scope for tasks not related to any project.
     */
    public function scopeWithoutProject($query)
    {
        return $query->whereNull('project_id');
    }

    /**
     * Scope for tasks with a specific category.
     */
    public function scopeWithCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope for high priority tasks.
     */
    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    /**
     * Scope for active tasks (not completed or cancelled).
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['completed', 'cancelled']);
    }
}
