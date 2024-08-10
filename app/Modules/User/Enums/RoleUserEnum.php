<?php

namespace App\Modules\User\Enums;

use InvalidArgumentException;

enum RoleUserEnum : string
{
    case admin = 'admin';
    case manager = 'manager';
    case cashier = 'cashier';



    public function isAdmin(): bool
    {
        return (bool) $this->is(RoleUserEnum::admin);
    }

    private function is(RoleUserEnum $status): bool
    {
        return (bool) $this === $status;
    }

    public static function returnObjectByString(string $value) : self
    {
        return match ($value) {

            'admin' => self::admin,

            'manager' => self::manager,

            'cashier' => self::cashier,

            default => throw new InvalidArgumentException (
                "Не правильный аргумент в функции: [{$value}] не поддерживается" , 500
            ),

        };
    }
}
