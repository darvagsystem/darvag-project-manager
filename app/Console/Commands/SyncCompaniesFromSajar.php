<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Services\SajarService;
use Illuminate\Console\Command;

class SyncCompaniesFromSajar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sajar:sync-companies {--company= : ID of specific company to sync} {--all : Sync all companies}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync company data from Sajar API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sajarService = new SajarService();

        if ($this->option('all')) {
            $this->info('Starting sync for all companies...');
            $results = $sajarService->syncAllCompanies();

            $this->info("Sync completed!");
            $this->info("Total companies: {$results['total']}");
            $this->info("Successfully synced: {$results['success']}");
            $this->info("Failed: {$results['failed']}");

            if (!empty($results['errors'])) {
                $this->error("Errors:");
                foreach ($results['errors'] as $error) {
                    $this->error("- $error");
                }
            }
        } elseif ($this->option('company')) {
            $companyId = $this->option('company');
            $company = Company::find($companyId);

            if (!$company) {
                $this->error("Company with ID {$companyId} not found.");
                return 1;
            }

            $this->info("Syncing company: {$company->name} (ID: {$company->id})");

            if ($sajarService->syncCompanyFromSajar($company)) {
                $this->info("Company synced successfully!");
            } else {
                $this->error("Failed to sync company.");
                return 1;
            }
        } else {
            $this->error('Please specify --all or --company=ID');
            return 1;
        }

        return 0;
    }
}
