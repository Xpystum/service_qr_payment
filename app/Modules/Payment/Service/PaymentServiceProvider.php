<?php
namespace App\Modules\Payment\Service;

use App\Modules\Payment\Commands\AddYkassaComand;
use App\Modules\Payment\Commands\InstallPaymentsCommand;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

        if($this->app->runningInConsole()){

            $this->commands([
                InstallPaymentsCommand::class,
                AddYkassaComand::class,
            ]);

        }
    }
}
