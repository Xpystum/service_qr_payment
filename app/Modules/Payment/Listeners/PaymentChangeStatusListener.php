<?php

namespace App\Modules\Payment\Listeners;

use App\Modules\Payment\Drivers\Ykassa\App\Events\PaymentCancelEvent;
use App\Modules\Payment\Drivers\Ykassa\Database\Enums\PaymentStatusEnum;
use App\Modules\Payment\Events\BasePaymentStatusEvent;
use App\Modules\Payment\Events\DTO\PaymentStatusData;
use App\Modules\Payment\Events\PaymentCompletedEvent;
use App\Modules\Payment\Events\PaymentWaitingEvent;
use App\Modules\Payment\Repositories\PaymentRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use function App\Helpers\Mylog;

class PaymentChangeStatusListener //implements ShouldQueue
{
    public function handle(BasePaymentStatusEvent $event): void
    {
        switch (get_class($event)) {

            case PaymentWaitingEvent::class:
            {
                $this->PaymentWaitingEvent($event->data);
                break;
            }

            case PaymentCompletedEvent::class:
            {
                $this->PaymentCompletedEvent($event->data);
                break;
            }

            case \App\Modules\Payment\Events\PaymentCancelEvent::class:
            {
                $this->PaymentCancelEvent($event->data);
                break;
            }


            default:
            {
                Mylog('Ошибка во время выполнения события {PaymentChangeStatusListener} не правильный выбор класса.');
                throw new \Exception('Ошибка на стороне сервера', 500);
                break;
            }

        }
    }

    private function PaymentWaitingEvent(PaymentStatusData $data)
    {
        $this->changeStatusPayable($data, PaymentStatusEnum::waiting_for_capture);
    }

    private function PaymentCompletedEvent(PaymentStatusData $data)
    {
        $this->changeStatusPayable($data, PaymentStatusEnum::succeeded);
    }

    private function PaymentCancelEvent(PaymentStatusData $data)
    {
        $this->changeStatusPayable($data, PaymentStatusEnum::canceled);
    }

    private function changeStatusPayable(PaymentStatusData $data, PaymentStatusEnum $status)
    {
        $payableType = $data->payableType;
        $model = $payableType::find($data->payableId);

        if(
            (PaymentStatusEnum::stringToObject($model->status) == PaymentStatusEnum::succeeded) && ($status->isCancelled()) ||
            (PaymentStatusEnum::stringToObject($model->status) == PaymentStatusEnum::canceled) && ($status->isCompleted())
        ) { return; }

        $model->status = $status;

        try {
            $model->save();
        } catch (\Exception $e) {
            Mylog("Ошибка при изменении статуса у {$payableType} - в PaymentChangeStatusListener");
            throw new \Exception('Ошибка при изменении статуса у {$payableType} - в PaymentChangeStatusListener');
        }

    }
}
