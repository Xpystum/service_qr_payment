<?php
namespace App\Modules\Payment\Drivers\Ykassa\App\Actions;


use App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\CreatePaymentSpbData;
use App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\Entity\PaymentEntity;
use App\Modules\Payment\Drivers\Ykassa\App\Exceptions\YkassaExceptions;
use App\Modules\Payment\Drivers\Ykassa\Database\Enums\PaymentStatusEnum;


use function App\Helpers\Mylog;

class CreatePaymentSpbAction extends AbstractPaymentAction
{

    public function run(CreatePaymentSpbData $data): PaymentEntity
    {

        try {

            $response = $this->clientSDK->createPayment(

                array(

                    'amount' => array(
                        'value' => $data->value,
                        'currency' => $data->currency,
                    ),

                    'payment_method_data' => array(
                        'type' => 'sbp',
                    ),
                    'confirmation' => array(
                        'type' => 'qr',
                    ),

                    'metadata' => array(
                        'payable_uuid' => $data->idempotenceKey,
                        'payable_type' => $data->payable_name,
                    ),

                    'capture' => true, // по документации при получении spb

                    'description' => $data->description,

                ),

                $data->idempotenceKey
            );


        } catch (\Throwable $error) {

            Mylog('Ошибка при создании {Payment} в Ykassa: ' . $error);
            throw new YkassaExceptions('Ошибка на стороне сервера при попытке создания платежа', 500);

        }


        return new PaymentEntity(

            id: $response->getId(),

            status: PaymentStatusEnum::from($response->getStatus()),

            paid: $response->getPaid(),

            value: $response->getAmount()->getValue(),

            url: $response->getConfirmation()->getConfirmationUrl(),

            payable_uuid: $response->getMetadata()->payable_uuid

        );

    }

}
