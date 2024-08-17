<?php

namespace App\Modules\Organization\DTO;
use App\Modules\Organization\DTO\ValueObject\OrganizationVO;
use App\Modules\User\Models\User;
use Illuminate\Contracts\Support\Arrayable;

class UpdateOrganizationDTO implements Arrayable
{
    public function __construct(

        public readonly OrganizationVO $organization,
        public readonly User $user,
        public readonly string $uuid, //uuid организации у которой обновляем данные

    ) { }

    public static function make(OrganizationVO $organization, User $user, string $uuid)
    {
        return new self(
            organization: $organization,
            user: $user,
            uuid: $uuid,
        );
    }

    public function toArray() : array
    {
        return [];
        // return $this->organization->toArray();
    }

    public function toArrayOrganization()
    {
        return $this->organization->toArrayNotNull();
    }

}
