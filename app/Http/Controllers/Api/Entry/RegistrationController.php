<?php

namespace App\Http\Controllers\Api\Entry;
use App\Http\Controllers\Controller;
use App\Modules\Notification\DTO\PhoneOrEmailDTO;
use App\Modules\Notification\Services\NotificationService;
use App\Modules\User\Actions\Handler\CreateUserHandler;
use App\Modules\User\Actions\User\CreateUserAndPersonalArea;
use App\Modules\User\Requests\Entry\RegistrationRequest;

use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\DTO\ValueObject\User\UserVO;

//для преобразование массива с сообщением
use function App\Helpers\array_success;

class RegistrationController extends Controller
{

    public function store(RegistrationRequest $request, NotificationService $serviceNotificaion, CreateUserHandler $handle)
    {
        /**
        * @var UserVO
        */
        $UserVO = $request->getValueObject();

        $user = $handle->handle(CreatUserDTO::make($UserVO));

        dd('controller');

        abort_unless( (bool) $user, 500, "Error server");

        $token = $this->authService->loginUser($user);

        abort_unless( (bool) $token, 401, "Ошибка получение токена");

        $serviceNotificaion->selectSendNotification()
        ->run(
            new PhoneOrEmailDTO(
                email: ($UserVO->email ?? null),
                phone: ($UserVO->phone ?? null),
            ),
            $user,
        );


        return response()->json(array_success($token , 'Successfully registration'), 200);

    }

}
