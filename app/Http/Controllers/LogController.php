<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    /**
     * Display logs page
     */
    public function index(Request $request)
    {
        $channel = $request->get('channel', 'all');
        $level = $request->get('level', 'all');
        $limit = $request->get('limit', 100);

        $logs = [];
        $channels = ['laravel', 'activity'];

        if ($channel === 'all') {
            // Get logs from existing files
            $logFiles = [
                'laravel' => storage_path('logs/laravel.log'),
                'activity' => storage_path('logs/activity-2025-10-04.log')
            ];

            foreach ($logFiles as $logChannel => $logPath) {
                if (File::exists($logPath)) {
                    $lines = File::lines($logPath)->take($limit / 2)->toArray();
                    foreach ($lines as $line) {
                        $logEntry = json_decode($line, true);
                        if ($logEntry) {
                            $logEntry['channel'] = $logChannel;
                            $logs[] = $logEntry;
                        } else {
                            // Handle non-JSON logs (like Laravel logs)
                            $logs[] = [
                                'message' => $line,
                                'channel' => $logChannel,
                                'timestamp' => now()->toDateTimeString(),
                                'level' => 'info'
                            ];
                        }
                    }
                }
            }
            $logs = array_reverse($logs);
        } else {
            $logPath = storage_path("logs/{$channel}.log");
            if (File::exists($logPath)) {
                $lines = File::lines($logPath)->take($limit)->toArray();
                foreach ($lines as $line) {
                    $logEntry = json_decode($line, true);
                    if ($logEntry) {
                        $logEntry['channel'] = $channel;
                        $logs[] = $logEntry;
                    } else {
                        // Handle non-JSON logs
                        $logs[] = [
                            'message' => $line,
                            'channel' => $channel,
                            'timestamp' => now()->toDateTimeString(),
                            'level' => 'info'
                        ];
                    }
                }
                $logs = array_reverse($logs);
            }
        }

        // Filter by level if specified
        if ($level !== 'all') {
            $logs = array_filter($logs, function($log) use ($level) {
                return isset($log['level']) && $log['level'] === $level;
            });
        }

        return view('admin.logs.index', compact('logs', 'channels', 'channel', 'level', 'limit'));
    }

    /**
     * Get logs as JSON for AJAX requests
     */
    public function getLogs(Request $request)
    {
        $channel = $request->get('channel', 'all');
        $level = $request->get('level', 'all');
        $limit = $request->get('limit', 100);

        $logs = [];
        $channels = ['laravel', 'activity'];

        if ($channel === 'all') {
            // Get logs from existing files
            $logFiles = [
                'laravel' => storage_path('logs/laravel.log'),
                'activity' => storage_path('logs/activity-2025-10-04.log')
            ];

            foreach ($logFiles as $logChannel => $logPath) {
                if (File::exists($logPath)) {
                    $lines = File::lines($logPath)->take($limit / 2)->toArray();
                    foreach ($lines as $line) {
                        $logEntry = json_decode($line, true);
                        if ($logEntry) {
                            $logEntry['channel'] = $logChannel;
                            $logs[] = $logEntry;
                        } else {
                            // Handle non-JSON logs (like Laravel logs)
                            $logs[] = [
                                'message' => $line,
                                'channel' => $logChannel,
                                'timestamp' => now()->toDateTimeString(),
                                'level' => 'info'
                            ];
                        }
                    }
                }
            }
            $logs = array_reverse($logs);
        } else {
            $logPath = storage_path("logs/{$channel}.log");
            if (File::exists($logPath)) {
                $lines = File::lines($logPath)->take($limit)->toArray();
                foreach ($lines as $line) {
                    $logEntry = json_decode($line, true);
                    if ($logEntry) {
                        $logEntry['channel'] = $channel;
                        $logs[] = $logEntry;
                    } else {
                        // Handle non-JSON logs
                        $logs[] = [
                            'message' => $line,
                            'channel' => $channel,
                            'timestamp' => now()->toDateTimeString(),
                            'level' => 'info'
                        ];
                    }
                }
                $logs = array_reverse($logs);
            }
        }

        // Filter by level if specified
        if ($level !== 'all') {
            $logs = array_filter($logs, function($log) use ($level) {
                return isset($log['level']) && $log['level'] === $level;
            });
        }

        return response()->json([
            'success' => true,
            'logs' => $logs,
            'total' => count($logs)
        ]);
    }

    /**
     * Clear logs
     */
    public function clearLogs(Request $request)
    {
        $channel = $request->get('channel', 'all');

        if ($channel === 'all') {
            $channels = ['laravel', 'activity'];
            foreach ($channels as $ch) {
                $logPath = storage_path("logs/{$ch}.log");
                if (File::exists($logPath)) {
                    File::put($logPath, '');
                }
            }
        } else {
            $logPath = storage_path("logs/{$channel}.log");
            if (File::exists($logPath)) {
                File::put($logPath, '');
            }
        }

        ActivityLogService::logActivity('logs_cleared', [
            'channel' => $channel,
            'cleared_by' => auth()->user()->name ?? 'System'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'لاگ‌ها با موفقیت پاک شدند'
        ]);
    }

    /**
     * Download logs
     */
    public function downloadLogs(Request $request)
    {
        $channel = $request->get('channel', 'all');
        $filename = $channel === 'all' ? 'all_logs_' . date('Y-m-d_H-i-s') . '.txt' : "{$channel}_logs_" . date('Y-m-d_H-i-s') . '.txt';

        $content = '';

        if ($channel === 'all') {
            $channels = ['laravel', 'activity'];
            foreach ($channels as $ch) {
                $logPath = storage_path("logs/{$ch}.log");
                if (File::exists($logPath)) {
                    $content .= "=== {$ch} LOGS ===\n";
                    $content .= File::get($logPath);
                    $content .= "\n\n";
                }
            }
        } else {
            $logPath = storage_path("logs/{$channel}.log");
            if (File::exists($logPath)) {
                $content = File::get($logPath);
            }
        }

        ActivityLogService::logActivity('logs_downloaded', [
            'channel' => $channel,
            'downloaded_by' => auth()->user()->name ?? 'System'
        ]);

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
