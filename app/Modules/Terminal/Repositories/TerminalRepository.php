<?php

namespace App\Modules\Terminal\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Terminal\Models\Terminal as Model;
use App\Modules\User\Models\User;
use Illuminate\Support\Collection;

class TerminalRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getTerminal(User $user) : ?Collection
    {
        $model = $this->query()
                    ->where("user_id", $user->id)
                    ->get();

        return $model;
    }
}
