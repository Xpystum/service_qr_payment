<?php

namespace App\Modules\Notification\Action;

use App\Modules\Base\Enums\ActiveStatusEnum;
use App\Modules\Notification\Models\Notification;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Возвращает все notification по user и pending
 */
class ReturnAllNotificationByUserAndPendingAction
{

    public  static function run(User $user): Collection
    {
        return Notification::where('user_id', '=' , $user->id)
            ->where('status' , '=' , ActiveStatusEnum::pending)
            ->get();
    }

}
