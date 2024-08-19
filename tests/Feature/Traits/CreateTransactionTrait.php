<?php

namespace Tests\Feature\Traits;

use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Enums\TransactionStatusEnum;
use App\Modules\Transactions\Models\Transaction;

trait CreateTransactionTrait
{
    use CreateTerminalTrait, InstallCurrensiesTrait;
    protected function create_transaction(Terminal $terminal = null) : Transaction
    {
        $this->installCurrensies();

        if(is_null($terminal)) { $terminal = $this->create_terminal(); }

        $transaction = $terminal->transaction()->create([
            'status' => TransactionStatusEnum::pending,
            'driver_currency_id' => 'RUB',
            'amount' => fake()->numberBetween(10 , 1000),
        ]);

        $this->assertDatabaseHas('transactions', [
            'uuid' => $transaction->uuid,
        ]);



        return $transaction;
    }
}
