<?php

namespace App\Modules\Notification\Drivers;

use App\Modules\Notification\DTO\Base\BaseDto;
use App\Modules\Notification\Interface\NotificationDriverInterface;

class DriverContextStrategy
{
    private $strategy;

    public function __construct(NotificationDriverInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(NotificationDriverInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function send(BaseDto $dto) : void
    {
        $this->strategy->send($dto);
    }
}
