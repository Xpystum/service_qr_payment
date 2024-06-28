<?php

namespace App\Http\Controllers\Api\Transaction\Create;

use App\Helpers\Values\AmountValue;
use App\Http\Controllers\Controller;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Action\Transaction\CreateTransactionAction;
use App\Modules\Transactions\Requests\TransactionRequest;

class TransactionCreateController extends Controller
{
    public function __invoke(TransactionRequest $request,Terminal $terminal, CreateTransactionAction $action)
    {
        $validated = $request->validated();

        $model = $action::run($terminal, new AmountValue($validated['amount']));

        dd($model);
    }
}
