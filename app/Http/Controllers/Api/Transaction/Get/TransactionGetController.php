<?php

namespace App\Http\Controllers\Api\Transaction\Get;

use App\Http\Controllers\Controller;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Repositories\TransactionReposiotory;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class TransactionGetController extends Controller
{
    public function __invoke(Terminal $terminal, TransactionReposiotory $repository)
    {
        $pagination = $repository->getAllTransactionOfTerminalPagination($terminal);

        return $pagination?
        response()->json(array_success( $pagination, 'Successfully return transaction pagination'), 200)
            :
        response()->json(array_error(null, 'Failed return transaction'), 404);
    }
}
