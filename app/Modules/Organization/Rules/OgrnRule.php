<?php

namespace App\Modules\Organization\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OgrnRule implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!$this->validateOGRN($value))
        {
            $fail('У :attribute не правильный формат данных');
        }
    }

    private function validateOGRN($ogrn) : bool
    {

        if (strlen($ogrn) !== 13) {
            return false;
        }

        $mainPart = substr($ogrn, 0, -1);  // Первые 12 цифр
        $controlDigit = substr($ogrn, -1);  // Последняя цифра (контрольная)

        $mod13Remainder = intval($mainPart) % 11;

        return intval($controlDigit) === $mod13Remainder;

    }
}
