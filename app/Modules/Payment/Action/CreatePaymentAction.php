<?php

namespace App\Modules\Payment\Action;

use App\Modules\Payment\Enums\PaymentStatusEnum;
use App\Modules\Payment\Interface\Payable;
use App\Modules\Payment\Models\Payment;
use Illuminate\Support\Str;


class CreatePaymentAction
{
    //заказ (Услуга, подписка и т.д)
    private readonly Payable $payable;

    public function payable(Payable $payable): static
    {

        $this->payable = $payable;

        return $this;

    }
    public function run() : Payment
    {
        $payment = Payment::query()
            ->create([
                'uuid' => (string) Str::uuid() ,

                'status' => PaymentStatusEnum::pending,

                'driver_currency_id' => $this->payable->getPayableCurrencyId(),

                'amount' => $this->payable->getPayableAmount(),

                'payable_type' => $this->payable->getPayableType(),

                'payable_id' => $this->payable->getPayableId() ,

                'method_id' => null ,

                'drive' => null ,
        ]);

        return $payment;
    }

}



