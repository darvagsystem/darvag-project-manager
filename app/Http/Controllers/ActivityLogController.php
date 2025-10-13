<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\ActivityLoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        // Filter by level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(50);

        // Get filter options
        $users = \App\Models\User::select('id', 'name')->get();
        $actions = ActivityLog::select('action')->distinct()->pluck('action');
        $modelTypes = ActivityLog::select('model_type')->distinct()->whereNotNull('model_type')->pluck('model_type');
        $levels = ['info', 'warning', 'error', 'success'];

        // Get statistics
        $statistics = ActivityLoggerService::getStatistics(30);

        return view('admin.activity-logs.index', compact(
            'logs', 
            'users', 
            'actions', 
            'modelTypes', 
            'levels', 
            'statistics'
        ));
    }

    /**
     * Get activity logs as JSON for AJAX requests
     */
    public function getLogs(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Apply filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->limit(100)->get();

        return response()->json([
            'success' => true,
            'logs' => $logs,
            'total' => $logs->count()
        ]);
    }

    /**
     * Get activity statistics
     */
    public function getStatistics(Request $request)
    {
        $days = $request->get('days', 30);
        $statistics = ActivityLoggerService::getStatistics($days);

        return response()->json([
            'success' => true,
            'statistics' => $statistics
        ]);
    }

    /**
     * Get user activity summary
     */
    public function getUserActivity(Request $request, $userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        
        $activities = ActivityLog::where('user_id', $userId)
            ->with('model')
            ->latest()
            ->limit(50)
            ->get();

        $summary = ActivityLog::where('user_id', $userId)
            ->selectRaw('action, count(*) as count')
            ->groupBy('action')
            ->get();

        return response()->json([
            'success' => true,
            'user' => $user,
            'activities' => $activities,
            'summary' => $summary
        ]);
    }

    /**
     * Get model activity history
     */
    public function getModelActivity(Request $request, $modelType, $modelId)
    {
        $activities = ActivityLog::where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->with('user')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'activities' => $activities
        ]);
    }

    /**
     * Clear old activity logs
     */
    public function clearOldLogs(Request $request)
    {
        $days = $request->get('days', 90);
        $deletedCount = ActivityLog::where('created_at', '<', now()->subDays($days))->delete();

        // Log this action
        ActivityLoggerService::log(
            'logs_cleared',
            "لاگ‌های قدیمی‌تر از {$days} روز پاک شدند",
            null,
            ['deleted_count' => $deletedCount, 'days' => $days],
            'warning'
        );

        return response()->json([
            'success' => true,
            'message' => "{$deletedCount} لاگ قدیمی پاک شد",
            'deleted_count' => $deletedCount
        ]);
    }

    /**
     * Export activity logs
     */
    public function export(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Apply same filters as index
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->limit(1000)->get();

        $filename = 'activity_logs_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'تاریخ',
                'کاربر',
                'عملیات',
                'توضیحات',
                'نوع مدل',
                'شناسه مدل',
                'سطح',
                'IP',
                'URL'
            ]);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user ? $log->user->name : 'سیستم',
                    $log->formatted_action,
                    $log->description,
                    $log->model_name,
                    $log->model_id,
                    $log->formatted_level,
                    $log->ip_address,
                    $log->url
                ]);
            }

            fclose($file);
        };

        // Log export action
        ActivityLoggerService::log(
            'logs_exported',
            'لاگ‌های فعالیت صادر شدند',
            null,
            ['export_count' => $logs->count()],
            'info'
        );

        return response()->stream($callback, 200, $headers);
    }
}