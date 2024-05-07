<?php

namespace App\Modules\User\Enums;

enum RoleUserEnum : string
{
    case admin = 'admin';
    case manager = 'manager';
    case cashier = 'cashier';
}
