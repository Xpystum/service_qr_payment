<?php

namespace App\Modules\Notifications\Enums;

enum ActiveStatusEnum : string
{
    case pending = 'pending';
    case completed = 'completed';
    case expired = 'expired';

    public function is(self $status): bool
    {
        return (bool) ($this === $status);
    }

}
