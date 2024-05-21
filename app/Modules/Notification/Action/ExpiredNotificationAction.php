<?php

namespace App\Modules\Notification\Action;

use App\Modules\Notification\Enums\ActiveStatusEnum;
use App\Modules\Notification\Events\NotificationEvent;
use App\Modules\Notification\Models\Notification;

class ExpiredNotificationAction
{

    public function run(Notification $model)
    {
        event(new NotificationEvent($model, ActiveStatusEnum::expired));
    }

}
