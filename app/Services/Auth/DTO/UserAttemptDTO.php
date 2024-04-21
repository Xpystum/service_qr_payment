<?php

namespace App\Services\Auth\DTO;
use Illuminate\Contracts\Support\Arrayable;

class UserAttemptDTO implements Arrayable
{
    public function __construct(

        public readonly ?string $phone,

        public readonly ?string $email,

        public readonly ?string $password,

    ) { }

    public function toArray(): array {
        return [
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
        ];
    }
}
