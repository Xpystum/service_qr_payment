<?php

namespace App\Modules\Payment\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Payment\Models\PaymentMethod as Model;
use Illuminate\Support\Collection;

class PaymentMethodRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getPaymentMethods() : ?Collection
    {
        $model = $this->query()
                    ->where("uuid", $payment->uuid)
                    ->first();

        return $model;
    }

}
