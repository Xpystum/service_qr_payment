<?php

namespace App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO;

class CreatePaymentSpbData
{

    public function __construct(

        public int $value,

        public string $currency,

        public string $idempotenceKey, // uuid - этот ключ нужен для того, что бы была идемпотентность платежа

        public string $description = '',

        public string $payable_name = '',

    ) { }

}
