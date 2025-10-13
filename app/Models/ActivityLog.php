<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'properties',
        'ip_address',
        'user_agent',
        'url',
        'level'
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user who performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the model that was affected
     */
    public function model()
    {
        return $this->morphTo('model', 'model_type', 'model_id');
    }

    /**
     * Get formatted action
     */
    public function getFormattedActionAttribute(): string
    {
        return match($this->action) {
            'created' => 'ایجاد شد',
            'updated' => 'به‌روزرسانی شد',
            'deleted' => 'حذف شد',
            'viewed' => 'مشاهده شد',
            'downloaded' => 'دانلود شد',
            'uploaded' => 'آپلود شد',
            'assigned' => 'تخصیص داده شد',
            'unassigned' => 'تخصیص لغو شد',
            'status_changed' => 'وضعیت تغییر کرد',
            'login' => 'وارد شد',
            'logout' => 'خارج شد',
            default => $this->action
        };
    }

    /**
     * Get formatted level
     */
    public function getFormattedLevelAttribute(): string
    {
        return match($this->level) {
            'info' => 'اطلاعات',
            'warning' => 'هشدار',
            'error' => 'خطا',
            'success' => 'موفق',
            default => $this->level
        };
    }

    /**
     * Get level color class
     */
    public function getLevelColorAttribute(): string
    {
        return match($this->level) {
            'info' => 'primary',
            'warning' => 'warning',
            'error' => 'danger',
            'success' => 'success',
            default => 'secondary'
        };
    }

    /**
     * Get model name
     */
    public function getModelNameAttribute(): string
    {
        if (!$this->model_type) {
            return 'سیستم';
        }

        return match($this->model_type) {
            'App\Models\Project' => 'پروژه',
            'App\Models\Employee' => 'کارمند',
            'App\Models\Client' => 'مشتری',
            'App\Models\FileManager' => 'فایل',
            'App\Models\Task' => 'وظیفه',
            'App\Models\User' => 'کاربر',
            default => class_basename($this->model_type)
        };
    }

    /**
     * Scope for specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for specific action
     */
    public function scopeForAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope for specific model
     */
    public function scopeForModel($query, $modelType, $modelId = null)
    {
        $query = $query->where('model_type', $modelType);
        
        if ($modelId) {
            $query->where('model_id', $modelId);
        }
        
        return $query;
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope for recent activities
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
