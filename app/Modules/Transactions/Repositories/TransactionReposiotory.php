<?php

namespace App\Modules\Transactions\Repositories;


use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Models\Transaction as Model;

class TransactionReposiotory extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Возвращает все транзакции по пагинации
     * @return [type]
     */
    public function getAllTransactionOfTerminalPagination(Terminal $terminal)
    {
        return $terminal->transaction()->paginate(30);
    }
}
