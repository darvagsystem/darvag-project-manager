<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTagRequirement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'tag_id',
        'is_required',
        'description',
        'priority',
        'created_by'
    ];

    protected $casts = [
        'is_required' => 'boolean'
    ];

    /**
     * Get the project that owns the requirement.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the tag for this requirement.
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    /**
     * Get the user who created the requirement.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get priority label.
     */
    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            1 => 'بالا',
            2 => 'متوسط',
            3 => 'پایین',
            default => 'نامشخص'
        };
    }

    /**
     * Get priority color.
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            1 => 'danger',
            2 => 'warning',
            3 => 'success',
            default => 'secondary'
        };
    }

    /**
     * Scope for required tags.
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    /**
     * Scope for optional tags.
     */
    public function scopeOptional($query)
    {
        return $query->where('is_required', false);
    }

    /**
     * Scope for high priority.
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority', 1);
    }

    /**
     * Scope for medium priority.
     */
    public function scopeMediumPriority($query)
    {
        return $query->where('priority', 2);
    }

    /**
     * Scope for low priority.
     */
    public function scopeLowPriority($query)
    {
        return $query->where('priority', 3);
    }
}
