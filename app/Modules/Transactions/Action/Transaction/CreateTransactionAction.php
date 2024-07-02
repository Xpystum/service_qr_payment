<?php

namespace App\Modules\Transactions\Action\Transaction;

use App\Helpers\Values\AmountValue;
use App\Modules\Currencies\Repositories\CurrenciesRepositories;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateTransactionAction
{

    public static function run(Terminal $terminal, ?AmountValue $amount) : Transaction
    {
        $currencies = app(CurrenciesRepositories::class)::getRub();

        $terminal = Transaction::create([
            'terminal_id' => $terminal->id,
            'driver_currency_id' => $currencies->id,
            'amount' => $amount,
        ]);


        if(!$terminal->save()){
            throw new ModelNotFoundException('Не удалось создать терминал.', 500);
        }

        return $terminal;
    }
}
