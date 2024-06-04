<?php

namespace App\Modules\User\Actions;

use App\Modules\Notification\Models\Notification;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\UserRepository;

class UpdateEmailConfirmUserAction
{
    public function __construct(
        public UserRepository $userRepository,
    ) {}
    public static function run(User $user, Notification $notification) : bool
    {

        if(!$notification) { return false; }

        $nameMethod = $notification->method->name->value;

        //есть проблема привязки к case по хард коду (попробуй потом добавить драйвер и вспомнить что где надо добавлять =\ )
        switch($nameMethod){

            case 'email':
            {
                $status = $user->query()->update([
                    'email_confirmed_at' => now(),
                    'auth' => true,
                ]);

                //что бы сразу акутальные данные отправлилсь в ответ api
                $user->refresh();

                return ($status > 0) ? true : false;
            }

            case 'phone':
            {
                $status = $user->query()->update([
                    'phone_confirmed_at' => now(),
                    'auth' => true,
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
