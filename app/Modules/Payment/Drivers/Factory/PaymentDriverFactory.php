<?php

namespace App\Modules\Payment\Drivers\Factory;

use App\Modules\Payment\Drivers\TestPaymentDriver;
use App\Modules\Payment\Enums\PaymentDriverEnum;
use App\Modules\Payment\Interface\PaymentDriverInterface;
use App\Services\Payments\Drivers\YkassaDriver;

class PaymentDriverFactory
{
    public function make(PaymentDriverEnum $driver): PaymentDriverInterface
    {
        return match ($driver) {

            PaymentDriverEnum::test => app(TestPaymentDriver::class),

            PaymentDriverEnum::ykassa => app(YkassaDriver::class),

            default => throw new \InvalidArgumentException(

                "Драйвер [{$driver}] не поддерживается"

            )

        };
    }

}





