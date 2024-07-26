<?php

namespace App\Modules\Payment\Drivers\Ykassa\App\Events;

use App\Modules\Payment\Drivers\Ykassa\App\Events\DTO\PaymentCancelData;

class PaymentCancelEvent
{
    public function __construct(

        public PaymentCancelData $data,

    ) {}
}
