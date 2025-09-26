<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Client;
use App\Jobs\GenerateProjectReport;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GenerateWeeklyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-weekly-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate weekly reports for projects, employees, and overall statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating weekly reports...');

        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        // Generate project reports
        $this->generateProjectReports();

        // Generate employee reports
        $this->generateEmployeeReports();

        // Generate overall statistics
        $this->generateOverallStatistics($weekStart, $weekEnd);

        $this->info('Weekly reports generated successfully!');

        return Command::SUCCESS;
    }

    /**
     * Generate project reports
     */
    private function generateProjectReports()
    {
        $projects = Project::with('client')->get();

        foreach ($projects as $project) {
            // Dispatch job to generate individual project report
            GenerateProjectReport::dispatch($project->id, 'weekly');
        }

        $this->line("Generated reports for {$projects->count()} projects");
    }

    /**
     * Generate employee reports
     */
    private function generateEmployeeReports()
    {
        $employees = Employee::all();
        $reportData = [
            'total_employees' => $employees->count(),
            'active_employees' => $employees->where('status', 'active')->count(),
            'inactive_employees' => $employees->where('status', 'inactive')->count(),
            'employees_by_education' => $employees->groupBy('education')->map->count(),
            'employees_by_marital_status' => $employees->groupBy('marital_status')->map->count(),
            'recent_employees' => $employees->where('created_at', '>=', Carbon::now()->subDays(7))->count()
        ];

        $filename = 'employee_weekly_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.json';
        Storage::put("reports/{$filename}", json_encode($reportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->line("Generated employee report: {$filename}");
    }

    /**
     * Generate overall statistics
     */
    private function generateOverallStatistics($weekStart, $weekEnd)
    {
        $stats = [
            'period' => [
                'start' => $weekStart->format('Y-m-d'),
                'end' => $weekEnd->format('Y-m-d')
            ],
            'projects' => [
                'total' => Project::count(),
                'active' => Project::where('status', 'in_progress')->count(),
                'completed' => Project::where('status', 'completed')->count(),
                'planning' => Project::where('status', 'planning')->count(),
                'paused' => Project::where('status', 'paused')->count(),
                'new_this_week' => Project::whereBetween('created_at', [$weekStart, $weekEnd])->count(),
                'completed_this_week' => Project::where('status', 'completed')
                    ->whereBetween('updated_at', [$weekStart, $weekEnd])->count()
            ],
            'employees' => [
                'total' => Employee::count(),
                'active' => Employee::where('status', 'active')->count(),
                'new_this_week' => Employee::whereBetween('created_at', [$weekStart, $weekEnd])->count()
            ],
            'clients' => [
                'total' => Client::count(),
                'active' => Client::where('status', 'active')->count(),
                'new_this_week' => Client::whereBetween('created_at', [$weekStart, $weekEnd])->count()
            ],
            'financial_summary' => [
                'total_projects_value' => Project::sum('final_amount'),
                'average_project_value' => Project::avg('final_amount'),
                'total_initial_estimates' => Project::sum('initial_estimate'),
                'total_difference' => Project::sum('final_amount') - Project::sum('initial_estimate')
            ]
        ];

        $filename = 'weekly_overall_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.json';
        Storage::put("reports/{$filename}", json_encode($stats, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->line("Generated overall statistics report: {$filename}");
    }
}
