<?php

namespace App\Modules\Notification\Action;

use App\Modules\Notification\Drivers\DriverContextStrategy;
use App\Modules\Notification\DTO\Base\BaseDTO;
use App\Modules\Notification\Enums\NotificationDriverEnum;
use App\Modules\Notification\Interface\NotificationDriverInterface;
use App\Modules\Notification\Services\NotificationService;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;


class SendNotificationAction
{
    private ?string $typeDriver = null;
    private readonly BaseDTO $dto;

    public function __construct(

        public NotificationService $notifyService

    ) { }

    public function typeDriver(string $typeDriver){

        $this->typeDriver = strtolower($typeDriver);

        return $this;
    }

    public function dto(BaseDTO $dto)
    {
        $this->dto = $dto;

        return $this;
    }

    public function run()
    {
        $driver = null;

        if($this->typeDriver == null)
        {
            $driver = $this->notifyService->getDriver()->getNameString();
        } else {
            $driver = $this->typeDriver;
        }

        //использования паттерна стратегии для выбора логики драйвера
        switch($driver){

            case 'smtp':
            {
                $enum = NotificationDriverEnum::objectByName($driver);

                return $this->driverContextStrategy($enum);
                break; // на всякий случай
            }

            case 'aero':
            {
                $enum = NotificationDriverEnum::objectByName($driver);
                return $this->driverContextStrategy($enum);
                break;
            }

            default:
            {
                // throw new \Exception("Unsupported Driver type", 404);
                $error = throw new InvalidArgumentException(
                    "Драйвер [{$this->typeDriver}] не поддерживается", 500
                );

                Log::info($error . now());
                break;
            }

        }
    }

    private function driverContextStrategy(NotificationDriverEnum $enum) : bool
    {
        /**
        * @var NotificationDriverInterface
        */
        $driver = null;
        if($this->notifyService->driverNotNull())
        {
            $driver = $this->notifyService->getDriver();
        } else {
            $driver = $this->notifyService->getDriverFactory($enum);
        }

        $context = new DriverContextStrategy($driver);
        $context->send($this->dto);

        return true;
    }
}
