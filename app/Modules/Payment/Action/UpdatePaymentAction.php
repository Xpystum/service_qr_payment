<?php

namespace App\Modules\Payment\Action;

use App\Helpers\Values\AmountValue;
use App\Modules\Payment\Interface\PaymentConverter;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Models\PaymentMethod;

class UpdatePaymentAction{

    public function __construct(

        private PaymentConverter $converter

    ) { }

   private PaymentMethod|null $method;

    public function method(PaymentMethod $method): static
    {
        $this->method = $method;

        return $this;

    }

    public function run(Payment $payment) : bool
    {
        if(!is_null($this->method))
        {

            $payment->method_id = $this->method->id;
            $payment->driver = $this->method->driver;
            $payment->driver_currency_id = $this->method->driver_currency_id;
            $payment->driver_amount = $this->convertAmount($payment);

        }


        return $payment->save();
    }

    private function convertAmount(Payment $payment): AmountValue
    {

        //конвертр валюты в зависимости от выбора валюты провайдера
        return $this->converter
                    ->convert(

                        amount: $payment->amount,

                        from: $payment->currency_id,

                        to: $payment->driver_currency_id

                    );

    }
}



