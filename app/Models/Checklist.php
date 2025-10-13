<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'category_id',
        'color',
        'is_public',
        'due_date',
        'priority',
        'status'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'is_public' => 'boolean'
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
     * Get the user that owns the checklist.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the checklist.
     */
    public function category()
    {
        return $this->belongsTo(ChecklistCategory::class);
    }

    /**
     * Get the items for the checklist.
     */
    public function items()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    /**
     * Get completed items count.
     */
    public function getCompletedItemsCountAttribute()
    {
        return $this->items()->where('is_completed', true)->count();
    }

    /**
     * Get total items count.
     */
    public function getTotalItemsCountAttribute()
    {
        return $this->items()->count();
    }

    /**
     * Get progress percentage.
     */
    public function getProgressPercentageAttribute()
    {
        $total = $this->total_items_count;
        if ($total === 0) {
            return 0;
        }
        return round(($this->completed_items_count / $total) * 100);
    }

    /**
     * Get the formatted status.
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'active' => 'فعال',
            'completed' => 'تکمیل شده',
            'paused' => 'متوقف شده',
            'archived' => 'آرشیو شده',
            default => 'فعال'
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
     * Scope for active checklists.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for completed checklists.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for public checklists.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for user's checklists.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
