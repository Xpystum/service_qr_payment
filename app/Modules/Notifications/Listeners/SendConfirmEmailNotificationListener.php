<?php

namespace App\Modules\Notifications\Listeners;

use App\Modules\Notifications\Action\CreateEmailAction;
use App\Modules\Notifications\DTO\CreatEmailDto;
use App\Modules\Notifications\Enums\ActiveStatusEnum;
use App\Modules\Notifications\Notify\ConfirmEmailNotification;
use App\Modules\User\Events\UserCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendConfirmEmailNotificationListener //implements ShouldQueue
{
    public function handle(UserCreatedEvent $event): void
    {

        $email = CreateEmailAction::run(
            new CreatEmailDto(
                value: $event->user->email,
                user_id: $event->user->id,
                status: ActiveStatusEnum::pending,
            )
        );

        $notification = new ConfirmEmailNotification($email);
        $event->user->notify($notification);
    }
}
