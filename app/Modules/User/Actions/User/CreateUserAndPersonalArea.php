<?php

namespace App\Modules\User\Actions\User;

use App\Modules\User\Actions\PersonalAreas\CreatePersonalArea;
use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\DTO\PersonalArea\CreatePersonalAreaDTO;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function App\Helpers\Mylog;

class CreateUserAndPersonalArea
{
    public static function run(CreatUserDTO $data) : User
    {

        $user = CreatUserAction::run($data);
        $personalArea = CreatePersonalArea::run(
            new CreatePersonalAreaDTO($user),
        );

        if($user && $personalArea)
        {

            return $user;

        } else {
            Mylog("CreateUserAndPersonalArea");
            throw new ModelNotFoundException('Ошибка в action CreateUserAndPersonalArea', 500);
        }

    }

}
