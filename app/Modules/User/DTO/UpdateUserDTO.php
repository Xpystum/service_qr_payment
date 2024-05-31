<?php

namespace App\Modules\User\DTO;

use Illuminate\Contracts\Support\Arrayable;

class UpdateUserDTO implements Arrayable
{
    public function __construct(

        public readonly int $id,

        public readonly ?string $email,

        public readonly ?string $phone,

        public readonly ?string $first_name,
        public readonly ?string $last_name,
        public readonly ?string $father_name,


    ) { }

    public function filterIsNotNull() : array
    {
        $attributesToUpdate = array_filter([
            'email' => $this->email,
            'phone' => $this->phone,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
        ], function ($value) {
            // Возвращаем true для значений, которые не равны null, чтобы оставить их в массиве
            return !is_null($value);
        });

        return $attributesToUpdate;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
        ];
    }

}
