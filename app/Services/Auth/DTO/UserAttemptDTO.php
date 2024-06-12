<?php

namespace App\Services\Auth\DTO;

class UserAttemptDTO extends BaseDTO
{
    public function __construct(

        public readonly ?string $phone,

        public readonly ?string $email,

        public readonly ?string $password,

    ) { }

    public function toArray(): array {

        $data = [
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
        ];

        $data = collect($data)->filter(function($value){
            return $value !== null;
        })->toArray();

        return $data;
    }
}
