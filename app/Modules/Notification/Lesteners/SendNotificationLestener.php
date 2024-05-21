<?php

namespace App\Modules\Notification\Lesteners;

use App\Models\User;
use App\Modules\Notification\DTO\AeroDTO;
use App\Modules\Notification\DTO\Config\AeroConfigDTO;
use App\Modules\Notification\Enums\ActiveStatusEnum;
use App\Modules\Notification\Events\SendNotificationEvent;
use App\Modules\Notification\Models\Notification;
use App\Modules\Notification\Notify\SendMessageSmtpNotification;
use App\Modules\Notification\Services\NotificationService;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

#TODO Скорее лучше всего сделать через jobs что бы не мешать логику отправки у драйверов
class SendNotificationLestener //implements ShouldQueue
{

    private $service;

    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }

    #TODO нужно изменить listener и всё сделать в jobs на каждый send() в зависимости от драйвера
    public function handle(SendNotificationEvent $event): void
    {
        switch($event->notifyMethod->name->value)
        {
            case 'email':
            {
                $this->notificationEmail($event);
                break;
            }

            case 'phone':
            {
                $this->notificationPhone($event);
                break;
            }

            default:
            {
                throw new \InvalidArgumentException("Invalid MethodName");
                Log::info("Ошибка выбора Метода нотификации: " . now() . ' ----> ' . __DIR__ );
                break;
            }
        }

    }

    //отправка email
    private function notificationEmail(SendNotificationEvent $event)
    {

        /**
        * @var SmtpDTO $dto
        */
        $dto = $event->dto;
        $user = $dto->user;

        /**
        * @var Notification
        */
        $notifyModel = $user->lastNotify;
        #TODO сделать нотификацию (по методу)

        if($this->existNotificationModelAndComplteted($notifyModel))
        {
            Log::info("зашли в event - где заявка уже выполнена" . now());
            return;
        }


        if($this->existNotificationModelAndPending($notifyModel))
        {
            $status = $this->service->updateNotification()
                ->updateCode()
                ->run($notifyModel);

            !($status) ? Log::info("при обновлении coda в модели Notification произошла ошибка: " . now()) : '' ;

            $notification = new SendMessageSmtpNotification($notifyModel);
            $user->notify($notification);

            return;

        } else {

            /**
            * @var Notification
            */
            $notifyModel = $this->service->createNotification()
            ->user($user)
            ->method($event->notifyMethod)
            ->run();

            $notification = new SendMessageSmtpNotification($notifyModel);
            $user->notify($notification);
        }
    }


    /**
     * Отправка phone по драйверу Aero
     *
     *
     * @param SendNotificationEvent $event
     *
     * @return void
     */
    private function notificationPhone(SendNotificationEvent $event) : void
    {
        #TODO Нужно продумать логику конфига в сервесе
        $config = new AeroConfigDTO(
            email: env('AERO_SMS_EMAIL'),
            apiKey: env('AERO_SMS_APIKEY'),
        );


        $config->checkPropery() ?: throw new InvalidArgumentException(
            "Данные [config AERO] не были или были неправильно заполнены для aero", 500
        );

        /**
        * @var AeroDTO $dto
        */
        $dto = $event->dto;
        $user = $dto->user;

        /**
        * @var Notification
        */
        $notifyModel = $user->lastNotify;

        if($this->existNotificationModelAndComplteted($notifyModel))
        {
            Log::info("зашли в event - где заявка уже выполнена" . now());
            return;
        }

        if($this->existNotificationModelAndPending($notifyModel))
        {
            $status = $this->service->updateNotification()
                ->updateCode()
                ->run($notifyModel);

            !($status) ? Log::info("при обновлении coda в модели Notification произошла ошибка: " . now()) : '' ;


        } else {

            /**
            * @var Notification
            */
            $notifyModel = $this->service->createNotification()
            ->user($user)
            ->method($event->notifyMethod)
            ->run();

        }

        $this->driverLogicAero($config, $dto);

    }

    private function driverLogicAero(AeroConfigDTO $config, AeroDTO $dto)
    {
        $smsAeroMessage = new \SmsAero\SmsAeroMessage($config->email, $config->apiKey);

        $response = $smsAeroMessage->
        send([
            'number' => '79200264425',
            'text' => 'Введите код',
            'sign' => $config->sign
        ]);

    }

    //существует ли уже заявка на подвтреждение в статусе completed
    private function existNotificationModelAndComplteted(Notification $notifyModel)
    {

        if($notifyModel && ActiveStatusEnum::completed->is($notifyModel->status))
        {
            return true;
        }

        return false;

    }

    //существует ли уже заявка на подвтреждение в статусе pending
    private function existNotificationModelAndPending(Notification $notifyModel)
    {

        if($notifyModel && ActiveStatusEnum::pending->is($notifyModel->status))
        {
            return true;
        }

        return false;
    }
}
