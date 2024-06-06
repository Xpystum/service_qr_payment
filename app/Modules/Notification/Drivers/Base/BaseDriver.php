<?php

namespace App\Modules\Notification\Drivers\Base;

use App\Modules\Notification\Enums\NotificationDriverEnum;
use App\Modules\Notification\Models\NotificationMethod;
use App\Modules\Notification\Services\NotificationService;

use function App\Helpers\Mylog;

abstract class BaseDriver
{

    protected NotificationDriverEnum $name;
    protected NotificationService $services;

    public function getMethodDriver() : NotificationMethod
    {

        return $this->services->getNotificationMethod()
            ->activeCache()
            ->methodDriver($this->name)
            ->first();



    }

}
