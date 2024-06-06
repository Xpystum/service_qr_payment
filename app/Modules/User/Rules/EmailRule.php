<?php

namespace App\Modules\User\Rules;

class EmailRule
{
    protected array $rules = ["required_without_all:phone", "exclude_with:phone", "string", "email:filter", "max:100", "unique:App\Modules\User\Models\User"];

    public function toArray(): array
    {
        return $this->rules;
    }

}
