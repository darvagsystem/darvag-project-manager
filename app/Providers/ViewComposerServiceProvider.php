<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CompanySetting;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share company settings with all admin views
        View::composer('admin.*', function ($view) {
            $companySettings = CompanySetting::getSettings();
            $view->with('companySettings', $companySettings);
        });

        // Also share with welcome page
        View::composer('welcome', function ($view) {
            $companySettings = CompanySetting::getSettings();
            $view->with('companySettings', $companySettings);
        });
    }
}
