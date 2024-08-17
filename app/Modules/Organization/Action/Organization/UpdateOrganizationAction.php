<?php

namespace App\Modules\Organization\Action\Organization;

use App\Modules\Organization\DTO\UpdateOrganizationDTO;
use App\Modules\Organization\Models\Organization;
use Exception;


use function App\Helpers\Mylog;

class UpdateOrganizationAction
{
    public static function run(UpdateOrganizationDTO $data) : bool
    {
        try {
            $status = Organization::findByUuid($data->uuid)?->updateOrFail($data->toArray());
        } catch (\Throwable $th) {
            MyLog('Обновление в записе таблице {Organization} уже существовала');
            throw new Exception('Ошибка обновления данных', 500);
        }

        return ($status > 0) ? true : false;
    }

}
