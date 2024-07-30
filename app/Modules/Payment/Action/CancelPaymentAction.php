<?php

namespace App\Modules\Payment\Action;

use App\Modules\Payment\Enums\PaymentStatusEnum;
use App\Modules\Payment\Events\DTO\PaymentStatusData;
use App\Modules\Payment\Events\PaymentCancelEvent;
use App\Modules\Payment\Models\Payment;

class CancelPaymentAction{


    public function run(Payment $payment): bool
    {
        $update = $payment->update(['status' => PaymentStatusEnum::cancelled]);
        $update && event(new PaymentCancelEvent(
            PaymentStatusData::fromPayment($payment),
        ));

        return $update;
    }


}



