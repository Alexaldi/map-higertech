<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

use App\Models\Article;
use App\Services\Admin\ClientPartnerService;
use App\Services\Admin\SiteSettingService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Repositories\Admin\Contracts\ProductRepositoryInterface;
use App\Repositories\Admin\ProductRepository;

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
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('station-api', fn (Request $request): Limit => Limit::perMinute(60)->by($request->ip()));
        RateLimiter::for('login', fn (Request $request): Limit => Limit::perMinute(5)->by($request->input('email') . '|' . $request->ip())->response(function () {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak percobaan login. Silakan tunggu 1 menit lagi.',
            ], 429);
        }));
        RateLimiter::for('internship-apply', fn (Request $request): Limit => Limit::perMinute(10)->by($request->ip())->response(function () {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak permohonan dari perangkat ini. Harap tunggu beberapa saat.',
            ], 429);
        }));
        RateLimiter::for('internship-track', fn (Request $request): Limit => Limit::perMinute(30)->by($request->ip()));

        // Provide active client partners to clients section
        View::composer('landing.partials.clients', function ($view): void {
            try {
                $clients = Schema::hasTable('client_partners')
                    ? app(ClientPartnerService::class)->getActive()
                    : collect();
                $view->with('clients', $clients);
            } catch (\Throwable) {
                $view->with('clients', collect());
            }
        });

        // Provide home articles to articles section
        View::composer('landing.partials.articles', function ($view): void {
            try {
                $articles = Schema::hasTable('articles')
                    ? Article::published()->latest('published_at')->take(4)->get()
                    : collect();
                $view->with('homeArticles', $articles);
            } catch (\Throwable) {
                $view->with('homeArticles', collect());
            }
        });
    }
}
