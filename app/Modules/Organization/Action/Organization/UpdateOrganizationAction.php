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
        $data = $data->filterNull();
        
        try {
            $status = self::FindByUuidAndUser($data['uuid'], $data['owner_id'])?->updateOrFail(
                $data
            );
        } catch (\Throwable $th) {
            MyLog('Обновление в записе таблице {Organization} уже существовала');
            throw new Exception('Ошибка обновления данных', 500);
        }

        return ($status > 0) ? true : false;
    }

    private static function FindByUuidAndUser(string $uuid, int $id) : ?Organization
    {
        return Organization::findByUuid($uuid)
                ->where('owner_id', '=', $id)->first();
    }

}
