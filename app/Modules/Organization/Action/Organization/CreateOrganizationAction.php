<?php

namespace App\Modules\User\Actions\User;

use App\Modules\Organization\Models\Organization;
use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\Enums\RoleUserEnum;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateOrganizationAction
{
    public static function run(CreatUserDTO $data) : Organization
    {

    }

}
