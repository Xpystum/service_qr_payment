<?php

namespace App\Http\Controllers\Api\Payment\Create;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Requests\PaymentMethodRequest;
use App\Modules\Payment\Service\PaymentService;
use App\Modules\Transactions\Models\Transaction;


use function App\Helpers\array_error;
use function App\Helpers\array_success;

class PaymentCreateController extends Controller
{

    public function __invoke(
        PaymentMethodRequest $request,
        Transaction $transaction,
        PaymentService $paymentService
    )
    {
        $validated = $request->validated();

        //создаём платежку и привязываем к (payble) (Транзакция, заказ и т.д)
        $payment = $paymentService->createPayment()->payable($transaction)
            ->run();

        //получаем модель метода по заданному параметру в запросе
        $method = $paymentService->getPaymentMethods()
                    ->active(true)
                    ->id($validated['method_id'])
                    ->first();


        //обновляем данные оплаты (указываем методы оплаты QR -> Youkassa, Банк Точка)
        $updatePayment = $paymentService->updatePayment()
            ->method($method)
            ->run($payment);

        return $updatePayment?
        response()->json(array_success( $updatePayment, 'Successfully create payment for transactions'), 200)
        :
        response()->json(array_error(null, 'Failed create payment for transactions'), 404);

    }
}
