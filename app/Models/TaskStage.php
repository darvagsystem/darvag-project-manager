<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'sort_order',
        'is_active',
        'is_initial',
        'is_final',
        'requires_approval',
        'allowed_transitions'
    ];

    protected $casts = [
        'allowed_transitions' => 'array',
        'is_active' => 'boolean',
        'is_initial' => 'boolean',
        'is_final' => 'boolean',
        'requires_approval' => 'boolean'
    ];

    // روابط
    public function tasks()
    {
        return $this->hasMany(Task::class, 'current_stage_id');
    }

    public function stageHistories()
    {
        return $this->hasMany(TaskStageHistory::class, 'to_stage_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInitial($query)
    {
        return $query->where('is_initial', true);
    }

    public function scopeFinal($query)
    {
        return $query->where('is_final', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // Accessors
    public function getFormattedNameAttribute()
    {
        return $this->name;
    }

    public function getColorClassAttribute()
    {
        return match($this->color) {
            '#28a745' => 'success',
            '#007bff' => 'primary',
            '#ffc107' => 'warning',
            '#dc3545' => 'danger',
            '#6c757d' => 'secondary',
            '#17a2b8' => 'info',
            default => 'secondary'
        };
    }

    // Methods
    public function canTransitionTo($stageId)
    {
        if (!$this->allowed_transitions) {
            return true;
        }

        return in_array($stageId, $this->allowed_transitions);
    }

    public function getNextStages()
    {
        if (!$this->allowed_transitions) {
            return self::where('id', '!=', $this->id)->active()->ordered()->get();
        }

        return self::whereIn('id', $this->allowed_transitions)->active()->ordered()->get();
    }
}
