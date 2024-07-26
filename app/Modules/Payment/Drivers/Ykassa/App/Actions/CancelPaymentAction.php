<?php
namespace App\Modules\Payment\Drivers\Ykassa\App\Actions;

use App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\Entity\PaymentEntity;
use App\Modules\Payment\Drivers\Ykassa\Database\Enums\PaymentStatusEnum;

class CancelPaymentAction extends AbstractPaymentAction
{
    //Платеж можно отменить если он находится в состоянии waiting_for_capture
    public function run(PaymentEntity $PaymentEntity): ?PaymentEntity
    {

        try {

            if($PaymentEntity->status === PaymentStatusEnum::waiting_for_capture)
            {

                $response = $this->clientSDK->cancelPayment(
                    $PaymentEntity->id,
                    $PaymentEntity->order_uuid,
                );

            }else{

                return null;
            }

        } catch (\Throwable $error) {

            $this->error($error);
        }


        return new PaymentEntity(

            id: $response->getId(),

            status: PaymentStatusEnum::from($response->getStatus()),

            paid: $response->getPaid(),

            value: $response->getAmount()->getValue(),

            url: $response?->getConfirmation()?->getConfirmationUrl(),

            order_uuid: $response->getMetadata()->order_id

        );

    }

}
