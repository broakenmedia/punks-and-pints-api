<?php

namespace App\Providers;

use App\Http\Integrations\Punk\PunkConnector;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('punk_connector', function ($app) {
            return new PunkConnector();
        });
    }

    public function boot(): void
    {
        //
    }
}
