<?php

namespace App\Modules\Payment\DTO;

use App\Modules\Transactions\Models\Transaction;

class CreatePaymentDTO
{


    public function __construct(
        public readonly Transaction $transaction,
        public readonly int $method_id,
    ) { }



    public static function make(Transaction $transaction, int $method_id) : self
    {
        return new self(
            transaction : $transaction,
            method_id : $method_id,
        );
    }
}
