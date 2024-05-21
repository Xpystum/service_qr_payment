<?php

namespace App\Modules\Notification\Action;

use App\Modules\Notification\Enums\NotificationDriverEnum;
use App\Modules\Notification\Services\NotificationService;
use App\Modules\Notification\Traits\ConstructNotifyRepository;

class SetDriverNotificationAction
{
    private $driverService;
    private readonly NotificationService $service;

    public function serviceDriver(?NotificationDriverEnum &$driverService) : static
    {
        $this->driverService = &$driverService;
        return $this;
    }

    public function service(NotificationService $service) : static
    {
        $this->service = $service;
        return $this;
    }

    public function set(NotificationDriverEnum $driverOut)
    {
        $driverIn = $this->service->getDriver($driverOut);
        $this->driverService = $driverIn;

    }

}
