<?php

namespace App\Modules\User\Rules;

use App\Modules\User\Rules\Traits\TraitRule;

class EmailRule
{
    use TraitRule;
    protected array $rules = ["required_without_all:phone", "exclude_with:phone", "string", "email:filter", "max:100"];

}
