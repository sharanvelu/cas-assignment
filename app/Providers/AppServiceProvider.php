<?php

namespace App\Providers;

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
        // Force assets to load in HTTPS
        if (request()->header('x-forwarded-proto') == 'https' || $this->app->isProduction()) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
