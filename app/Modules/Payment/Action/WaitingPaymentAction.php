<?php

namespace App\Modules\Payment\Action;

use App\Modules\Payment\Enums\PaymentStatusEnum;
use App\Modules\Payment\Events\DTO\PaymentStatusData;
use App\Modules\Payment\Events\DTO\PaymentWaitingData;
use App\Modules\Payment\Events\PaymentWaitingEvent;
use App\Modules\Payment\Models\Payment;

class WaitingPaymentAction{


    public function run(Payment $payment): bool
    {

        $update = $payment->update(['status' => PaymentStatusEnum::waiting_for_capture]);

        #TODO Поменять в проекте
        // $update -> если обновился то бросаем событие
        $update && event(new PaymentWaitingEvent(
            PaymentStatusData::fromPayment($payment),
        ));
        return $update;
    }


}



