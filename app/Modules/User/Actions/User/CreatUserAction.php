<?php

namespace App\Modules\User\Actions\User;

use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreatUserAction
{
    public static function run(CreatUserDTO $data) : User
    {

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
