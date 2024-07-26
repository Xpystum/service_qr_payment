<?php
namespace App\Modules\Payment\Drivers\Ykassa;

use App\Modules\Payment\Drivers\Ykassa\App\Actions\CancelPaymentAction;
use App\Modules\Payment\Drivers\Ykassa\App\Actions\CheckCallbackAction;
use App\Modules\Payment\Drivers\Ykassa\App\Actions\CreatePaymentAction;
use App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\CreatePaymentData;
use App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\Entity\PaymentEntity;
use App\Modules\Payment\Drivers\Ykassa\App\Actions\GetPaymentAction;
use App\Modules\User\Models\User;
use YooKassa\Client;


class YkassaService
{
    private Client|null $clientSDK = null; //Делать ли это singleton?
    private YkassaConfig $config;

    public function __construct(User $user) {
        //создаём экземпляр класса SKD Ykassa
        $this->clientSDK = app(Client::class);
        $this->config = new YkassaConfig($user);
    }

    public function getClientSdk() : Client
    {
        return $this->clientSDK;
    }

    public function createPayment(CreatePaymentData $data): PaymentEntity
    {
        //make используется что бы не создавать тут через new
        return CreatePaymentAction::make($this)->run($data);
    }

    public function FindPayment(string $paymentId) : PaymentEntity
    {

        return GetPaymentAction::make($this)->run($paymentId);

    }


    //отмена платежа только в состоянии waiting_for_capture
    public function CancelPayment(PaymentEntity $PaymentEntity) : ?PaymentEntity
    {
        //отмена платежа в состоянии waiting_for_capture
        return CancelPaymentAction::make($this)->run($PaymentEntity);

    }

    public function checkCallback(array $data) : PaymentEntity
    {
        return CheckCallbackAction::make($this)->run($data);
    }

}
