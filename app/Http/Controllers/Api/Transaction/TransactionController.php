<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Helpers\Values\AmountValue;
use App\Http\Controllers\Controller;
use App\Modules\Payment\Requests\PaymentMethodRequest;
use App\Modules\Payment\Service\PaymentService;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Terminal\Repositories\TerminalRepository;
use App\Modules\Transactions\Action\Transaction\CreateTransactionAction;
use App\Modules\Transactions\Models\Transaction;
use App\Modules\Transactions\Repositories\TransactionReposiotory;
use App\Modules\Transactions\Requests\TransactionRequest;
use App\Modules\Transactions\Resources\PaymentTransactionResource;
use App\Modules\Transactions\Resources\TransactionResource;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class TransactionController extends Controller
{

    public function index(Terminal $terminal, TransactionReposiotory $repository)
    {
        $pagination = $repository->getAllTransactionOfTerminalPagination($terminal);

        return $pagination?
        response()->json(array_success( $pagination, 'Successfully return transaction pagination'), 200)
            :
        response()->json(array_error(null, 'Failed return transaction'), 404);
    }


    public function all(Terminal $terminal, TransactionReposiotory $repository)
    {
        $allModels = $repository->all($terminal);

        return response()->json(array_success( TransactionResource::collection($allModels), 'Get all transaction by terminal'), 200);
    }


    public function show(Transaction $transaction)
    {
        return response()->json(array_success(new TransactionResource($transaction), 'Show transaction by uuid'), 200);
    }

    public function create(
        TransactionRequest $request,
        TerminalRepository $terminalRepository,
        CreateTransactionAction $action,
    ) {

        $validated = $request->validated();

        {
            $terminal = $terminalRepository->getTerminalByUuid($validated['terminal_uuid']);
            abort_unless( (bool) $terminal, 404, 'Такой записи по uuid не существует');
        }

        $model = $action::run($terminal, new AmountValue($validated['amount']));

        return $model?
        response()->json(array_success( new TransactionResource($model), 'Successfully create transaction'), 201)
            :
        response()->json(array_error(null, 'Failed create transaction'), 404);

    }


    public function payment(
        PaymentMethodRequest $request,
        Transaction $transaction,
        PaymentService $paymentService
    ) {

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
        response()->json(array_success( PaymentTransactionResource::make($payment->refresh()), 'Successfully create payment for transactions'), 201)
        :
        response()->json(array_error(null, 'Failed create payment for transactions'), 404);

    }

    public function payment_index(Transaction $transaction)
    {
        return response()->json(array_success( PaymentTransactionResource::collection($transaction->payment), 'Show transaction by uuid'), 200);
    }
}
