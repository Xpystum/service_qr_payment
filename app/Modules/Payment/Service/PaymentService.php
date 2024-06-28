<?php

namespace App\Modules\Payment\Service;

use App\Modules\Payment\Action\CancelPaymentAction;
use App\Modules\Payment\Action\CompletePaymentAction;
use App\Modules\Payment\Action\CreatePaymentAction;
use App\Modules\Payment\Action\GetPaymentMethodsAction;
use App\Modules\Payment\Action\GetPaymentsAction;
use App\Modules\Payment\Action\UpdatePaymentAction;
use App\Modules\Payment\Action\WaitingPaymentAction;
use App\Modules\Payment\Drivers\Factory\PaymentDriverFactory;
use App\Modules\Payment\Enums\PaymentDriverEnum;
use App\Modules\Payment\Interface\PaymentDriverInterface;

class PaymentService
{
    public function getDriver(PaymentDriverEnum $driver): PaymentDriverInterface
    {
        return app(PaymentDriverFactory::class)->make($driver);
    }

    public function createPayment() : CreatePaymentAction
    {
        return app(CreatePaymentAction::class);
    }

    public function getPayments() : GetPaymentsAction
    {
        return app(GetPaymentsAction::class);
    }

    public function getPaymentMethods() : GetPaymentMethodsAction
    {
        return app(GetPaymentMethodsAction::class);
    }

    public function updatePayment() : UpdatePaymentAction
    {
        return app(UpdatePaymentAction::class);
    }

    public function completePayment() : CompletePaymentAction
    {
        return app(CompletePaymentAction::class);
    }

    public function waitingPayment() : WaitingPaymentAction
    {
        return app(WaitingPaymentAction::class);
    }

    public function cancelPayment() : CancelPaymentAction
    {
        return app(CancelPaymentAction::class);
    }







}
