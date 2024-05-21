<?php

namespace App\Modules\Notification\View\Http\Controllers;

use App\Models\User;
use App\Modules\Notification\DTO\AeroDTO;
use App\Modules\Notification\DTO\Phone\AeroPhoneDTO;
use App\Modules\Notification\DTO\SmtpDTO;
use App\Modules\Notification\Enums\MethodNotificationEnum;
use App\Modules\Notification\Enums\NotificationDriverEnum;
use App\Modules\Notification\Services\NotificationService;
use App\Modules\Notification\Models\NotificationMethod;

use function App\Modules\Notification\Helpers\code;

class NotificationController
{

    protected NotificationService $service;

    public function __construct(NotificationService $service)
    {
        $this->service = $service;
        $this->service->setDriver('aero');
    }

    public function __invoke()
    {


        /**
        * @var User
        */
        $user = User::first();


        /**
        * @var NotificationMethod
        */
        // $modelMethod = $service->getNotificationMethod()
        //             ->activeCache()
        //             ->methodName(MethodNotificationEnum::email)
        //             ->first();


        // $model = $service->createNotification()
        //         ->user($user)
        //         ->method($modelMethod)
        //         ->run();


        // dd($service->sendNotification()
        //     ->dto(new SmtpDTO($user))
        //     ->run());


        // $this->service->updateNotification()->updateCode()->run($user->lastNotify);

        // $this->service->sendNotification()
        //     ->dto(new SmtpDTO($user))
        //     ->run();
        // dd($service->checkNotification()->user($user)->code(339470)->run());

        $this->service->sendNotification()
            ->dto(new AeroDTO(
                $user,
                new AeroPhoneDTO(
                    number: '79200264425',
                    text: 'Тестовый текс на смс',
                ),
            ))
            ->run();

    }
}
