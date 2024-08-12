<?php

namespace App\Modules\User\DTO;

use App\Modules\User\DTO\ValueObject\PersonalAreaVO;
use App\Modules\User\DTO\ValueObject\User\UserVO;
use App\Patterns\DataTransferObject\BaseDTO;
use Illuminate\Contracts\Support\Arrayable;

class CreatUserDTO extends BaseDTO implements Arrayable
{

    public function __construct(

        public readonly UserVO $user,

        public readonly ?int $personal_area_id = null,

    ) { }

    public static function make(UserVO $data, ?int $personal_area_id = null) : self
    {
        return new self(
            user: $data,
            personal_area_id: $personal_area_id,
        );

    }


    public function toArray(): array {

        return [
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'password' => $this->user->password,
            'personal_area_id' => $this->personal_area_id,
        ];
    }

}
