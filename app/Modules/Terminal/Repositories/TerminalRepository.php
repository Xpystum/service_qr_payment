<?php

namespace App\Modules\Terminal\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Terminal\Models\Terminal as Model;
use Illuminate\Support\Collection;

class TerminalRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getTerminal(?int $id) : ?Collection
    {
        $model = $this->query()
                    ->where("organization_id", $id)
                    ->get();

        return $model;
    }

    public function getTerminalByUuid(?string $uuid) : ?Model
    {
        $model = $this->query()
                    ->where("uuid", $uuid)
                    ->first();

        return $model;
    }
}
