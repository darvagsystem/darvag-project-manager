<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanupTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-temp-files {--days=7}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up temporary files and optimize storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Cleaning up temporary files older than {$days} days...");

        $cleanedCount = 0;

        // Clean up temporary uploads
        $cleanedCount += $this->cleanupTempUploads($cutoffDate);

        // Clean up old cache files
        $cleanedCount += $this->cleanupCacheFiles($cutoffDate);

        // Clean up old session files
        $cleanedCount += $this->cleanupSessionFiles($cutoffDate);

        // Clean up old log files
        $cleanedCount += $this->cleanupLogFiles($cutoffDate);

        $this->info("Cleanup completed. Removed {$cleanedCount} files/directories.");

        return Command::SUCCESS;
    }

    /**
     * Clean up temporary uploads
     */
    private function cleanupTempUploads(Carbon $cutoffDate): int
    {
        $tempPath = storage_path('app/temp');
        $cleanedCount = 0;

        if (File::exists($tempPath)) {
            $files = File::allFiles($tempPath);

            foreach ($files as $file) {
                if (Carbon::createFromTimestamp($file->getMTime())->lt($cutoffDate)) {
                    File::delete($file->getPathname());
                    $cleanedCount++;
                }
            }
        }

        $this->line("Cleaned up {$cleanedCount} temporary upload files");
        return $cleanedCount;
    }

    /**
     * Clean up cache files
     */
    private function cleanupCacheFiles(Carbon $cutoffDate): int
    {
        $cachePath = storage_path('framework/cache');
        $cleanedCount = 0;

        if (File::exists($cachePath)) {
            $files = File::allFiles($cachePath);

            foreach ($files as $file) {
                if (Carbon::createFromTimestamp($file->getMTime())->lt($cutoffDate)) {
                    File::delete($file->getPathname());
                    $cleanedCount++;
                }
            }
        }

        $this->line("Cleaned up {$cleanedCount} cache files");
        return $cleanedCount;
    }

    /**
     * Clean up session files
     */
    private function cleanupSessionFiles(Carbon $cutoffDate): int
    {
        $sessionPath = storage_path('framework/sessions');
        $cleanedCount = 0;

        if (File::exists($sessionPath)) {
            $files = File::allFiles($sessionPath);

            foreach ($files as $file) {
                if (Carbon::createFromTimestamp($file->getMTime())->lt($cutoffDate)) {
                    File::delete($file->getPathname());
                    $cleanedCount++;
                }
            }
        }

        $this->line("Cleaned up {$cleanedCount} session files");
        return $cleanedCount;
    }

    /**
     * Clean up log files
     */
    private function cleanupLogFiles(Carbon $cutoffDate): int
    {
        $logPath = storage_path('logs');
        $cleanedCount = 0;

        if (File::exists($logPath)) {
            $files = File::allFiles($logPath);

            foreach ($files as $file) {
                // Skip current log file
                if ($file->getFilename() === 'laravel.log') {
                    continue;
                }

                if (Carbon::createFromTimestamp($file->getMTime())->lt($cutoffDate)) {
                    File::delete($file->getPathname());
                    $cleanedCount++;
                }
            }
        }

        $this->line("Cleaned up {$cleanedCount} old log files");
        return $cleanedCount;
    }
}
