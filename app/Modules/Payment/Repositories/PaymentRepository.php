<?php

namespace App\Modules\Payment\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Payment\Models\Payment as Model;
use App\Modules\Payment\Models\Payment;
use Illuminate\Support\Collection;

class PaymentRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getPayment(Payment $payment) : ?Payment
    {
        $model = $this->query()
                    ->where("uuid", $payment->uuid)
                    ->first();
                    
        return $model;
    }


    #TODO Нужна пагинация
    /**
     * Возвращает все платежки
     * @param Payment $payment
     *
     * @return Collection|null
     */
    public function getPayments(Payment $payment) : ?Collection
    {
        $model = $this->query()
                    ->where("uuid", $payment->uuid)
                    ->get();

        return $model;
    }
}
