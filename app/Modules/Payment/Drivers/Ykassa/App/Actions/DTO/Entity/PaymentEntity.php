<?php

namespace App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\Entity;

use App\Modules\Payment\Drivers\Ykassa\Database\Enums\PaymentStatusEnum;

class PaymentEntity
{

    public function __construct(

        public string $id,

        public PaymentStatusEnum $status,

        public bool $paid,

        public int $value,

        public ?string $url,

        public string $payable_uuid,


    ) { }
}
