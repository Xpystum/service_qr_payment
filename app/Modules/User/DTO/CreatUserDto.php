<?php

namespace App\Modules\User\DTO;
use Illuminate\Contracts\Support\Arrayable;

class CreatUserDto implements Arrayable
{
    public function __construct(

        public readonly ?string $email,

        public readonly ?string $phone,

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
