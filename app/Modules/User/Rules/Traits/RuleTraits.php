<?php

namespace App\Modules\User\Rules\Traits;

trait RuleTraits
{

    public function toArray() : array
    {
        return [$this->rules];
    }
}
