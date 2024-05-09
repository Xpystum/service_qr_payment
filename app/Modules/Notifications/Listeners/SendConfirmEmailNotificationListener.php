<?php

namespace App\Modules\Notifications\Listeners;

use App\Modules\Notifications\Action\CreateEmailAction;
use App\Modules\Notifications\Action\UpdateCodeAction;
use App\Modules\Notifications\DTO\CreatEmailDto;
use App\Modules\Notifications\Enums\ActiveStatusEnum;
use App\Modules\Notifications\Notify\ConfirmEmailNotification;
use App\Modules\User\Events\UserCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

use function App\Helpers\code;

class SendConfirmEmailNotificationListener implements ShouldQueue
{
    public function handle(UserCreatedEvent $event): void
    {

        if($event->email === null) {

            //создаём заявку на подтверждение email
            $email = CreateEmailAction::run(
                new CreatEmailDto(
                    value: $event->user->email,
                    user_id: $event->user->id,
                    status: ActiveStatusEnum::pending,
                )
            );

            $notification = new ConfirmEmailNotification($email);
            $event->user->notify($notification);

        } else {

            //если не обновилось ничего не делаем (завершаем работу в очереди)
            if(!UpdateCodeAction::run($event->email)){
                Log::error("Произошла ошибка при обновлении модели Email, поле code: " . now());
                return;
            }

            $notification = new ConfirmEmailNotification($event->email);
            $event->user->notify($notification);

        }



    }
}
