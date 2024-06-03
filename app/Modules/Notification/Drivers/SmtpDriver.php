<?php

namespace App\Modules\Notification\Drivers;

use App\Modules\Notification\Drivers\Base\BaseDriver;
use App\Modules\Notification\DTO\Base\BaseDto;
use App\Modules\Notification\DTO\SmtpDto;
use App\Modules\Notification\Enums\NotificationDriverEnum;
use App\Modules\Notification\Events\SendNotificationEvent;
use App\Modules\Notification\Interface\NotificationDriverInterface;
use App\Modules\Notification\Services\NotificationService;

class SmtpDriver extends BaseDriver implements NotificationDriverInterface
{

    public function __construct()
    {
        $this->services = app(NotificationService::class);
        $this->name = NotificationDriverEnum::objectByName('smtp');
    }

    /**
    * @param SmtpDTO $dto
    */
    public function send(BaseDto $dto) : void
    {

        if ($dto instanceof SmtpDTO) {
            event(new SendNotificationEvent($dto, $this->getMethodDriver()));
        } else {
            throw new \InvalidArgumentException("Invalid DTO type");
        }
    }

    public function getNameString() : string
    {
        return $this->name->value;
    }
}
