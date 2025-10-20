<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
        'is_internal',
        'parent_id'
    ];

    protected $casts = [
        'is_internal' => 'boolean'
    ];

    /**
     * Get the task this comment belongs to.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who made this comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment (for replies).
     */
    public function parent()
    {
        return $this->belongsTo(TaskComment::class, 'parent_id');
    }

    /**
     * Get the replies to this comment.
     */
    public function replies()
    {
        return $this->hasMany(TaskComment::class, 'parent_id')->orderBy('created_at');
    }

    /**
     * Check if this comment has replies.
     */
    public function getHasRepliesAttribute()
    {
        return $this->replies()->count() > 0;
    }

    /**
     * Get the formatted comment with line breaks.
     */
    public function getFormattedCommentAttribute()
    {
        return nl2br(e($this->comment));
    }

    /**
     * Scope for internal comments only.
     */
    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    /**
     * Scope for public comments only.
     */
    public function scopePublic($query)
    {
        return $query->where('is_internal', false);
    }

    /**
     * Scope for top-level comments (not replies).
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for replies only.
     */
    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }
}
