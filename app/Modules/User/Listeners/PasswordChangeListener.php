<?php

namespace App\Modules\User\Listeners;

use App\Modules\User\Actions\Passwords\CreatePasswordAction;
use App\Modules\User\DTO\CreatePasswordDTO;
use App\Modules\User\Events\PasswordCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

use function App\Helpers\Mylog;

class PasswordChangeListener
{

    public function handle(PasswordCreatedEvent $event, CreatePasswordAction $passAction): void
    {
        $pass = $passAction->run(
            new CreatePasswordDTO(
                notify: null,
                user_id: $event->user->id,
                ip: $event->ip,
            )
        );

        if(!$pass){ Mylog('Ошибка создание записи в таблицу {password}'); }
    }
}
