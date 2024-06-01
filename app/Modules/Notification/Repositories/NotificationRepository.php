<?php

namespace App\Modules\Notification\Repositories;

use App\Modules\Base\Enums\ActiveStatusEnum;
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
    public function checkCodeNotification(int $code, int $userId) : Model
    {
        $model = $this->query()
                    ->where("user_id", $userId)
                    ->where('code', $code)
                    ->first();

        return $model;
    }

    public function isStatusCompleted(Model $notification) : bool
    {
        if($notification->status == ActiveStatusEnum::completed)
        {
            return true;
        }
        return false;
    }

    public function isStatusExpired(Model $notification) : bool
    {

        if($notification->status == ActiveStatusEnum::expired)
        {
            return true;
        }
        return false;
    }

    public function isStatusPending(Model $notification) : bool
    {
        if($notification->status == ActiveStatusEnum::pending)
        {
            return true;
        }
        return false;
    }

}
