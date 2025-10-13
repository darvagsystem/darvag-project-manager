<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogService
{
    /**
     * Log user activity
     */
    public static function logActivity(string $action, array $data = [], string $level = 'info'): void
    {
        $user = Auth::user();
        $logData = [
            'action' => $action,
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : 'Guest',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => Carbon::now()->toDateTimeString(),
            'data' => $data
        ];

        Log::channel('activity')->{$level}('User Activity', $logData);
    }

    /**
     * Log system events
     */
    public static function logSystemEvent(string $event, array $data = [], string $level = 'info'): void
    {
        $logData = [
            'event' => $event,
            'timestamp' => Carbon::now()->toDateTimeString(),
            'data' => $data
        ];

        Log::channel('system')->{$level}('System Event', $logData);
    }

    /**
     * Log API requests
     */
    public static function logApiRequest(string $endpoint, array $requestData = [], array $responseData = [], int $statusCode = 200): void
    {
        $logData = [
            'endpoint' => $endpoint,
            'method' => request()->method(),
            'request_data' => $requestData,
            'response_data' => $responseData,
            'status_code' => $statusCode,
            'timestamp' => Carbon::now()->toDateTimeString(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ];

        Log::channel('api')->info('API Request', $logData);
    }

    /**
     * Log database operations
     */
    public static function logDatabaseOperation(string $operation, string $table, array $data = [], string $level = 'info'): void
    {
        $logData = [
            'operation' => $operation,
            'table' => $table,
            'data' => $data,
            'timestamp' => Carbon::now()->toDateTimeString(),
            'user_id' => Auth::id()
        ];

        Log::channel('database')->{$level}('Database Operation', $logData);
    }

    /**
     * Log security events
     */
    public static function logSecurityEvent(string $event, array $data = [], string $level = 'warning'): void
    {
        $logData = [
            'event' => $event,
            'data' => $data,
            'timestamp' => Carbon::now()->toDateTimeString(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'user_id' => Auth::id()
        ];

        Log::channel('security')->{$level}('Security Event', $logData);
    }

    /**
     * Log file operations
     */
    public static function logFileOperation(string $operation, string $filePath, array $data = [], string $level = 'info'): void
    {
        $logData = [
            'operation' => $operation,
            'file_path' => $filePath,
            'data' => $data,
            'timestamp' => Carbon::now()->toDateTimeString(),
            'user_id' => Auth::id()
        ];

        Log::channel('files')->{$level}('File Operation', $logData);
    }

    /**
     * Get activity logs
     */
    public static function getActivityLogs(int $limit = 100): array
    {
        $logPath = storage_path('logs/activity.log');

        if (!file_exists($logPath)) {
            return [];
        }

        $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $logs = [];

        foreach (array_slice($lines, -$limit) as $line) {
            $logEntry = json_decode($line, true);
            if ($logEntry) {
                $logs[] = $logEntry;
            }
        }

        return array_reverse($logs);
    }

    /**
     * Get system logs
     */
    public static function getSystemLogs(int $limit = 100): array
    {
        $logPath = storage_path('logs/system.log');

        if (!file_exists($logPath)) {
            return [];
        }

        $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $logs = [];

        foreach (array_slice($lines, -$limit) as $line) {
            $logEntry = json_decode($line, true);
            if ($logEntry) {
                $logs[] = $logEntry;
            }
        }

        return array_reverse($logs);
    }

    /**
     * Get all logs combined
     */
    public static function getAllLogs(int $limit = 200): array
    {
        $channels = ['activity', 'system', 'api', 'database', 'security', 'files'];
        $allLogs = [];

        foreach ($channels as $channel) {
            $logPath = storage_path("logs/{$channel}.log");

            if (file_exists($logPath)) {
                $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                foreach (array_slice($lines, -50) as $line) {
                    $logEntry = json_decode($line, true);
                    if ($logEntry) {
                        $logEntry['channel'] = $channel;
                        $allLogs[] = $logEntry;
                    }
                }
            }
        }

        // Sort by timestamp
        usort($allLogs, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        return array_slice($allLogs, 0, $limit);
    }
}
