<?php

namespace App\Providers;

use App\Services\ExportService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View; 
use Illuminate\Support\Facades\Route; 
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ExportService::class, function ($app) {
            return new ExportService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // --- Logic to Page Title ---
        View::composer('components.layouts.app', function ($view) {
            $routeName = Route::currentRouteName();
            $pageTitle = match ($routeName) {
                'dashboard' => __('messages.menu_dashboard'),
                'transactions.index' => __('messages.menu_history'),
                'budget.index' => __('messages.menu_budgets'),
                'report.index'=> __('messages.menu_report'),
                default => 'AturUangmu'
            };
            $view->with('pageTitle', $pageTitle);
        });
    }
}
