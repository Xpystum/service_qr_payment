<?php

namespace App\Modules\User\Actions\Handler;

use App\Modules\User\Models\User;

class CreateUserHandler
{
    public function handle() : User
    {
        /**
        * @var User
        */
        $user = CreatUserAction::run($data);

        /**
        * @var PersonalArea
        */
        $personalArea = CreatePersonalArea::run(
            new CreatePersonalAreaDTO($user),
        );


        if($user && $personalArea)
        {
            return $user;
        } else {
            Mylog("Ошибка в action CreateUserAndPersonalArea");
            throw new ModelNotFoundException('Ошибка сервера.', 500);
        }
    }
}
