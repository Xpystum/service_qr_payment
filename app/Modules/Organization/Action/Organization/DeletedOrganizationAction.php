<?php

namespace App\Modules\Organization\Action\Organization;

use App\Modules\Organization\Models\Organization;
use Exception;


use function App\Helpers\Mylog;

class DeletedOrganizationAction
{
    public static function run(string $uuid, int $id) : bool
    {
        try {

            $status = self::FindByUuidAndUser($uuid, $id)->delete();

        } catch (\Throwable $th) {
            MyLog('удаление из таблицы {Organization} выдало ошибку');
            throw new Exception('Ошибка удаление из таблицы {Organization}', 500);
        }

        return ($status > 0) ? true : false;
    }

    private static function FindByUuidAndUser(string $uuid, int $id) : ?Organization
    {
        return Organization::findByUuid($uuid)
                ->where('owner_id', '=', $id)->first();
    }

}
