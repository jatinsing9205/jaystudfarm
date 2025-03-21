<?php

namespace App\Providers;

use App\Http\Middleware\loginMiddleware;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Log;
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
        DB::listen(function ($query) {
            Log::info("Executed Query: " . $query->sql, [
                'Parameter'=>$query->bindings,
                'user'=>Session::get('user')? Session::get('user')->username : 'Guest',
            ]);
        });
    }
}
