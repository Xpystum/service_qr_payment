<?php

namespace App\Modules\User\Actions\Handler;

use App\Modules\User\Actions\PersonalAreas\CreatePersonalArea;
use App\Modules\User\Actions\User\CreatUserAction;
use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\Models\User;

class CreateUserHandler
{
    public function handle(CreatUserDTO $userDTO) : User
    {

        $userHandler = CreatUserAction::make();
        $areaHandler = CreatePersonalArea::make();

        $userHandler->setNext($areaHandler);
        $userHandler->handle($userDTO);

        dd(1);

        // if($user && $personalArea)
        // {
        //     return $user;
        // } else {
        //     Mylog("Ошибка в action CreateUserAndPersonalArea");
        //     throw new ModelNotFoundException('Ошибка сервера.', 500);
        // }
    }
}
