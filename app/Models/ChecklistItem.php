<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'checklist_id',
        'title',
        'description',
        'is_completed',
        'completed_at',
        'priority',
        'due_date',
        'order'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
        'due_date' => 'datetime'
    ];

    /**
     * Get the formatted due date in Persian
     */
    public function getPersianDueDateAttribute()
    {
        if (!$this->due_date) {
            return null;
        }

        return \App\Services\PersianDateService::carbonToPersianDateTime($this->due_date);
    }

    /**
     * Get due date formatted for input fields
     */
    public function getDueDateForInputAttribute()
    {
        if (!$this->due_date) {
            return '';
        }

        return \App\Services\PersianDateService::formatForInput($this->due_date, true);
    }

    /**
     * Get the formatted completed date in Persian
     */
    public function getPersianCompletedAtAttribute()
    {
        if (!$this->completed_at) {
            return null;
        }

        return \App\Services\PersianDateService::carbonToPersianDateTime($this->completed_at);
    }

    /**
     * Get the checklist that owns the item.
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
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
     * Get the status text.
     */
    public function getStatusTextAttribute()
    {
        return $this->is_completed ? 'انجام شده' : 'انجام نشده';
    }

    /**
     * Scope for completed items.
     */
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    /**
     * Scope for pending items.
     */
    public function scopePending($query)
    {
        return $query->where('is_completed', false);
    }

    /**
     * Scope for high priority items.
     */
    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    /**
     * Scope for overdue items.
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->where('is_completed', false);
    }

    /**
     * Mark item as completed.
     */
    public function markAsCompleted()
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now()
        ]);
    }

    /**
     * Mark item as pending.
     */
    public function markAsPending()
    {
        $this->update([
            'is_completed' => false,
            'completed_at' => null
        ]);
    }
}
