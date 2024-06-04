<?php

namespace App\Modules\User\Actions\Passwords;

use App\Modules\Notification\Models\Notification;
use App\Modules\User\Enums\Password\PasswordStatusEnum;
use App\Modules\User\Models\Password;

use function App\Helpers\Mylog;

class UpdatePasswordAction
{
    public static function run(Notification $data) : bool
    {
        $pass = Password::where('user_id' , '=' , $data->user_id)
            ->where('status' , '=' , PasswordStatusEnum::pending)
            ->orderBy('created_at', 'desc')
            ->first();

        $status = $pass->update(
            [
                'notification_id' => $data->id,
                'code' => $data->code,
                'status' => PasswordStatusEnum::completed,
            ]
        );

        return ($status > 0) ? true : false;

        if($status > 0)
        {

            return true;

        } else {

            MyLog('Ошибка при обновлении данных в таблице password');
            throw new \Exception('Ошибка обновление в таблтице password', 500);
        }
    }

}
