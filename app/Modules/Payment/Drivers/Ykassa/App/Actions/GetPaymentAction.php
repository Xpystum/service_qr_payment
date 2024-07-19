<?php

namespace App\Modules\Payment\Drivers\Ykassa\App\Actions;

class GetPaymentAction extends AbstractPaymentAction
{

    public function run(string $paymentId): PaymentEntity
    {

        try {

            $response = $this->clientSDK->getPaymentInfo($paymentId);

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
