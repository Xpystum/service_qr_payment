<?php

namespace App\Modules\Transactions\Repositories;


use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Models\Transaction as Model;
use Illuminate\Support\Collection;

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

    /**
     * Вернуть transaction по uuid
     * @param string|null $uuid
     *
     * @return Model|null
     */
    public function TransactionByUuid(?string $uuid) : ?Model
    {
        return $this->query()->where("uuid", $uuid)->first();
    }

    public function all(Terminal $terminal) : ?Collection
    {
        return $terminal->transaction()->get();
    }
}
