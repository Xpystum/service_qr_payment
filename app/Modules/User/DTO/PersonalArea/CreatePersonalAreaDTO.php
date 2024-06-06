<?php
namespace App\Modules\User\DTO\PersonalArea;
use App\Modules\User\Models\User;
use Illuminate\Contracts\Support\Arrayable;

class CreatePersonalAreaDTO
{
    public function __construct(

        public readonly User $user,

    ) { }


}
