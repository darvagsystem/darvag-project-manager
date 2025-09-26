<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use Carbon\Carbon;

class UpdateProjectStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-project-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update project statuses based on dates and progress';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating project statuses...');

        $updatedCount = 0;

        // Get all active projects
        $projects = Project::whereIn('status', ['planning', 'in_progress'])->get();

        foreach ($projects as $project) {
            $shouldUpdate = false;
            $newStatus = $project->status;

            // Check if project should be marked as completed based on progress
            if ($project->progress >= 100 && $project->status !== 'completed') {
                $newStatus = 'completed';
                $shouldUpdate = true;
                $this->line("Project '{$project->name}' marked as completed (progress: {$project->progress}%)");
            }

            // Check if project should be paused due to inactivity
            if ($project->status === 'in_progress' && $project->progress < 50) {
                $lastUpdated = $project->updated_at;
                if ($lastUpdated && $lastUpdated->diffInDays(now()) > 30) {
                    $newStatus = 'paused';
                    $shouldUpdate = true;
                    $this->line("Project '{$project->name}' paused due to inactivity");
                }
            }

            if ($shouldUpdate) {
                $project->update(['status' => $newStatus]);
                $updatedCount++;
            }
        }

        $this->info("Updated {$updatedCount} project statuses.");

        return Command::SUCCESS;
    }
}
