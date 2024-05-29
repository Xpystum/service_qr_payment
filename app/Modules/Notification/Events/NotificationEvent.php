<?php

namespace App\Modules\Notification\Events;
use App\Modules\Notification\Enums\ActiveStatusEnum;
use App\Modules\Notification\Models\Notification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
* Для подтвреждение статуса заявки
*/
class NotificationEvent
{

    public function __construct(

        public Notification $model,
        public ActiveStatusEnum $status,

    ) { }


}
