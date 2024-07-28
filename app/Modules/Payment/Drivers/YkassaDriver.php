<?php
namespace App\Modules\Payment\Drivers;

use App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\CreatePaymentSpbData;
use App\Modules\Payment\Drivers\Ykassa\YkassaService;
use App\Modules\Payment\Interface\PaymentDriverInterface;
use App\Modules\Payment\Models\Payment;
use App\Modules\User\Models\User;

class YkassaDriver implements PaymentDriverInterface
{
    public function __construct(

        private YkassaService $ykassaService,

    ) { }

    public function view(Payment $payment)
    {
        $ykassaPayment = $this->ykassaService->createPaymentSpb(
            new CreatePaymentSpbData(
                value: $payment->amount->value(), //поменял тут с amount_value на amount т.к у нас нету мультивалютности
                currency: 'RUB', //Указано хардкодом т.к юмани работает только с рублями (зависит от субаккаунта в основном это RU сигмент)
                idempotenceKey: $payment->uuid,
                description: "Транзакция №" . $payment->payable->id,
                payable_name: $payment->payable->getPayableName(),
            )
        );

        dd($ykassaPayment);

        $payment->update(['driver_payment_id' => $ykassaPayment->id]);

        $ykassaPaymentUrl = $ykassaPayment->url;

    }
}
