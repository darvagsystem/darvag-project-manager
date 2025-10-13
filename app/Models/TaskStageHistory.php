<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStageHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'from_stage_id',
        'to_stage_id',
        'changed_by',
        'comment',
        'metadata',
        'changed_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'changed_at' => 'datetime'
    ];

    // روابط
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function fromStage()
    {
        return $this->belongsTo(TaskStage::class, 'from_stage_id');
    }

    public function toStage()
    {
        return $this->belongsTo(TaskStage::class, 'to_stage_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    // Scopes
    public function scopeForTask($query, $taskId)
    {
        return $query->where('task_id', $taskId);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('changed_at', 'desc')->limit($limit);
    }

    // Accessors
    public function getTransitionDescriptionAttribute()
    {
        $from = $this->fromStage ? $this->fromStage->name : 'شروع';
        $to = $this->toStage ? $this->toStage->name : 'پایان';

        return "از {$from} به {$to}";
    }

    public function getDurationAttribute()
    {
        if (!$this->fromStage || !$this->toStage) {
            return null;
        }

        // محاسبه مدت زمان در مرحله قبلی
        $nextHistory = self::where('task_id', $this->task_id)
            ->where('id', '>', $this->id)
            ->orderBy('changed_at')
            ->first();

        if ($nextHistory) {
            return $this->changed_at->diffInDays($nextHistory->changed_at);
        }

        return null;
    }
}
