<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Drivers\Ykassa\YkassaConfig;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Resources\PaymentResource;
use App\Modules\Payment\Service\PaymentService;
use App\Modules\User\Models\User;
use App\Services\Auth\AuthService;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class PaymentController extends Controller
{
    private PaymentService $paymentService;

    public function boot() {
        $this->paymentService = app(PaymentService::class); // Получаем экземпляр сервиса
    }

    public function checkout()
    {
        //получаем все методы оплаты со статусом active
        $paymentMethods = $this->paymentService
                    ->getPaymentMethods()
                    ->active(true)
                    ->get();

        return response()->json(array_success( $paymentMethods, 'Return all active payment methods'), 200);
    }


    public function show(Payment $payment)
    {
        return response()->json(array_success( PaymentResource::make($payment), 'Show payment by uuid'), 200);
    }

    public function process(Payment $payment)
    {
        // $driver = $this->paymentService->getDriver($payment->driver);

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        new YkassaConfig($user);

    }

}
