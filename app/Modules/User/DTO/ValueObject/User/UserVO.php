<?php

namespace App\Modules\User\DTO\ValueObject\User;

use Illuminate\Support\Arr;

final class UserVO
{
    public function __construct(

        public readonly ?string $email,

        public readonly ?string $phone,

        public readonly ?string $password,

    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: Arr::get($data, 'email'),
            phone: Arr::get($data, 'phone'),
            password: Arr::get($data, 'password'),
        );
    }
}
