<?php
namespace App\Http\Controllers\Api\Callback;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Payment\Drivers\Ykassa\Database\Enums\PaymentStatusEnum;
use App\Modules\Payment\Drivers\Ykassa\YkassaService;
use App\Modules\Payment\Service\PaymentService;

class YkassaCallbackController extends Controller
{
    public function callback(

        Request $request,
        PaymentService $paymentService,
        YkassaService $ykassaService,

    ) {

        try {


            $entity = $ykassaService->checkCallback($request->all());
            $payment = $paymentService
                ->getPayments()
                ->uuid($entity->payable_uuid)
                ->first();


            match ($entity->status)
            {

                PaymentStatusEnum::waiting_for_capture => $paymentService->waitingPayment()->run($payment),

                PaymentStatusEnum::succeeded  => $paymentService->completePayment()->run($payment),

                PaymentStatusEnum::canceled => $paymentService->cancelPayment()->run($payment),

                default => null,

            };

        } catch (\Throwable $error) {

            report($error);
            return response('Something went wrong', 400);

        }

        //по API SDK YKASSA нам нужно отправить ответ, что мы получили уведомление.
        return response('OK', 200);

    }
}
