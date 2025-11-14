<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        // Fix for older MySQL / MariaDB default key length issues
        // ensures string columns default to 191 chars so unique indexes don't exceed key size
        Schema::defaultStringLength(191);

        Vite::prefetch(concurrency: 3);
    }
}
