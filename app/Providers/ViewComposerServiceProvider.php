<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('partials.header', function ($view) {
            $view->with('productCategories', Category::produk()->orderBy('name')->get());
        });
    }
}