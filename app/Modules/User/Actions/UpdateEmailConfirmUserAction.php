<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;

class UpdateEmailConfirmUserAction
{
    public static function run(User $user) : bool
    {
        $notification = $user->lastNotify;

        if(!$notification) { return false; }

        $nameMethod = $notification->method->name->value;

        //есть проблема привязки к case по хард коду (попробуй потом добавить драйвер и вспомнить что где надо добавлять =\ )
        switch($nameMethod){

            case 'email':
            {
                $status = $user->query()->update([
                    'email_confirmed_at' => now(),
                ]);

                //что бы сразу акутальные данные отправлилсь в ответ api
                $user->refresh();

                return ($status > 0) ? true : false;
            }

            case 'phone':
            {
                $status = $user->query()->update([
                    'phone_confirmed_at' => now(),
                ]);

                //что бы сразу акутальные данные отправлилсь в ответ api
                $user->refresh();

                return ($status > 0) ? true : false;
            }

            default:
            {
                throw new \InvalidArgumentException("Invalid NotificationMethod");
            }

        }

    }

}
