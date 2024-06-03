<?php

namespace App\Modules\User\Actions\Passwords;

use App\Modules\User\DTO\CreatePasswordDTO;
use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function App\Helpers\Mylog;

class CreatePasswordAction
{
    public static function run(CreatePasswordDTO $data) : User
    {


        $user = User::create(
            [
                'user_id' => $data->user_id,
                'status' => $data->notify->status,
                'code' => $data->notify->code,
                'notification_id' => $data->notify->id,
                'ip' => $data->ip,
            ]
        );


        if(!$user->save()){
            Mylog('Не удалось создать запись изменение пароля в таблице {password} у User');
            throw new ModelNotFoundException('Не удалось создать запись password.', 500);
        }


        return $user;
    }

}
