<?php

namespace App\Modules\Payment\Events;

use App\Modules\Payment\Events\DTO\PaymentWaitingData;

class PaymentWaitingEvent
{

    public function __construct(

        public PaymentWaitingData $data,

    ) {}

}
