<?php

namespace App\Modules\Payment\Action\Handler;
use App\Modules\Payment\DTO\CreatePaymentDTO;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Service\PaymentService;

class CreatePaymentHandler
{
    public function handle(CreatePaymentDTO $data) : ?Payment
    {
        $paymentService = app(PaymentService::class);
        //создаём платежку и привязываем к (payble) (Транзакция, заказ и т.д)
        $payment = $paymentService->createPayment()->payable($data->transaction)
            ->run();

        //получаем модель метода по заданному параметру в запросе
        $method = $paymentService->getPaymentMethods()
                    ->active(true)
                    ->id($data->method_id)
                    ->first();


        //обновляем данные оплаты (указываем методы оплаты QR -> Youkassa, Банк Точка)
        $updatePayment = $paymentService->updatePayment()
            ->method($method)
            ->run($payment);

        abort_unless($updatePayment , 'Ошибка на сервере.' , 500);

        //обновляем что бы получить акутальные данные модели
        $payment->refresh();

        return $payment;
    }

    public static function make() : self
    {
        return new self();
    }
}
