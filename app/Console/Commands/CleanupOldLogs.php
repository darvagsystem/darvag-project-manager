<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CleanupOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-old-logs {--days=30}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old log files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);
        $logPath = storage_path('logs');

        $this->info("Cleaning up log files older than {$days} days...");

        $deletedCount = 0;

        if (File::exists($logPath)) {
            $files = File::files($logPath);

            foreach ($files as $file) {
                if (Carbon::createFromTimestamp($file->getMTime())->lt($cutoffDate)) {
                    File::delete($file->getPathname());
                    $deletedCount++;
                    $this->line("Deleted: {$file->getFilename()}");
                }
            }
        }

        $this->info("Cleanup completed. Deleted {$deletedCount} log files.");

        return Command::SUCCESS;
    }
}
