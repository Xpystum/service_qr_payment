<?php


namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\Drivers\AuthJwt;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton(AuthService::class, function(){

            $auth = new AuthJwt();

            return new AuthService(serviceAuth: $auth);

        });
    }

    public function boot(): void
    {

    }

}
