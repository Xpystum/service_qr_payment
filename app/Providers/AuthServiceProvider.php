<?php


namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\Drivers\AuthJwt;
use Illuminate\Support\ServiceProvider;
use App\Services\Auth\AuthConfig;

class AuthServiceProvider extends ServiceProvider
{

    public function register(): void
    {

        $config = new AuthConfig(
            guard: "api",
            UrlExpiresConfig: "jwt.ttl",
        );

        $this->app->singleton(AuthService::class, function () use ($config) {

            $auth = new AuthJwt($config);

            return new AuthService(serviceAuth: $auth);

        });
    }

    public function boot(): void
    {

    }

}
