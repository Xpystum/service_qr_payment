<?php

namespace App\Modules\User\Action;

use App\Modules\User\DTO\CreatUserDto;
use App\Modules\User\Models\User;

class CreatUserAction
{
    public function run(CreatUserDto $data) : User
    {

        $user = (new User)->fill([

            'email' => $data->email,

            'phone' => $data->phone,

            'password' => $data->email,

        ]);

        if($user->save()){
            #TODO //выслать ошибку
        }

        return $user;
    }

}
