<?php

namespace App\Modules\Payment\Action\DriverInfo;

use App\Modules\Payment\DTO\DriverInfo\CreateDriverInfoDTO;
use App\Modules\Payment\Models\DriverInfo;

class CreateDriverInfoAction{


    /**
     * @param CreateDriverInfoDTO $data
     *
     * @return [type]
     */
    public function run(CreateDriverInfoDTO $data)
    {

        $model = DriverInfo::query()
            ->create([
                'name_type' => $data->payment_method->driver,
                'type_id' => $data->payment_method->id,
                'parametr' => $data->parametr,
                'owner_id' => $data->user->id,
                'value' => $data->value,
            ]);


        return $model;
    }

}



