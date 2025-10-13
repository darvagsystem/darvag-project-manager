<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Project;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'project_id',
        'assigned_to',
        'created_by',
        'progress',
        'notes'
    ];

    protected $casts = [
        'due_date' => 'date',
        'progress' => 'integer'
    ];

    // روابط
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class);
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

    public function scopeForUser($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    // Accessors
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

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'in_progress' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

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

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'success',
            'medium' => 'info',
            'high' => 'warning',
            'urgent' => 'danger',
            default => 'secondary'
        };
    }

    // Methods
    public function canBeStartedBy($userId)
    {
        return $this->assigned_to == $userId && $this->status == 'pending';
    }

    public function canBeCompletedBy($userId)
    {
        return $this->assigned_to == $userId && $this->status == 'in_progress';
    }

    public function canBeViewedBy($userId)
    {
        return $this->created_by == $userId || $this->assigned_to == $userId;
    }

    public function start()
    {
        if ($this->status == 'pending') {
            $this->update(['status' => 'in_progress']);
            return true;
        }
        return false;
    }

    public function complete()
    {
        if ($this->status == 'in_progress') {
            $this->update([
                'status' => 'completed',
                'progress' => 100
            ]);
            return true;
        }
        return false;
    }

    public function cancel()
    {
        if (in_array($this->status, ['pending', 'in_progress'])) {
            $this->update(['status' => 'cancelled']);
            return true;
        }
        return false;
    }
}
