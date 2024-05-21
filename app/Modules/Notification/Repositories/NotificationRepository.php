<?php

namespace App\Modules\Notification\Repositories;

use App\Modules\Notification\Models\Notification as Model;
use App\Modules\Notification\Repositories\Base\CoreRepository;


class NotificationRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

   /**
     * Проверить code у определённого user
     * @param int $code
     * @param int $userId
     *
     * @return bool
     */
    public function checkCodeNotification(int $code, int $userId) : bool
    {
        $status = $this->query()
                    ->where("user_id", $userId)
                    ->where('code', $code)
                    ->first();

        return $status ? true : false;
    }

    #TODO сделать на возврат модели notification
    // public function getNotificationLastTime(int $code) : Model
    // {

    //     return $this->query()
    // }

}
