<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ❗ Build / config:cache / migrate chưa có DB thì bỏ qua
        if (!Schema::hasTable('categories')) {
            return;
        }

        try {
            View::share(
                'globalCategories',
                Category::orderBy('name')->get()
            );
        } catch (\Throwable $e) {
            // ignore để không chết build
        }
    }
}
