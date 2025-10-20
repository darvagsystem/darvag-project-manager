<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'color',
        'icon',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get the tasks for this category.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'category_id');
    }

    /**
     * Get active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get categories ordered by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get the task count for this category.
     */
    public function getTaskCountAttribute()
    {
        return $this->tasks()->count();
    }

    /**
     * Get the active task count for this category.
     */
    public function getActiveTaskCountAttribute()
    {
        return $this->tasks()->active()->count();
    }

    /**
     * Get the completed task count for this category.
     */
    public function getCompletedTaskCountAttribute()
    {
        return $this->tasks()->where('status', 'completed')->count();
    }
}
