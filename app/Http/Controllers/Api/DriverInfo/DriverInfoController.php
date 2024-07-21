<?php

namespace App\Http\Controllers\Api\DriverInfo;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Action\DriverInfo\CreateDriverInfoAction;
use App\Modules\Payment\DTO\DriverInfo\CreateDriverInfoDTO;
use App\Modules\Payment\Enums\DriverInfo\DriverInfoStorageEnum;
use App\Modules\Payment\Enums\PaymentDriverEnum;
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
    public function save(
        DriverInfoCreateRequest $request,
        CreateDriverInfoAction $actionDriverInfo,
        PaymentService $paymentService
    ) {

        $model = DriverInfoStorage::first();

        dd($model->parametr_name);

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
        response()->json(array_success(null , 'Successfully save driver info'), 201)
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

        $mo = [

            new class {
                public $name = 'John';
                public $age = 30;

                public function introduce() {
                    return "Hi, I'm $this->name and I'm $this->age years old.";
                }
            },
        ];
        dd(

        )

        //получаем все параметры по активным/неактивным платежкам
        $models = $driverInfoRepository->getStorageDriverInfo(true);

        return response()->json(array_success(  DriverInfoStorageResource::make($models), 'Return all info driver by type'), 200);
    }


}
