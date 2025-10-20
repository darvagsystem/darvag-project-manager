<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLoggerService
{
    /**
     * Log an activity
     */
    public static function log(
        string $action,
        string $description,
        ?Model $model = null,
        array $properties = [],
        string $level = 'info'
    ): ActivityLog {
        $request = request();

        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => $request ? $request->ip() : null,
            'user_agent' => $request ? $request->userAgent() : null,
            'url' => $request ? $request->fullUrl() : null,
            'level' => $level
        ]);
    }

    /**
     * Log user login
     */
    public static function logLogin(User $user): ActivityLog
    {
        return self::log(
            'login',
            "کاربر {$user->name} وارد سیستم شد",
            $user,
            ['email' => $user->email],
            'success'
        );
    }

    /**
     * Log user logout
     */
    public static function logLogout(User $user): ActivityLog
    {
        return self::log(
            'logout',
            "کاربر {$user->name} از سیستم خارج شد",
            $user,
            ['email' => $user->email],
            'info'
        );
    }

    /**
     * Log model creation
     */
    public static function logCreated(Model $model, array $properties = []): ActivityLog
    {
        $modelName = self::getModelName($model);
        $description = "{$modelName} جدید ایجاد شد";

        if (method_exists($model, 'name')) {
            $description .= ": {$model->name}";
        } elseif (method_exists($model, 'title')) {
            $description .= ": {$model->title}";
        }

        return self::log('created', $description, $model, $properties, 'success');
    }

    /**
     * Log model update
     */
    public static function logUpdated(Model $model, array $oldData = [], array $newData = []): ActivityLog
    {
        $modelName = self::getModelName($model);
        $description = "{$modelName} به‌روزرسانی شد";

        if (method_exists($model, 'name')) {
            $description .= ": {$model->name}";
        } elseif (method_exists($model, 'title')) {
            $description .= ": {$model->title}";
        }

        $properties = [
            'old_data' => $oldData,
            'new_data' => $newData,
            'changed_fields' => array_keys(array_diff_assoc($newData, $oldData))
        ];

        return self::log('updated', $description, $model, $properties, 'info');
    }

    /**
     * Log model deletion
     */
    public static function logDeleted(Model $model, array $properties = []): ActivityLog
    {
        $modelName = self::getModelName($model);
        $description = "{$modelName} حذف شد";

        if (method_exists($model, 'name')) {
            $description .= ": {$model->name}";
        } elseif (method_exists($model, 'title')) {
            $description .= ": {$model->title}";
        }

        return self::log('deleted', $description, $model, $properties, 'warning');
    }

    /**
     * Log file upload
     */
    public static function logFileUpload(Model $file, ?Model $relatedModel = null): ActivityLog
    {
        $description = "فایل آپلود شد: {$file->name}";

        if ($relatedModel) {
            $modelName = self::getModelName($relatedModel);
            $description .= " در {$modelName}";
        }

        return self::log('uploaded', $description, $file, [
            'file_size' => $file->size ?? null,
            'file_type' => $file->mime_type ?? null,
            'related_model' => $relatedModel ? get_class($relatedModel) : null,
            'related_model_id' => $relatedModel ? $relatedModel->id : null
        ], 'success');
    }

    /**
     * Log file download
     */
    public static function logFileDownload(Model $file, ?Model $relatedModel = null): ActivityLog
    {
        $description = "فایل دانلود شد: {$file->name}";

        if ($relatedModel) {
            $modelName = self::getModelName($relatedModel);
            $description .= " از {$modelName}";
        }

        return self::log('downloaded', $description, $file, [
            'file_size' => $file->size ?? null,
            'file_type' => $file->mime_type ?? null,
            'related_model' => $relatedModel ? get_class($relatedModel) : null,
            'related_model_id' => $relatedModel ? $relatedModel->id : null
        ], 'info');
    }

    /**
     * Log assignment
     */
    public static function logAssignment(Model $model, Model $assignedTo, string $assignmentType = 'assigned'): ActivityLog
    {
        $modelName = self::getModelName($model);
        $assignedToName = self::getModelName($assignedTo);

        $description = $assignmentType === 'assigned'
            ? "{$modelName} به {$assignedToName} تخصیص داده شد"
            : "تخصیص {$modelName} از {$assignedToName} لغو شد";

        return self::log($assignmentType, $description, $model, [
            'assigned_to_type' => get_class($assignedTo),
            'assigned_to_id' => $assignedTo->id,
            'assigned_to_name' => $assignedTo->name ?? $assignedTo->title ?? 'نامشخص'
        ], 'info');
    }

    /**
     * Log status change
     */
    public static function logStatusChange(Model $model, string $oldStatus, string $newStatus): ActivityLog
    {
        $modelName = self::getModelName($model);
        $description = "وضعیت {$modelName} از {$oldStatus} به {$newStatus} تغییر کرد";

        if (method_exists($model, 'name')) {
            $description .= ": {$model->name}";
        }

        return self::log('status_changed', $description, $model, [
            'old_status' => $oldStatus,
            'new_status' => $newStatus
        ], 'info');
    }

    /**
     * Log project progress update
     */
    public static function logProjectProgress(Model $project, int $oldProgress, int $newProgress): ActivityLog
    {
        $description = "پیشرفت پروژه {$project->name} از {$oldProgress}% به {$newProgress}% تغییر کرد";

        return self::log('progress_updated', $description, $project, [
            'old_progress' => $oldProgress,
            'new_progress' => $newProgress,
            'progress_change' => $newProgress - $oldProgress
        ], 'info');
    }

    /**
     * Get model name in Persian
     */
    private static function getModelName(Model $model): string
    {
        $className = get_class($model);

        return match($className) {
            'App\Models\Project' => 'پروژه',
            'App\Models\Employee' => 'کارمند',
            'App\Models\Client' => 'مشتری',
            'App\Models\FileManager' => 'فایل',
            'App\Models\User' => 'کاربر',
            'App\Models\ProjectMilestone' => 'مایل‌استون',
            'App\Models\ProjectResource' => 'منبع پروژه',
            'App\Models\ProjectRisk' => 'ریسک پروژه',
            default => class_basename($className)
        };
    }

    /**
     * Get activity statistics
     */
    public static function getStatistics(int $days = 30): array
    {
        $startDate = now()->subDays($days);

        return [
            'total_activities' => ActivityLog::where('created_at', '>=', $startDate)->count(),
            'activities_by_user' => ActivityLog::where('created_at', '>=', $startDate)
                ->with('user')
                ->selectRaw('user_id, count(*) as count')
                ->groupBy('user_id')
                ->get(),
            'activities_by_action' => ActivityLog::where('created_at', '>=', $startDate)
                ->selectRaw('action, count(*) as count')
                ->groupBy('action')
                ->get(),
            'activities_by_model' => ActivityLog::where('created_at', '>=', $startDate)
                ->selectRaw('model_type, count(*) as count')
                ->groupBy('model_type')
                ->get(),
            'daily_activities' => ActivityLog::where('created_at', '>=', $startDate)
                ->selectRaw('DATE(created_at) as date, count(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get()
        ];
    }
}
