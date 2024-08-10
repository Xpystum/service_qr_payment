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
    private ?CreatUserDTO $userDTO = null;

    public function run(CreatUserDTO $data) : User
    {
        $this->userDTO = $data;
        $user = CreatUserAction::run($data);
        dd($user);
        // /**
        // * @var User
        // */
        // $user = CreatUserAction::run($data);

        // /**
        // * @var PersonalArea
        // */
        // $personalArea = CreatePersonalArea::run(
        //     new CreatePersonalAreaDTO($user),
        // );


        // if($user && $personalArea)
        // {
        //     return $user;
        // } else {
        //     Mylog("Ошибка в action CreateUserAndPersonalArea");
        //     throw new ModelNotFoundException('Ошибка сервера.', 500);
        // }

    }

}
