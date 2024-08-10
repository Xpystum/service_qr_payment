<?php

namespace App\Modules\User\Actions\User;

use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\DTO\ValueObject\User\UserVO;

use App\Modules\User\Models\User;
use App\Patterns\DataTransferObject\BaseDTO;
use App\Patterns\Handlers\AbstractHandler;
use Illuminate\Support\Facades\DB;

class CreatUserAction extends AbstractHandler
{
    /**
    * @param CreatUserDTO $data
    */
    protected function process(BaseDTO $data)
    {
        $this->run($data);
    }

    public static function run(CreatUserDTO $data) : User
    {
        $user = DB::transaction(function () use ($data) {

            return User::firstOrCreate(
                ['email' => $data->user->email, 'phone' => $data->user->phone ], // Критерии для поиска пользователя
                ['password' =>  $data->user->password, 'personal_area_id' => $data->area?->personal_area_id, ] // Данные нового пользователя
            );

        });

        return $user;
    }

    // public static function run(UserVO $data) : User
    // {
    //     $user = null;
    //     if($data->personal_area_id && $data->role) {

    //         $user = User::firstOrCreate(
    //             ['email' => $data->user->email, 'phone' => $data->user->phone ], // Критерии для поиска пользователя
    //             ['password' =>  $data->user->password, 'personal_area_id' => $data->personal_area_id, ] // Данные нового пользователя
    //         );
    //         //Делаем так что бы обойти защиту guarded в модели
    //         $user->auth = true;
    //         $user->role = RoleUserEnum::returnObjectByString($data->role);

    //     } else {

    //         $user = User::firstOrCreate(
    //             ['email' => $data->user->email, 'phone' => $data->user->phone ], // Критерии для поиска пользователя
    //             ['password' => $data->user->password] // Данные нового пользователя
    //         );

    //     }

    //     if(!$user->save()){
    //         throw new ModelNotFoundException('Не удалось создать пользователя.', 500);
    //     }


    //     return $user;
    // }

}
