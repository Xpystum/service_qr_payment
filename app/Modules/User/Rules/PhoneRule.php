<?php

namespace App\Modules\User\Rules;

use App\Modules\User\Rules\Traits\RuleTraits;

class PhoneRule
{
    use RuleTraits;
    protected string $rules = ["required_without_all:email", "exclude_with:email", "numeric", "regex:/^(\+7|8)(\d{10})$/", "unique:App\Modules\User\Models\User"];
}
