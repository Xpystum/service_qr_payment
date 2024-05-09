<?php

namespace App\Modules\Notifications\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Notifications\Enums\ActiveStatusEnum;
use App\Modules\Notifications\Models\Email as Model;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Collection;


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

    /**
     * Проверить code у определённого user
     * @param int $code
     * @param int $userId
     *
     * @return bool
     */
    public function returnEmailPending(Collection $emails) : ?Model
    {

        foreach($emails as $email)
        {
           if( $email->status->is(ActiveStatusEnum::pending) )
           {
                return $email;
           }
        }

        return null;
    }
}
