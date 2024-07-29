<?php
namespace App\Modules\Payment\Drivers\Ykassa\App\Actions;

use App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\CreatePaymentData;
use App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\Entity\PaymentEntity;
use App\Modules\Payment\Drivers\Ykassa\Database\Enums\PaymentStatusEnum;

class CreatePaymentAction extends AbstractPaymentAction
{

    public function run(CreatePaymentData $data): PaymentEntity
    {

        try {

            $response = $this->clientSDK->createPayment(

                array(

                    'amount' => array(
                        'value' => $data->value,
                        'currency' => $data->currency,
                    ),


                    'confirmation' => array(
                        'type' => 'redirect',
                        'return_url' => $data->returnUrl,
                    ),

                    'metadata' => array(
                        'order_id' => $data->idempotenceKey
                    ),

                    'capture' => $data->capture,
                    'description' => $data->description,

                ),

                $data->idempotenceKey
            );

        } catch (\Throwable $error) {

            $this->error($error);

        }


        $entity =  new PaymentEntity(

            id: $response->getId(),

            status: PaymentStatusEnum::from($response->getStatus()),

            paid: $response->getPaid(),

            value: $response->getAmount()->getValue(),

            url: $response->getConfirmation()->getConfirmationData(),

            payable_uuid: $response->getMetadata()->order_id

        );

        return $entity;
    }

}
