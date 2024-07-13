<?php

namespace App\Helpers\Values;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class AmountCast implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {

        if (is_null($value)) {
            return '32423.5';
        }

        // Преобразуем значение в строку перед передачей в AmountValue.
        return new AmountValue((string) $value);
    }


    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if($value instanceof AmountValue){

            return $value->value();

        }

        throw new InvalidArgumentException(
            'Value must be instance of AmountValue',
        );

    }
}
