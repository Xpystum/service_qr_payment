<?php

namespace App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO;

class CreatePaymentData
{

    public function __construct(

        public int $value,

        public string $currency,

        public bool $capture,

        public string $idempotenceKey, // orderUuid?

        public ?string $returnUrl = null,

        public string $description = '',

    ) { }

}
