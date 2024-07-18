<?php

namespace App\Modules\Payment\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Payment\Models\PaymentMethod as Model;


class PaymentMethodRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getPaymentMethodsId(?int $id) : ?Model
    {
        $model = $this->query()
                    ->where("id", $id)
                    ->first();

        return $model;
    }

}
