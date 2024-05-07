<?php

namespace App\Modules\Notifications\Listeners;

use App\Modules\Notifications\Action\UpdateStatusEmailAction;
use App\Modules\Notifications\Events\EmailCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class UpdateStatusEmailNotificationListener implements ShouldQueue
{
    public function handle(EmailCreatedEvent $event): void
    {
        //обновляем статус
        $status = UpdateStatusEmailAction::run($event->email, $event->status);

        (!$status) ? Log::error("Произошла ошибка при изменении статуса email в очереди: " . now()) : "" ;

    }
}
