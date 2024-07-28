<?php

namespace App\Modules\Payment\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Payment\Enums\PaymentDriverEnum;
use App\Modules\Payment\Models\DriverInfo as Model;
use Illuminate\Support\Collection;

class DriverInfoRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Возвращаем все связанные данные у user по type_id
     * @param int|null $id
     *
     * @return Collection|null
     */
    public function getDriverInfoTypeId(?int $type_id, ?int $user_id) : ?Collection
    {
        $model = $this->query()
                    ->where("type_id", $type_id)
                    ->where('owner_id', $user_id)
                    ->get();

        return $model;
    }

    public function getAllDriverInfoByType(PaymentDriverEnum $type, int $user_id) : ?Collection
    {
        $model = $this->query()
                    ->where("name_type", $type)
                    ->where('owner_id', $user_id)
                    ->get();

        return $model;
    }

}
