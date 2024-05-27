<?php

namespace App\Modules\Notification\Action;

use App\Modules\Notification\DTO\AeroDTO;
use App\Modules\Notification\DTO\Phone\AeroPhoneDTO;
use App\Modules\Notification\DTO\PhoneOrEmailDTO;
use App\Modules\Notification\DTO\SmtpDTO;
use App\Modules\Notification\Enums\MethodNotificationEnum;
use App\Modules\Notification\Services\NotificationService;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Log;

use function App\Helpers\Mylog;
use function App\Modules\Notification\Helpers\code;

class SelectSendNotificationAction
{
    public function __construct(
        public NotificationService $notifyService,
    ) { }

    public function run(PhoneOrEmailDTO $dto, User $user)
    {
        // MethodNotificationEnum|string $type,
        // if(self::isMethodNotificationEnum($type)) { $type = $type->fromObjectToString();  }

        $stringData = $dto->email ? 'email' : ($dto->phone ? 'phone' : null);

        switch($stringData)
        {

            case 'phone':
            {

                $text = "Введите ваш код подтрвеждение: ";
                $dtoFriver = new AeroDTO(
                    $user,
                    new AeroPhoneDTO($dto->phone, $text)
                );

                $this->notifyService
                    ->sendNotification()
                    ->typeDriver('aero')
                    ->dto($dtoFriver)
                    ->run();

                break;
            }

            case 'email':
            {
                $dtoFriver = new SmtpDTO($user);

                $this->notifyService
                    ->sendNotification()
                    ->typeDriver('smtp')
                    ->dto($dtoFriver)
                    ->run();
                break;
            }

            default:
            {
                Log::info("Invalid driver type | " . now() . ' ' . __DIR__);
                throw new \InvalidArgumentException("Invalid case type notification", 500);
            }
        }
    }

    private function isMethodNotificationEnum(MethodNotificationEnum|string $type) : bool
    {
        return ($type instanceof MethodNotificationEnum) ? true : false;
    }
}
