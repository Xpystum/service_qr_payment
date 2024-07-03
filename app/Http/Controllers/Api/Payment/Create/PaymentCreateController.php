<?php

namespace App\Http\Controllers\Api\Payment\Create;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Action\CreatePaymentAction;
use App\Modules\Payment\Action\GetPaymentMethodsAction;
use App\Modules\Payment\Action\UpdatePaymentAction;
use App\Modules\Payment\Interface\Payable;
use App\Modules\Payment\Requests\PaymentMethodRequest;
use App\Modules\Transactions\Models\Transaction;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class PaymentCreateController extends Controller
{


    public function __invoke(
        PaymentMethodRequest $request,
        Payable $transaction,
        CreatePaymentAction $createPaymentAction,
        UpdatePaymentAction $updatePaymentAction,
        GetPaymentMethodsAction $GetPaymentMethodsAction,
    )
    {
        $validated = $request->validated();

        //создаём платежку и привязываем к (payble) (Транзакция, заказ и т.д)
        $payment = $createPaymentAction->payable($transaction)
            ->run();


        //получаем модель метода по заданному параметру в запросе
        $method = $GetPaymentMethodsAction
                    ->active(true)
                    ->id($validated['method_id'])
                    ->first();

        dd($method);

        // $updatePayment = $this->updatePaymentAction();


        dd($payment);


    }
}
