<?php

namespace App\Modules\User\Action;

use App\Modules\User\DTO\CreatUserDto;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreatUserAction
{
    public function run(CreatUserDto $data) : User
    {
        $user = (new User)->fill([

            'email' => $data->email,

            'phone' => $data->phone,

            'password' =>  $data->password,

        ]);


        if(true){
            throw new ModelNotFoundException('Не удалось создать пользователя.', 500);
        }

        $user->save();
        return $user;
    }

}
