<?php

namespace App\Modules\Transactions\Action\Transaction;

use App\Helpers\Values\AmountValue;
use App\Modules\Currencies\Repositories\CurrenciesRepositories;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\DTO\CreateTransactionDTO;
use App\Modules\Transactions\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateTransactionAction
{

    public static function make() : self
    {
        return new self();
    }

    public static function run(CreateTransactionDTO $data) : Transaction
    {
        $currencies = app(CurrenciesRepositories::class)::getRub();

        $transaction = Transaction::create([
            'terminal_id' => $data->terminal->id,
            'driver_currency_id' => $currencies->id,
            'amount' => $data->transactionVO->amount,
        ]);

        if(!$transaction->save()){
            throw new ModelNotFoundException('Не удалось создать терминал.', 500);
        }

        return $transaction;
    }
}
