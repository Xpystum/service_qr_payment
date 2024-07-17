<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Resources\PaymentResource;
use App\Modules\Payment\Service\PaymentService;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class PaymentController extends Controller
{

    public function checkout(PaymentService $paymentService)
    {
        //получаем все методы оплаты со статусом active
        $paymentMethods = $paymentService
                    ->getPaymentMethods()
                    ->active(true)
                    ->get();

        return response()->json(array_success( $paymentMethods, 'Return all active payment methods'), 200);
    }


    public function show(Payment $payment)
    {
        return response()->json(array_success( PaymentResource::make($payment), 'Show payment by uuid'), 200);
    }

}
