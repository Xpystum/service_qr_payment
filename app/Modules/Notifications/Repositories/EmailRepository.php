<?php

namespace App\Modules\Notifications\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Notifications\Models\Email as Model;
use App\Modules\Notifications\Models\Email;
use App\Modules\User\Models\User;

class EmailRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Проверить code у определённого user
     * @param int $code
     * @param int $userId
     *
     * @return bool
     */
    public function checkCode(int $code, int $userId) : bool
    {

        $status = $this->startConditions()
                    ->where("user_id", $userId)
                    ->where('code', $code)
                    ->first();

        return $status ? true : false;
    }
}
