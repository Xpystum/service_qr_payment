<?php

namespace Tests\Feature\Traits;

use Illuminate\Support\Facades\Artisan;

trait InstallCurrensiesTrait
{
    protected function installCurrensies() : bool
    {
        $exitCode = Artisan::call('currencies:install');

        $this->assertTrue(
            $exitCode == 0 ? true : false,
            "Ошибка при установке валют комманда: {currencies:install}"
        );


        return $exitCode == 0 ? true : false;
    }

}
