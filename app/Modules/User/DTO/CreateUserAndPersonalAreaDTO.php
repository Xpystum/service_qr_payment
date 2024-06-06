<?php

namespace App\Modules\User\DTO;

use App\Modules\User\DTO\PersonalArea\CreatePersonalAreaDTO;

class CreateUserAndPersonalAreaDTO
{
    public function __construct(

        public readonly CreatUserDTO $user,

        public readonly CreatePersonalAreaDTO $personalArea,

    ) { }

}
