<?php

namespace App\Modules\Payment\Drivers\Ykassa\App\Actions;

use App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\Entity\PaymentEntity;
use App\Modules\Payment\Drivers\Ykassa\Database\Enums\PaymentStatusEnum;

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

            url: $response?->getConfirmation()?->getConfirmationData(),

            payable_uuid: $response->getMetadata()->order_id

        );

    }

}
