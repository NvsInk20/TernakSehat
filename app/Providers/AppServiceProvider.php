<?php

namespace App\Providers;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        // Daftarkan alias middleware 'role'
    Route::aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
    }
}
