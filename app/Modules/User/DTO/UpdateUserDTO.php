<?php

namespace App\Modules\User\DTO;

use Illuminate\Contracts\Support\Arrayable;

class UpdateUserDTO implements Arrayable
{
    public function __construct(

        public readonly string $uuid,

        public readonly ?string $email = null,

        public readonly ?string $phone = null,

        public readonly ?string $first_name = null,
        public readonly ?string $last_name = null,
        public readonly ?string $father_name = null,

        public readonly ?string $password = null,


    ) { }

    public static function make(array $validated) : self
    {
        return new self(
            uuid: $validated['uuid'] ?? null,

            email: $validated['email'] ?? null,
            phone: $validated['phone'] ?? null,

            first_name: $validated['first_name'] ?? null,
            last_name: $validated['last_name'] ?? null,
            father_name: $validated['father_name'] ?? null,
        );

    }

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
            'id' => $this->uuid,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
        ];
    }

}
