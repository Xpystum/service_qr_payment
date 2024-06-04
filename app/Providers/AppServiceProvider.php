<?php

namespace App\Providers;

use App\Modules\Notifications\Events\EmailCreatedEvent;
use App\Modules\Notifications\Listeners\UpdateStatusEmailNotificationListener;
use App\Modules\User\Events\PasswordCreatedEvent;
use App\Modules\User\Events\UserCreatedEvent;
use App\Modules\User\Listeners\PasswordChangeListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        $this->setPasswordDefault();

        Event::listen(
            PasswordCreatedEvent::class,
            PasswordChangeListener::class,
        );


    }

    private function setPasswordDefault(): void
    {
        Password::defaults(function () {

            return Password::min(6)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();

                // утекшие пароли
                // ->uncompromised();

        });
    }
}
