<?php

namespace App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\Entity;

use App\Modules\Payment\Drivers\Ykassa\Database\Enums\PaymentStatusEnum;

class PaymentEntity
{

    /**
     * Summary of __construct
     * @param string $id индефикатор платежа (у юкассы)
     * @param \App\Modules\Payment\Drivers\Ykassa\Database\Enums\PaymentStatusEnum $status состояние платежа
     * @param bool $paid был ли уже оплачен заказ
     * @param int $value
     * @param mixed $url если метод спб - то ссылка на спб
     * @param string $payable_uuid индефикатор uuid нашего payment
     */
    public function __construct(

        public string $id,

        public PaymentStatusEnum $status, //состояние платежа

        public bool $paid,

        public int $value,

        public ?string $url,

        public string $payable_uuid,


    ) { }
}
