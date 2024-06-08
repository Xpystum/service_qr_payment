<?php

namespace App\Modules\Organization\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OgrnepRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!$this->validateOGRNEP($value))
        {
            $fail('У :attribute не правильный формат данных');
        }
    }

    private function validateOGRNEP($ogrn) : bool
    {

        if (strlen($ogrn) !== 15) {
            return false;
        }

        $mainPart = substr($ogrn, 0, -1);  // Первые 14 цифр
        $controlDigit = substr($ogrn, -1);  // Последняя цифра (контрольная)

        $mod13Remainder = intval($mainPart) % 13;

        return intval($controlDigit) === $mod13Remainder;

    }
}
