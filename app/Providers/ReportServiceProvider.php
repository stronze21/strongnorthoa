<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Excel;

class ReportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register report generators
        $this->app->bind('report.generator', function ($app) {
            return new \App\Services\ReportGenerator();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Add report configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/reports.php', 'reports'
        );

        // Publish report configuration
        $this->publishes([
            __DIR__ . '/../config/reports.php' => config_path('reports.php'),
        ], 'report-config');

        // Publish report views
        $this->publishes([
            __DIR__ . '/../resources/views/reports' => resource_path('views/reports'),
        ], 'report-views');

        // Load report views
        $this->loadViewsFrom(__DIR__ . '/../resources/views/reports', 'reports');
    }
}