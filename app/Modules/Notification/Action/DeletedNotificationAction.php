<?php

namespace App\Modules\Notification\Action;

use App\Modules\Notification\Models\Notification;
use Exception;

use function App\Helpers\Mylog;


class DeletedNotificationAction
{
    public static function run(Notification $model) : bool
    {
        if($model->delete()){

            return true;

        } else {

            Mylog('При удалении записи когда количество попыток при проверки кода - закончилось, произошла ошибка.');
            throw new Exception("Ошибка удалении модели" , 500);

        }

    }

}
