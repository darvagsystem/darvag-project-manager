<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\DateHelper;

class DateServiceProvider extends ServiceProvider
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
        // Register Blade directives for Persian dates
        Blade::directive('persianDate', function ($expression) {
            return "<?php echo App\Helpers\DateHelper::toPersianDate($expression); ?>";
        });

        Blade::directive('persianDateTime', function ($expression) {
            return "<?php echo App\Helpers\DateHelper::toPersianDateTime($expression); ?>";
        });

        Blade::directive('persianDateTimeFull', function ($expression) {
            return "<?php echo App\Helpers\DateHelper::toPersianDateTimeFull($expression); ?>";
        });
    }
}
