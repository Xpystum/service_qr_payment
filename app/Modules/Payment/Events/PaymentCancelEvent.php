<?php
namespace App\Modules\Payment\Events;

use App\Modules\Payment\Events\DTO\PaymentCancelData;

class PaymentCancelEvent
{

    public function __construct(

        public PaymentCancelData $data,


    ) { }

}
