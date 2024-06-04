<?php

namespace App\Modules\User\Actions\Passwords;

use App\Modules\User\DTO\Passwords\CreatePasswordDTO;
use App\Modules\User\Models\Password;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function App\Helpers\Mylog;

class CreatePasswordAction
{
    public static function run(CreatePasswordDTO $data) : Password
    {
        $pass = Password::create(
            [
                'user_id' => $data->user_id,
                'code' => $data->notify->code ?? null,
                'notification_id' => $data->notify->id ?? null,
                'ip' => $data->ip,
            ]
        );


        if(!$pass->save()){
            Mylog('Не удалось создать запись изменение пароля в таблице {password} у User');
            throw new ModelNotFoundException('Не удалось создать запись password.', 500);
        }


        return $pass;
    }

}
