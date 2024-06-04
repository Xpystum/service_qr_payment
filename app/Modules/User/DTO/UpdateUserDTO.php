<?php

namespace App\Modules\User\DTO;

use Illuminate\Contracts\Support\Arrayable;

class UpdateUserDTO implements Arrayable
{
    public function __construct(

        public readonly int $id,

        public readonly ?string $email = null,

        public readonly ?string $phone = null,

        public readonly ?string $first_name = null,
        public readonly ?string $last_name = null,
        public readonly ?string $father_name = null,

        public readonly ?string $password = null,


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
