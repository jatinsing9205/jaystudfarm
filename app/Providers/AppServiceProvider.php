<?php

namespace App\Providers;

use App\Http\Middleware\loginMiddleware;
use Illuminate\Support\ServiceProvider;
use Route;

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
     * Bootstrap any application services.s
     */
    public function boot(): void
    {
        Route::middlewareGroup('login', [
            loginMiddleware::class,
        ]);
    }
}
