<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ViewCardToIbanLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'card-iban:logs {--lines=50 : Number of lines to show}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View Card to IBAN conversion logs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logPath = storage_path('logs/laravel.log');

        if (!file_exists($logPath)) {
            $this->error('Log file not found');
            return 1;
        }

        $lines = $this->option('lines');
        $this->info("Showing last {$lines} Card to IBAN related log entries:");
        $this->line('');

        // Read log file
        $logLines = [];
        $file = new \SplFileObject($logPath);
        $file->seek(PHP_INT_MAX);
        $totalLines = $file->key();

        $startLine = max(0, $totalLines - 1000); // Check last 1000 lines
        $file->seek($startLine);

        while (!$file->eof()) {
            $line = $file->current();
            if (strpos($line, 'Card to IBAN') !== false ||
                strpos($line, 'Digikala API') !== false ||
                strpos($line, 'card_number') !== false) {
                $logLines[] = trim($line);
            }
            $file->next();
        }

        $relevantLines = array_slice($logLines, -$lines);

        if (empty($relevantLines)) {
            $this->warn('No Card to IBAN related logs found');
            return 0;
        }

        foreach ($relevantLines as $line) {
            if (strpos($line, 'ERROR') !== false) {
                $this->error($line);
            } elseif (strpos($line, 'WARNING') !== false) {
                $this->warn($line);
            } else {
                $this->info($line);
            }
        }

        return 0;
    }
}
