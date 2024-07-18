<?php

namespace App\Http\Controllers\Api\DriverInfo;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Action\DriverInfo\CreateDriverInfoAction;
use App\Modules\Payment\DTO\DriverInfo\CreateDriverInfoDTO;
use App\Modules\Payment\Repositories\PaymentMethodRepository;
use App\Modules\Payment\Requests\DriverInfoCreateRequest;
use App\Modules\Payment\Service\PaymentService;
use App\Modules\User\Models\User;

use function App\Helpers\isAuthorized;

class DriverInfoController extends Controller
{
    public function create(
        DriverInfoCreateRequest $request,
        CreateDriverInfoAction $actionDriverInfo,
        PaymentService $paymentService
    ) {

        $validated = $request->validated();

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        {
            //получаем метод по id + проверяем на активность
            $payment_method = $paymentService->getPaymentMethods()
                ->id($validated['type_id'])
                ->active(true)
                ->first();

            abort_unless( (bool) $payment_method, 'Метод оплаты не существует, либо не доступен.', 404);
        }

        $status = $actionDriverInfo->run(
            new CreateDriverInfoDTO(
                payment_method:  $payment_method,
                parametr: $validated['parametr'],
                value: $validated['value'],
                user: $user,
            )
        );


        dd($status);
    }
}
