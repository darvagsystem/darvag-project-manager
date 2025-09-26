<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateProjectReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300;
    public $tries = 2;

    protected $projectId;
    protected $reportType;

    /**
     * Create a new job instance.
     */
    public function __construct(int $projectId, string $reportType = 'summary')
    {
        $this->projectId = $projectId;
        $this->reportType = $reportType;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $project = Project::with('client')->find($this->projectId);

            if (!$project) {
                Log::error("Project not found for report generation", ['project_id' => $this->projectId]);
                return;
            }

            Log::info("Generating {$this->reportType} report for project: {$project->name}");

            $reportData = $this->generateReportData($project);
            $reportPath = $this->saveReport($reportData, $project);

            Log::info("Report generated successfully", [
                'project_id' => $project->id,
                'project_name' => $project->name,
                'report_type' => $this->reportType,
                'report_path' => $reportPath
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to generate project report", [
                'project_id' => $this->projectId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Generate report data
     */
    private function generateReportData(Project $project): array
    {
        return [
            'project_info' => [
                'id' => $project->id,
                'name' => $project->name,
                'contract_number' => $project->contract_number,
                'status' => $project->formatted_status,
                'priority' => $project->formatted_priority,
                'progress' => $project->progress . '%',
                'client' => $project->client->name ?? 'نامشخص',
                'project_manager' => $project->project_manager,
                'location' => $project->location,
                'category' => $project->formatted_category,
                'currency' => $project->currency,
                'initial_estimate' => number_format($project->initial_estimate, 0) . ' ' . $project->currency,
                'final_amount' => number_format($project->final_amount, 0) . ' ' . $project->currency,
                'contract_coefficient' => $project->contract_coefficient,
                'contract_start_date' => $project->contract_start_date,
                'contract_end_date' => $project->contract_end_date,
                'actual_start_date' => $project->actual_start_date,
                'actual_end_date' => $project->actual_end_date,
                'description' => $project->description,
                'notes' => $project->notes,
                'created_at' => $project->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $project->updated_at->format('Y-m-d H:i:s')
            ],
            'financial_summary' => [
                'total_budget' => $project->final_amount,
                'initial_estimate' => $project->initial_estimate,
                'difference' => $project->final_amount - $project->initial_estimate,
                'coefficient' => $project->contract_coefficient
            ],
            'timeline' => [
                'contract_start' => $project->contract_start_date,
                'contract_end' => $project->contract_end_date,
                'actual_start' => $project->actual_start_date,
                'actual_end' => $project->actual_end_date
            ]
        ];
    }

    /**
     * Save the report to storage
     */
    private function saveReport(array $reportData, Project $project): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "project_report_{$project->id}_{$this->reportType}_{$timestamp}.json";
        $path = "reports/{$filename}";

        Storage::put($path, json_encode($reportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $path;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Project report generation job failed", [
            'project_id' => $this->projectId,
            'report_type' => $this->reportType,
            'error' => $exception->getMessage()
        ]);
    }
}
