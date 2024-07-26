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
    public function run(CreateDriverInfoDTO $data) : bool
    {
        //критерии по обновлении если есть такая запись
        $attributes = [
            'owner_id' => $data->user->id,
            'type_id' => $data->payment_method->id,
            'parametr' => $data->parametr,
        ];

        #TODO Здесь нужна проверка относительно driver_info_storage - есть ли такой параметр для такого типа

        //что обновить или создать
        $values = [
            'name_type' => $data->payment_method->driver,
            'type_id' => $data->payment_method->id,
            'parametr' => $data->parametr,
            'owner_id' => $data->user->id,
            'value' => $data->value,
        ];


        $model = DriverInfo::query()
            ->updateOrCreate($attributes, $values );

        return (bool) $model;
    }

}



