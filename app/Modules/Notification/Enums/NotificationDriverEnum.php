<?php

namespace App\Modules\Notification\Enums;
use InvalidArgumentException;

enum NotificationDriverEnum: string
{
    case aero = 'aero';

    case smtp = 'smtp';

    public static function objectByName(string $type) : NotificationDriverEnum
    {

        return match ($type) {

            self::smtp->value => NotificationDriverEnum::smtp,

            self::aero->value => NotificationDriverEnum::aero,

            default => throw new InvalidArgumentException(

                "Драйвер [{$type}] не поддерживается"

            )
        };
    }

}
