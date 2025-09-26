<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backup of the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating database backup...');

        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $backupPath = storage_path("backups/database_backup_{$timestamp}.sqlite");

        // Create backups directory if it doesn't exist
        if (!file_exists(storage_path('backups'))) {
            mkdir(storage_path('backups'), 0755, true);
        }

        // Copy the database file
        $sourcePath = database_path('database.sqlite');

        if (file_exists($sourcePath)) {
            copy($sourcePath, $backupPath);
            $this->info("Database backup created: {$backupPath}");

            // Clean up old backups (keep last 10)
            $this->cleanupOldBackups();

            return Command::SUCCESS;
        } else {
            $this->error('Database file not found!');
            return Command::FAILURE;
        }
    }

    /**
     * Clean up old backup files
     */
    private function cleanupOldBackups()
    {
        $backupDir = storage_path('backups');
        $files = glob($backupDir . '/database_backup_*.sqlite');

        if (count($files) > 10) {
            // Sort by modification time and remove oldest
            usort($files, function($a, $b) {
                return filemtime($a) - filemtime($b);
            });

            $filesToDelete = array_slice($files, 0, count($files) - 10);

            foreach ($filesToDelete as $file) {
                unlink($file);
                $this->line("Deleted old backup: " . basename($file));
            }
        }
    }
}
