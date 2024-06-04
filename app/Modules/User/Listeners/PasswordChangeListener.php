<?php

namespace App\Modules\User\Listeners;

use App\Modules\User\Actions\Passwords\CreatePasswordAction;
use App\Modules\User\DTO\Passwords\CreatePasswordDTO;
use App\Modules\User\Events\PasswordCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

use function App\Helpers\Mylog;

class PasswordChangeListener
{

    public function __construct(public CreatePasswordAction $passAction)
    {}
    public function handle(PasswordCreatedEvent $event): void
    {
        $pass = $this->passAction::run(
            new CreatePasswordDTO(
                notify: null,
                user_id: $event->user->id,
                ip: $event->ip,
            )
        );

        if(!$pass){ Mylog('Ошибка создание записи в таблицу {password}'); }
    }
}
