<?php

namespace App\Modules\Organization\DTO;
use App\Modules\User\DTO\PersonalArea\CreatePersonalAreaDTO;

class CreateOrganizationDTO
{
    public function __construct(

        public readonly CreatUserDTO $user,

        public readonly CreatePersonalAreaDTO $personalArea,

    ) { }

    public readonly string $name,
    public readonly string $address,
    public readonly ?string $phone_number,
    public readonly ?string $email,
    public readonly ?string $website,
    public readonly TypeOrganizationEnum $type,
    public readonly ?string $desctiprion,
    public readonly ?string $industry,
    public readonly ?string $founded_date,
    public readonly string $inn,
    public readonly ?string $kpp,
    public readonly ?string $registration_number,
    public readonly ?string $registration_number_individual,

}
