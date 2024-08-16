<?php

namespace App\Modules\Organization\DTO;

use App\Modules\Organization\DTO\ValueObject\OrganizationVO;
use App\Modules\User\Models\User;
use Illuminate\Contracts\Support\Arrayable;

class CreateOrganizationDTO implements Arrayable
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

    public function toArray() : array
    {
        $array = $this->organization->toArray();
        $array['owner_id'] = $this->user->id;

        return $array;
    }

}
