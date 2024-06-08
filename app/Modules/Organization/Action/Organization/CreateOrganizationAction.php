<?php

namespace App\Modules\Organization\Action\Organization;

use App\Modules\Organization\DTO\CreateOrganizationDTO;
use App\Modules\Organization\Models\Organization;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function App\Helpers\Mylog;

class CreateOrganizationAction
{
    public static function run(CreateOrganizationDTO $data) : Organization
    {
        $data = $data->filterNull();

        $model = Organization::firstOrCreate(
            ['inn' => $data['inn']],
            $data
        );

        //TODO возможно задержка (продумать как избавиться от save т.к может просто возвратить из бд, а мы сохрянем теже данные)
        if(!$model->save()){
            Mylog('Не удалось создать запись для модели Organization.');
            throw new ModelNotFoundException('Не удалось создать пользователя.', 500);
        }


        return $model;
    }

}
