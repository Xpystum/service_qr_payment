<?php

namespace App\Http\Controllers\Api\Transaction\Create;

use App\Helpers\Values\AmountValue;
use App\Http\Controllers\Controller;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Action\Transaction\CreateTransactionAction;
use App\Modules\Transactions\Requests\TransactionRequest;
use App\Modules\Transactions\Resources\TransactionResource;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class TransactionCreateController extends Controller
{
    public function __invoke(TransactionRequest $request,Terminal $terminal, CreateTransactionAction $action)
    {
        $validated = $request->validated();

        $model = $action::run($terminal, new AmountValue($validated['amount']));


        return $model?
        response()->json(array_success( new TransactionResource($model), 'Successfully create transaction'), 200)
            :
        response()->json(array_error(null, 'Failed create transaction'), 404);
    }
}
