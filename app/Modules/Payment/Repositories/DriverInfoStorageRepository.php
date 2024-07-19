<?php

namespace App\Modules\Payment\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Payment\Models\DriverInfoStorage as Model;
use Illuminate\Support\Collection;

class DriverInfoStorageRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }


    /**
     * Возвращает все параметры по платежкам true/false - только по включенным или по всем
     * @param bool $active //Вернуть все параметры, у которой платежка доступна в данный момент
     *
     * @return Collection|null
     */
    public function getStorageDriverInfo(bool $active = false) : ?Collection
    {
        $model = $this->query()->whereHas('storage', function ($query) use ($active) {
            if($active) { $query->where('active', $active); };
        })->get();

        return $model;
    }

}
