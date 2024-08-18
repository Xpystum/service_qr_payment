<?php

namespace App\Modules\Transactions\DTO;

use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\DTO\ValueObject\TransactionVO;

class CreateTransactionDTO
{
    public function __construct(
        public readonly TransactionVO $transactionVO,
        public readonly Terminal $terminal,
    ) {}

    public static function make(TransactionVO $transactionVO, Terminal $terminal) : self
    {
        return new self(
            transactionVO: $transactionVO,
            terminal: $terminal,
        );
    }

}
