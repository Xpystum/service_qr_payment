<?php

namespace App\Modules\Payment\Events\DTO;
readonly class PaymentStatusData
{
    public function __construct(

        public string  $uuid,

        public string  $payableType, //order, tinkoff, ykassa

        public string  $payableId, //order, tinkoff, ykassa

    ) { }

    use TraitPaymentData;
}
