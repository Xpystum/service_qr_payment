<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Action\Handler\CreatePaymentHandler;
use App\Modules\Payment\DTO\CreatePaymentDTO;
use App\Modules\Payment\Requests\PaymentMethodRequest;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Action\Handler\CreateTransactionHandler;
use App\Modules\Transactions\DTO\ValueObject\TransactionVO;
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
        CreateTransactionHandler $handler,
    ) {

        /**
        * @var TransactionVO
        */

        $transactionVO = $request->getValueObject();

        $model = $handler->handle($transactionVO);

        return $model?
        response()->json(array_success( new TransactionResource($model), 'Successfully create transaction'), 201)
            :
        response()->json(array_error(null, 'Failed create transaction'), 404);

    }


    public function payment(
        PaymentMethodRequest $request,
        Transaction $transaction,
        CreatePaymentHandler $hanlder,
    ) {
        $validated = $request->validated();

        $payment = $hanlder->handle(CreatePaymentDTO::make($transaction, $validated['method_id']));

        return $payment?
        response()->json(array_success( PaymentTransactionResource::make($payment), 'Successfully create payment for transactions'), 201)
        :
        response()->json(array_error(null, 'Failed create payment for transactions'), 404);

    }

    public function payment_index(Transaction $transaction)
    {
        return response()->json(array_success( PaymentTransactionResource::collection($transaction->payment), 'Show transaction by uuid'), 200);
    }
}
