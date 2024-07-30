<?php
namespace App\Modules\Payment\Events;

use App\Modules\Payment\Events\DTO\PaymentStatusData;

/**
 * [Description BasePaymentStatusEvent]
 */
class BasePaymentStatusEvent
{
    /**
     * @var PaymentStatusData $data Данные статуса платежа.
     */
    public function __construct(

        public PaymentStatusData $data,

    ) {}
}
