<?php

namespace App\Modules\Organization\Enums;

use InvalidArgumentException;

enum TypeOrganizationEnum : string
{
    case ooo = 'ООО';
    case ip = 'Индивидуальный Предприниматель';

    public static function returnObjectByString(string $value) : self
    {
        return match ($value) {

            'ООО' => self::ooo,

            'Индивидуальный Предприниматель' => self::ip,

            default => throw new InvalidArgumentException (
                "Не правильный аргумент в функции: [{$value}] не поддерживается" , 500
            ),

        };
    }
}
