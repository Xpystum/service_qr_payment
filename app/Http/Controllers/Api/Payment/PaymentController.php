<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Resources\PaymentResource;
use App\Modules\Payment\Service\PaymentService;
use App\Modules\User\Models\User;
use App\Services\Auth\AuthService;

use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class PaymentController extends Controller
{
    public PaymentService $paymentService;
    public function __construct(AuthService $authService, PaymentService $paymentService)
    {
        $this->authService = $authService;
        $this->paymentService = $paymentService;
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

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);


        //если вдруг у пользователя не выбрал метод оплаты и он попал на эту страницу
        abort_unless($payment->method_id, 404);

        //получаем наш драйвер из сервеса
        $driver = $this->paymentService->getDriver($payment->driver);

        //запускаем работу нашего драйвера
        $driver->view($payment);

    }

}
