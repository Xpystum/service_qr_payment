<?php

namespace App\Modules\User\Rules\Traits;

trait TraitRule
{
    public function toArray(): array
    {
        return $this->rules;
    }

    public function addRule(string $rule) : self
    {
        $this->rules[] = $rule;

        return $this;
    }
}
