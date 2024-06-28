<?php

namespace App\Modules\Payment\Action;

use App\Modules\Payment\Enums\PaymentStatusEnum;
use App\Modules\Payment\Events\DTO\PaymentCancelData;
use App\Modules\Payment\Events\PaymentCancelEvent;
use App\Modules\Payment\Models\Payment;

class CancelPaymentAction{


    public function run(Payment $payment): bool
    {
        $update = $payment->update(['status' => PaymentStatusEnum::cancelled]);

        #TODO Сделать ивенты уже в новом проекте
        $update && event(new PaymentCancelEvent(
            PaymentCancelData::fromPayment($payment),
        ));

        return $update;
    }


}



