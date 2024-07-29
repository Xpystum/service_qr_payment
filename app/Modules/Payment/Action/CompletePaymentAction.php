<?php

namespace App\Modules\Payment\Action;

use App\Modules\Payment\Enums\PaymentStatusEnum;
use App\Modules\Payment\Events\DTO\PaymentCompletedData;
use App\Modules\Payment\Events\PaymentCompletedEvent;
use App\Modules\Payment\Models\Payment;

class CompletePaymentAction{


    public function run(Payment $payment): bool
    {

        $update = $payment->update(['status' => PaymentStatusEnum::completed]);

        #TODO Сделать ивенты уже в новом проекте
        //$update -> если обновился то бросаем событие
        $update && event(new PaymentCompletedEvent(
            PaymentCompletedData::fromPayment($payment),
        ));

        return $update;
    }


}



