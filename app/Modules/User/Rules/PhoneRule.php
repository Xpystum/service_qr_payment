<?php

namespace App\Modules\User\Rules;

use App\Modules\User\Rules\Traits\TraitRule;

class PhoneRule
{
    use TraitRule;
    protected array $rules = ["required_without_all:email", "exclude_with:email", "numeric", "regex:/^(\+7|8)(\d{10})$/"];

}
