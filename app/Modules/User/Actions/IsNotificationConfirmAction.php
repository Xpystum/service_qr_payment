<?php

namespace App\Modules\User\Actions;

use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\Models\User;

use function App\Helpers\Mylog;

class IsNotificationConfirmAction
{
    public static function run(string $type, User $user) : bool
    {

        switch($type){
            case 'phone':
            {
                if($user->phone_confirmed_at === null)
                {
                    return false;
                }
                return true;
            }

            case 'email':
            {

                if($user->email_confirmed_at === null)
                {
                    return false;
                }

                return true;
            }

            default:
            {
                Mylog('Ошибка выбора типа нотификации при IsNotificationConfirmAction');
                throw new \InvalidArgumentException("У модели [{$user}] нет поля phone_confirmed_at", 500);
            }
        }
    }


}
