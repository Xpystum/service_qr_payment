<?php

namespace App\Modules\Transactions\Action\Handler;

use App\Modules\Organization\Repositories\OrganizationRepositories;
use App\Modules\Terminal\Repositories\TerminalRepository;
use App\Modules\Transactions\Action\Transaction\CreateTransactionAction;
use App\Modules\Transactions\DTO\CreateTransactionDTO;
use App\Modules\Transactions\DTO\ValueObject\TransactionVO;
use App\Modules\Transactions\Models\Transaction;


class CreateTransactionHandler
{
    public function handle(TransactionVO $data) : ?Transaction
    {
        $terminalRepository = TerminalRepository::make();
        $createTransactionAction = CreateTransactionAction::make();
        {
            $terminal = $terminalRepository->getTerminalByUuid($data->terminal_uuid);
            abort_unless( (bool) $terminal, 404, 'Такой записи по uuid не существует');
        }

        $model = $createTransactionAction::run(CreateTransactionDTO::make($data, $terminal));
        return $model;
    }

}
