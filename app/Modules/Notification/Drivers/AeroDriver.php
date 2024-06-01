<?php

namespace App\Modules\Notification\Drivers;

use App\Modules\Notification\Drivers\Base\BaseDriver;
use App\Modules\Notification\DTO\AeroDTO;
use App\Modules\Notification\DTO\Base\BaseDto;
use App\Modules\Notification\DTO\Config\AeroConfigDTO;
use App\Modules\Notification\Enums\NotificationDriverEnum;
use App\Modules\Notification\Events\SendNotificationEvent;
use App\Modules\Notification\Interface\NotificationDriverInterface;
use App\Modules\Notification\Services\NotificationService;

class AeroDriver extends BaseDriver implements NotificationDriverInterface
{

    private AeroConfigDTO $config;
    #TODO вынести в базовый класс и продумать как создавать драйвер уже со своим именем драйвера 'aero', 'smtp' и т.д
    public function __construct()
    {
        $this->services = app(NotificationService::class);
        $this->name = NotificationDriverEnum::objectByName('aero');

    }

    /**
    * @param AeroDTO $dto
    */
    public function send(BaseDto $dto) : void
    {
        if ($dto instanceof AeroDTO) {
            event(new SendNotificationEvent($dto, $this->getMethodDriver()));
            return;
        }
        throw new \InvalidArgumentException("Invalid DTO type");
    }

    public function getNameString() : string
    {
        return $this->name->value;
    }
}
