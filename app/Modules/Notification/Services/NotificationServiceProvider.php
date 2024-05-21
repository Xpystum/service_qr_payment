<?php

namespace App\Modules\Notification\Services;

use App\Modules\Notification\Console\Commands\MakeNotificationMethodCommand;
use App\Modules\Notification\Drivers\AeroDriver;
use App\Modules\Notification\Drivers\SmtpDriver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;


class NotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //создаём только 1 экземпляр класса
        $this->app->singleton(NotificationService::class, function() {

            return new NotificationService();

        });

        $this->app->singleton(AeroDriver::class, function() {

            return new AeroDriver();

        });

        $this->app->singleton(SmtpDriver::class, function() {

            return new SmtpDriver();

        });
    }

    public function boot(): void
    {

        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/Database' . '/Migrations');

            $this->commands([
                MakeNotificationMethodCommand::class,
            ]);

        }
    }
}
