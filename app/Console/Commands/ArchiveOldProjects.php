<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ArchiveOldProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:archive-old-projects {--days=365}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive old completed projects';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Archiving projects completed more than {$days} days ago...");

        // Get old completed projects
        $oldProjects = Project::where('status', 'completed')
            ->where('updated_at', '<', $cutoffDate)
            ->get();

        $archivedCount = 0;

        foreach ($oldProjects as $project) {
            $this->archiveProject($project);
            $archivedCount++;

            $this->line("Archived project: {$project->name} (ID: {$project->id})");
        }

        $this->info("Archived {$archivedCount} old projects.");

        return Command::SUCCESS;
    }

    /**
     * Archive a single project
     */
    private function archiveProject(Project $project): void
    {
        // Create archive data
        $archiveData = [
            'project_info' => [
                'id' => $project->id,
                'name' => $project->name,
                'contract_number' => $project->contract_number,
                'status' => $project->status,
                'priority' => $project->priority,
                'progress' => $project->progress,
                'client_id' => $project->client_id,
                'project_manager' => $project->project_manager,
                'location' => $project->location,
                'category' => $project->category,
                'currency' => $project->currency,
                'initial_estimate' => $project->initial_estimate,
                'final_amount' => $project->final_amount,
                'contract_coefficient' => $project->contract_coefficient,
                'contract_start_date' => $project->contract_start_date,
                'contract_end_date' => $project->contract_end_date,
                'actual_start_date' => $project->actual_start_date,
                'actual_end_date' => $project->actual_end_date,
                'description' => $project->description,
                'notes' => $project->notes,
                'created_at' => $project->created_at->toISOString(),
                'updated_at' => $project->updated_at->toISOString(),
                'archived_at' => now()->toISOString()
            ],
            'client_info' => $project->client ? [
                'id' => $project->client->id,
                'name' => $project->client->name,
                'status' => $project->client->status
            ] : null,
            'financial_summary' => [
                'total_budget' => $project->final_amount,
                'initial_estimate' => $project->initial_estimate,
                'difference' => $project->final_amount - $project->initial_estimate,
                'coefficient' => $project->contract_coefficient
            ]
        ];

        // Save archive file
        $archivePath = "archives/projects/project_{$project->id}_" . now()->format('Y-m-d_H-i-s') . '.json';
        Storage::put($archivePath, json_encode($archiveData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Update project status to archived
        $project->update([
            'status' => 'archived',
            'notes' => ($project->notes ? $project->notes . "\n" : '') . "Archived on " . now()->format('Y-m-d H:i:s')
        ]);
    }
}
