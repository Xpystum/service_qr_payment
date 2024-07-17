<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Interface\Payable;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Repositories\PaymentRepository;
use App\Modules\Payment\Requests\PaymentMethodRequest;
use App\Modules\Payment\Resources\PaymentResource;
use App\Modules\Payment\Resources\PaymentTransactionResource;
use App\Modules\Payment\Service\PaymentService;
use App\Modules\Transactions\Models\Transaction;
use App\Modules\Transactions\Repositories\TransactionReposiotory;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class PaymentController extends Controller
{

    // public function index(Payable $payable, PaymentRepository $repository)
    // {
    //     // $payment = $repository->getPayment($payment);

    //     // dd($transaction->payment());

    //     return $transaction?
    //     response()->json(array_success( $transaction->payment, 'Successfully return payment'), 200)
    //     :
    //     response()->json(array_error(null, 'Failed return payment for uuid'), 404);
    // }


    public function show(Payment $payment)
    {
        return response()->json(array_success( PaymentResource::make($payment), 'Show payment by uuid'), 200);
    }

    // public function create(
    //     PaymentMethodRequest $request,
    //     TransactionReposiotory $transactionReposiotory,
    //     PaymentService $paymentService
    // ) {

    //     $validated = $request->validated();

    //     {
    //         //Проверяем есть ли такая транзакция по полученнмоу uuid
    //         $transaction = $transactionReposiotory->TransactionByUuid($validated['transaction_uuid']);
    //         abort_unless((bool) $transaction, 404,  'Ресурс по uuid не был найден.');
    //     }


    //     //создаём платежку и привязываем к (payble) (Транзакция, заказ и т.д)
    //     $payment = $paymentService->createPayment()->payable($transaction)
    //         ->run();

    //     //получаем модель метода по заданному параметру в запросе
    //     $method = $paymentService->getPaymentMethods()
    //                 ->active(true)
    //                 ->id($validated['method_id'])
    //                 ->first();


    //     //обновляем данные оплаты (указываем методы оплаты QR -> Youkassa, Банк Точка)
    //     $updatePayment = $paymentService->updatePayment()
    //         ->method($method)
    //         ->run($payment);


    //     return $updatePayment?
    //     response()->json(array_success( PaymentTransactionResource::make($payment->refresh()), 'Successfully create payment for transactions'), 201)
    //     :
    //     response()->json(array_error(null, 'Failed create payment for transactions'), 404);

    // }
}
