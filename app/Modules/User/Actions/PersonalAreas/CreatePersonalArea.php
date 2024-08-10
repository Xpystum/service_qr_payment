<?php

namespace App\Modules\User\Actions\PersonalAreas;
use App\Modules\User\DTO\PersonalArea\CreatePersonalAreaDTO;
use App\Modules\User\Models\PersonalArea;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function App\Helpers\Mylog;

class CreatePersonalArea
{
    public static function run(CreatePersonalAreaDTO $data) : ?PersonalArea
    {
        /**
        * @var RoleUserEnum
        */
        $enum = $data->user->role;

        if($enum->isAdmin())
        {
            $personalArea = PersonalArea::create(
                [
                    'owner_id' => $data->user->id,
                ]
            );

        } else {

            return null;

        }



        if(!$personalArea->save()){
            Mylog("Не удалось создать запись изменение пароля в таблице {PersonalArea} у User");
            throw new ModelNotFoundException('Не удалось создать запись password.', 500);
        }

        return $personalArea;
    }

}
