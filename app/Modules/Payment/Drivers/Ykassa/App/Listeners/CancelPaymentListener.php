<?php
namespace App\Modules\Payment\Drivers\Ykassa\App\Listeners;

use App\Modules\Payment\Drivers\Ykassa\App\Events\PaymentCancelEvent;
use App\Modules\Payment\Drivers\Ykassa\YkassaService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelPaymentListener implements ShouldQueue
{

    public function __construct(

        private YkassaService $ykassaService,

    ) { }


    public function handle(

        PaymentCancelEvent $event,

    ): void {

        //получаем dto платежа юкассы
        $paymentYkassa = $this->ykassaService
            ->FindPayment($event->data->paymentId);

        if(isset($paymentYkassa)){

            //отменяем платеж у юкассы (возврат средств) <- нужно вынести как событие или в job
            $this->ykassaService
            ->CancelPayment($paymentYkassa);

        } else {

            throw new Exception('Ошибка отмены платежа в event y Ykassa');

        }

    }
}
