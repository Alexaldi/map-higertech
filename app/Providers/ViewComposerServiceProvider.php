<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('partials.header', function ($view) {
            try {
                $hasCategories = Schema::hasTable('categories');
                $view->with('productCategories', $hasCategories ? Category::produk()->orderBy('name')->get() : collect());
                $view->with('articleCategories', $hasCategories ? Category::artikel()->orderBy('name')->get() : collect());
            } catch (\Throwable) {
                $view->with('productCategories', collect());
                $view->with('articleCategories', collect());
            }
        });
    }
}
