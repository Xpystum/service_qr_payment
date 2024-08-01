<?php

namespace App\Http\Controllers\Api\DriverInfo;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Action\DriverInfo\CreateDriverInfoAction;
use App\Modules\Payment\DTO\DriverInfo\CreateDriverInfoDTO;
use App\Modules\Payment\Models\DriverInfoStorage;
use App\Modules\Payment\Models\PaymentMethod;
use App\Modules\Payment\Repositories\DriverInfoRepository;
use App\Modules\Payment\Repositories\DriverInfoStorageRepository;
use App\Modules\Payment\Requests\DriverInfoCreateRequest;
use App\Modules\Payment\Resources\DriverInfoResource;
use App\Modules\Payment\Resources\DriverInfoStorageResource;
use App\Modules\Payment\Service\PaymentService;
use App\Modules\User\Models\User;

use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

#TODO Вынести DriverInfo в сервес payment
class DriverInfoController extends Controller
{
    #TODO Логика добавление параметров платежки к user сделано через добавение только 1 параметра, нужно продумать массивом + надо ограничить параметры enum
    public function save(
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

            abort_unless( (bool) $payment_method, 404 , 'Метода оплаты не существует, либо не доступен.');
        }

        $status = $actionDriverInfo->run(
            new CreateDriverInfoDTO(
                payment_method:  $payment_method,
                parametr: $validated['parametr'],
                value: $validated['value'],
                user: $user,
            )
        );


        return $status?
        response()->json(array_success(null , 'Successfully save driver info'), 204)
            :
        response()->json(array_success(null, 'Failed save driver info'), 404);
    }

    public function show(PaymentMethod $paymentMethod, DriverInfoRepository $driverInfoRepository)
    {
        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $array = $driverInfoRepository->getDriverInfoTypeId($paymentMethod->id, $user->id);

        return response()->json(array_success(  DriverInfoResource::collection($array), 'Return all info driver by type'), 200);
    }

    public function storage(DriverInfoStorageRepository $driverInfoRepository)
    {
        //получаем все параметры по активным/неактивным платежкам
        $models = $driverInfoRepository->getStorageDriverInfo(true);

        return response()->json(array_success(  DriverInfoStorageResource::make($models), 'Return all info driver by type'), 200);
    }


}
