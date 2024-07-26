<?php

namespace App\Providers;

use App\Modules\Currencies\Commands\InstallCurrenciesCommand;
use App\Modules\User\Events\PasswordCreatedEvent;
use App\Modules\User\Listeners\PasswordChangeListener;
use App\Modules\User\Models\User;
use App\Modules\User\Policies\UserPolicy;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

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


        //Регистрация политик
        Gate::policy(User::class, UserPolicy::class);

        $this->commands([
            InstallCurrenciesCommand::class,
        ]);

        if (!app()->environment('production')) {
            DB::listen(function ($query) {
                Log::info('-----------------Начало Запрос--------------------');
                Log::info('SQL: ' . $query->sql);
                Log::info('Bindings: ' . json_encode($query->bindings));
                Log::info('Time: ' . $query->time . ' ms');
                Log::info('Connection Name: ' . $query->connectionName);
                Log::info('Выполнено в: ' . now());
                Log::info('-----------------Конец Запрос--------------------');
            });
        }

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
