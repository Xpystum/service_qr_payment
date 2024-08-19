<?php

namespace Tests\Feature\Traits;

use App\Modules\Payment\Action\Handler\CreatePaymentHandler;
use App\Modules\Payment\DTO\CreatePaymentDTO;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Models\PaymentMethod;
use App\Modules\Transactions\Models\Transaction;

trait CreatePaymentTrait
{
    use CreateTransactionTrait, InstallPaymentMethodsTrait;
    protected function create_payment(Transaction $transaction = null) : Payment
    {
        {
            if(is_null($transaction)) { $transaction = $this->create_transaction(); }
            $this->installPaymentMethod();
            $paymentMethod = PaymentMethod::where('active', true)->first();
        }

        $handler = CreatePaymentHandler::make();

        $payment = $handler->handle(CreatePaymentDTO::make($transaction, $paymentMethod->id));

        return $payment;
    }
}
