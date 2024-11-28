<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Route::middleware(config('jetstream.middleware', ['web']))
            ->group(base_path('routes/jetstream.php'));
        Route::middleware(config('fortify.middleware', ['web']))
            ->group(base_path('routes/fortify.php'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
