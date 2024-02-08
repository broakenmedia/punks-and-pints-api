<?php

namespace App\Providers;

use App\Http\Integrations\Punk\PunkConnector;
use App\Http\Responses\ApiErrorResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
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
        Response::macro('rateLimitError', function (string $timeRemaining) {
            return new ApiErrorResponse(['message' => __("Too many requests to Punks's API. Please try again in :TIME.", ['time' => $timeRemaining])], HttpResponse::HTTP_TOO_MANY_REQUESTS);
        });
    }
}
