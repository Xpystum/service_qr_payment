<?php

namespace App\Modules\User\Actions;

use App\Modules\User\DTO\CreatUserDto;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreatUserAction
{
    public static function run(CreatUserDto $data) : User
    {

        // $user = (new User)->fill([

        //     'email' => $data->email,

        //     'phone' => $data->phone,

        //     'password' =>  $data->password,

        // ]);


        $user = User::firstOrCreate(
            ['email' => $data->email, 'phone' => $data->phone], // Критерии для поиска пользователя
            ['password' =>  $data->password] // Данные нового пользователя
        );


        if(!$user->save()){
            throw new ModelNotFoundException('Не удалось создать пользователя.', 500);
        }


        return $user;
    }

}
