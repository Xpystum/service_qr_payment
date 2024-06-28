<?php

namespace App\Modules\Payment\Events;

use App\Modules\Payment\Events\DTO\PaymentCompletedData;

class PaymentCompletedEvent
{

    public function __construct(

        public PaymentCompletedData $data,

    ) {}

}
