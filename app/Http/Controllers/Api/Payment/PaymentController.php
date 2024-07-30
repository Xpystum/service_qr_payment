<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\Entity\PaymentEntity;
use App\Modules\Payment\Drivers\Ykassa\Database\Resources\YkassaSpbResoure;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Resources\PaymentResource;
use App\Modules\Payment\Service\PaymentService;
use App\Services\Auth\AuthService;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

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

        //если вдруг у пользователя не выбрал метод оплаты и он попал на эту страницу
        abort_unless($payment->method_id, 404);

        //получаем наш драйвер из сервеса
        $driver = $this->paymentService->getDriver($payment->driver);

        /**
        * запускаем работу нашего драйвера
        * @var PaymentEntity
        */
        $entity = $driver->process($payment);

        return $entity?
        response()->json(array_success( YkassaSpbResoure::make($entity), 'Successfully create spb payment'), 201)
            :
        response()->json(array_error(null, 'Failed create spb payment'), 404);

    }

}
