<?php

namespace App\Modules\User\DTO\ValueObject\User;

use App\Modules\User\Enums\RoleUserEnum;
use Illuminate\Support\Arr;

final class UserVO
{
    public function __construct(

        public readonly ?string $email,

        public readonly ?string $phone,

        public readonly ?string $password,

        public readonly ?RoleUserEnum $role,

    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: Arr::get($data, 'email' , null),
            phone: Arr::get($data, 'phone' , null),
            password: Arr::get($data, 'password'),
            role: RoleUserEnum::returnObjectByString(Arr::get($data, 'role', null)),
        );
    }
}
