<?php

namespace App\Modules\User\Actions\User;

use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\Enums\RoleUserEnum;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreatUserAction
{
    public static function run(CreatUserDTO $data) : User
    {
        $user = null;
        if($data->personal_area_id && $data->role) {

            $user = User::firstOrCreate(
                ['email' => $data->email, 'phone' => $data->phone ], // Критерии для поиска пользователя
                ['password' =>  $data->password, 'personal_area_id' => $data->personal_area_id, ] // Данные нового пользователя
            );
            //Делаем так что бы обойти защиту guarded в модели
            $user->auth = true;
            $user->role = RoleUserEnum::returnObjectByString($data->role);

        } else {

            $user = User::firstOrCreate(
                ['email' => $data->email, 'phone' => $data->phone ], // Критерии для поиска пользователя
                ['password' =>  $data->password] // Данные нового пользователя
            );

        }

        if(!$user->save()){
            throw new ModelNotFoundException('Не удалось создать пользователя.', 500);
        }


        return $user;
    }

}
