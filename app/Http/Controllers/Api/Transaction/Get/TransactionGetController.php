<?php

namespace App\Http\Controllers\Api\Transaction\Get;

use App\Http\Controllers\Controller;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Models\Transaction;

class TransactionGetController extends Controller
{
    public function __invoke(Terminal $terminal)
    {
        dd($terminal);
    }
}
