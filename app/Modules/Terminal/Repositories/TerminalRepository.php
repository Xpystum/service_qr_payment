<?php

namespace App\Modules\Terminal\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Organization\Models\Organization;
use App\Modules\Terminal\Models\Terminal as Model;
use App\Modules\User\Models\User;
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
}
