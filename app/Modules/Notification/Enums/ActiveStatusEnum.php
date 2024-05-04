<?php

namespace App\Modules\Notification\Enums;

enum ActiveStatusEnum : string
{
    case pending = 'pending';
    case completed = 'completed';
    case expired = 'expired';

    public function if(self $status): bool
    {
        return ($this === $status);
    }

}
