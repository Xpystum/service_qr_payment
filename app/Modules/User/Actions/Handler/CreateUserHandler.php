<?php

namespace App\Modules\User\Actions\Handler;

use App\Modules\User\Actions\PersonalAreas\CreatePersonalArea;
use App\Modules\User\Actions\User\CreatUserAction;
use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function App\Helpers\Mylog;

class CreateUserHandler
{
    public function handle(CreatUserDTO $userDTO) : ?User
    {
        $userHandler = CreatUserAction::make();
        $areaHandler = CreatePersonalArea::make();

        $userHandler->setNext($areaHandler);
        $userHandler->handle($userDTO);

        $user = $userHandler->getUser();

        if(!$user)
        {
            Mylog("Ошибка в hanlder CreateUserHandler");
            throw new ModelNotFoundException('Ошибка сервера.', 500);
        }

        return $user;
    }

    // попытка сделать работу через функцию....
    // public function setHandler(array $array, $data)
    // {
    //     $handlerArray = [];

    //     foreach ($array as $className) {
    //         dd($className);
    //         dd(class_exists($className));
    //         if (class_exists($className)) {

    //             $instance = $className::make();
    //             $handlerArray[] = $instance;

    //         } else {

    //             Mylog("Ошибка в hanlder - ошибка в названии класса Action");
    //             throw new ModelNotFoundException('Ошибка сервера.', 500);

    //         }
    //     }

    //     foreach ($handlerArray as $index => $value) {
    //         if(isset($handlerArray[$index+1]))
    //         {
    //             $value->setNext($handlerArray[$index+1]);
    //         }
    //     }

    //     $status = $handlerArray[0]->handler($data);

    //     dd($status);

    // }
}
