<?php

namespace App\Modules\Organization\DTO;

use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\DTO\PersonalArea\CreatePersonalAreaDTO;

class CreateOrganizationDTO
{
    public function __construct(

        public readonly CreatUserDTO $user,

        public readonly CreatePersonalAreaDTO $personalArea,

    ) { }

}
