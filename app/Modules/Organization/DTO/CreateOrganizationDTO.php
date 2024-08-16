<?php

namespace App\Modules\Organization\DTO;

use App\Modules\Organization\DTO\ValueObject\OrganizationVO;
use App\Modules\User\Models\User;
use Illuminate\Contracts\Support\Arrayable;

class CreateOrganizationDTO
{
     public function __construct(

        public readonly OrganizationVO $organization,
        public readonly User $user,

    ) { }

    public static function make(OrganizationVO $organization, User $user)
    {
        return new self(
            organization: $organization,
            user: $user,
        );
    }

}
