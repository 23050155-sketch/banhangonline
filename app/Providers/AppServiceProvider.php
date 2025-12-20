<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 🚫 ĐANG CHẠY CONSOLE (build, config:cache, migrate) → BỎ QUA
        if ($this->app->runningInConsole()) {
            return;
        }

        // 🌐 Chỉ chạy khi request web thật sự
        View::share(
            'globalCategories',
            Category::orderBy('name')->get()
        );
    }
}
