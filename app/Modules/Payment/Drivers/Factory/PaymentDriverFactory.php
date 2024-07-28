<?php

namespace App\Modules\Payment\Drivers\Factory;

use App\Modules\Payment\Drivers\TestPaymentDriver;
use App\Modules\Payment\Drivers\YkassaDriver;
use App\Modules\Payment\Enums\PaymentDriverEnum;
use App\Modules\Payment\Interface\PaymentDriverInterface;

class PaymentDriverFactory
{
    public function make(PaymentDriverEnum $driver): PaymentDriverInterface
    {
        return match ($driver) {

            PaymentDriverEnum::test => app(TestPaymentDriver::class),

            PaymentDriverEnum::ykassa => app(YkassaDriver::class),

            default => throw new \InvalidArgumentException(

                "Драйвер [{$driver->value}] не поддерживается"

            )

        };
    }

}





