<?php

namespace App\Modules\User\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\User\Models\PersonalArea as Model;
use App\Modules\User\Models\User;

class PersonalAreaRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }


    public function getPersonalArea(User $user) : ?Model
    {
        $personalArea = $this->query()
                        ->where('owner_id' , '=' , $user->id)
                        ->first();
                        
        return $personalArea;
    }
}
