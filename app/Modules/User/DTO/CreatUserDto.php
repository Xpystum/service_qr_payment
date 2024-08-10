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

        public readonly ?PersonalAreaVO $area,

    ) { }

    public static function make(UserVO $data) : self
    {
        return new self(
            user: $data,
            area: null,
        );

    }


    public function toArray(): array {

        return [
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'password' => $this->user->password,
            'personal_area_id' => $this->area->personal_area_id,
            'role' => $this->area->role,
        ];
    }

}
