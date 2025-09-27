<?php

namespace App\Providers;

use App\Http\Middleware\loginMiddleware;
use App\Http\Middleware\verifyAccess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
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
     * Bootstrap any application services.s
     */
    public function boot(): void
    {
        DB::listen(function ($query) {
            Log::info("Executed Query: " . $query->sql, [
                'Parameter'=>$query->bindings,
                'user'=>Session::get('user')? Session::get('user')->username : 'Guest',
            ]);
        });
    }
}
