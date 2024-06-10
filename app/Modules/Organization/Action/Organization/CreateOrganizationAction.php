<?php

namespace App\Modules\Organization\Action\Organization;

use App\Modules\Organization\DTO\CreateOrganizationDTO;
use App\Modules\Organization\Models\Organization;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

use function App\Helpers\Mylog;

class CreateOrganizationAction
{
    public static function run(CreateOrganizationDTO $data) : Organization
    {
        $data = $data->filterNull();

        try {
            $model = Organization::create(
                $data
            );

            //TODO возможно задержка (продумать как избавиться от save т.к может просто возвратить из бд, а мы сохрянем теже данные)
            if(!$model->save()){
                Mylog('Не удалось создать запись для модели Organization.');
                throw new ModelNotFoundException('Не удалось создать пользователя.', 500);
            }

        } catch (\Throwable $th) {
            MyLog('Запись в таблице {Organization} уже существовала');
            throw new ConflictHttpException('данные ИНН уже были раньше зарегистрированы', null , 409);
        }

        return $model;
    }

}
