<?php
namespace App\Modules\User\DTO\PersonalArea;
use App\Modules\User\Models\User;

class CreatePersonalAreaDTO
{
    public function __construct(

        public readonly User $user,

    ) { }


}
