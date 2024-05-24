<?php

namespace App\Modules\Notification\Enums;

use InvalidArgumentException;

enum MethodNotificationEnum: string
{
    case phone = 'phone';

    case email = 'email';

    public function fromObjectToString() : string
    {

        return match ($this) {

            self::phone => NotificationDriverEnum::smtp->value,

            self::email => NotificationDriverEnum::aero->value,

            default => throw new InvalidArgumentException(

                "Драйвер [{$this->value}] не поддерживается"

            )
        };
    }


}
