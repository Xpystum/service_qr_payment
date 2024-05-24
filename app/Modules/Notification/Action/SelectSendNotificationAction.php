<?php

namespace App\Modules\Notification\Action;

use App\Modules\Notification\DTO\SmtpDTO;
use App\Modules\Notification\Enums\MethodNotificationEnum;
use App\Modules\Notification\Services\NotificationService;

class SelectSendNotificationAction
{
    public function __construct(

        public NotificationService $notifyService

    ) { }
    public static function run(MethodNotificationEnum|string $type)
    {
        if(self::isMethodNotificationEnum($type)) { $type = $type->fromObjectToString();  }
        switch($type)
        {
            case 'phone':
            {
                self::$notifyService->sendNotification()
                    ->typeDriver('smtp')
                    ->dto(SmtpDTO::class)
                    -run();;


                break;
            }

            case 'email':
            {

                break;
            }
        }
    }

    private static function isMethodNotificationEnum(MethodNotificationEnum|string $type) : bool
    {
        return ($type instanceof MethodNotificationEnum) ? true : false;
    }
}
