<?php

namespace App\Http\Controllers\Api\Payment\Get;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Repositories\PaymentRepository;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class PaymentGetController extends Controller
{
    public function __invoke(Payment $payment, PaymentRepository $repository)
    {
        $payment = $repository->getPayment($payment);

        return $payment?
        response()->json(array_success( $payment, 'Successfully return payment'), 200)
        :
        response()->json(array_error(null, 'Failed return payment for uuid'), 404);
    }
}
