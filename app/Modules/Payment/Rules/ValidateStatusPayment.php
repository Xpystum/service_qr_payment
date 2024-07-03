<?php

namespace App\Modules\Payment\Rules;

use App\Modules\Payment\Models\PaymentMethod;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateStatusPayment implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!PaymentMethod::find($value)?->active) {
            $fail('Метод оплаты временно не доступен.');
        }
    }
}
