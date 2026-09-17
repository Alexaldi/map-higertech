<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

use App\Services\Admin\ClientPartnerService;
use App\Services\Admin\SiteSettingService;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (file_exists(app_path('Helpers/setting.php'))) {
            require_once app_path('Helpers/setting.php');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('station-api', fn (Request $request): Limit => Limit::perMinute(60)->by($request->ip()));

        // Provide active client partners to clients section
        View::composer('landing.partials.clients', function ($view): void {
            $view->with('clients', app(ClientPartnerService::class)->getActive());
        });

        // Provide site settings globally to layouts and landing partials
        View::composer(['landing.*', 'layouts.*'], function ($view): void {
            $view->with('siteSettings', app(SiteSettingService::class)->all());
        });
    }
}
