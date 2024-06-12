<?php

namespace App\Modules\Notification\Events;
use App\Modules\Notification\Enums\ActiveStatusEnum;
use App\Modules\Notification\Models\Notification;

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
