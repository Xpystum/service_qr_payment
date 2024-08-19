<?php

namespace Tests\Feature\Traits;

use Illuminate\Support\Facades\Artisan;

trait InstallPaymentMethodsTrait
{
    protected function installPaymentMethod() : bool
    {
        $exitCode = Artisan::call('payments:install');

        $this->assertTrue(
            $exitCode == 0 ? true : false,
            "Ошибка при установке валют комманда: {payments:install}"
        );


        return $exitCode == 0 ? true : false;
    }
}
