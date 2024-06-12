<?php

namespace App\Modules\Notification\Events;

use App\Modules\Notification\DTO\Base\BaseDTO;
use App\Modules\Notification\Models\NotificationMethod;

class SendNotificationEvent //implements ShouldDispatchAfterCommit
{

    public function __construct(

        public BaseDTO $dto,
        public NotificationMethod $notifyMethod,

    ) {  }

}
