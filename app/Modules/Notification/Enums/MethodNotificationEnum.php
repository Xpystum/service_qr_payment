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

    public static function returnObjectByString(string $value)
    {
        return match ($value) {

            'phone' => self::phone,

            'email' => self::email,

            default => throw new InvalidArgumentException (
                "Не правильный аргумент в функции: [{$value}] не поддерживается" , 500
            ),

        };
    }
}
