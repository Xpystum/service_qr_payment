<?php

namespace App\Http\Controllers\Api\Entry;
use App\Http\Controllers\Controller;
use App\Modules\Notification\DTO\PhoneOrEmailDTO;
use App\Modules\Notification\Services\NotificationService;
use App\Modules\User\Actions\User\CreateUserAndPersonalArea;
use App\Modules\User\Requests\Entry\RegistrationRequest;


use App\Modules\User\DTO\CreatUserDTO;
use App\Traits\TraitAuthService;

//для преобразование массива с сообщением
use function App\Helpers\array_success;

class RegistrationController extends Controller
{
    use TraitAuthService;

    public function store(RegistrationRequest $request, NotificationService $serviceNotificaion)
    {

        $validated = $request->validated();

        //выкидываем ошибку - если у нас прислали email и phone вместе
        abort_if( !isset($validated['email']) && !isset($validated['phone']) , 400, 'Only Email or Phone');

        $user = CreateUserAndPersonalArea::run(

            new CreatUserDTO(

                email: $validated['email'] ?? null,

                phone: $validated['phone'] ?? null,

                password: $validated['password'],

            )

        );

        abort_unless( (bool) $user, 500, "Error server");

        $token = $this->authService->loginUser($user);

        abort_unless( (bool) $token, 401, "Ошибка получение токена");

        $serviceNotificaion->selectSendNotification()
        ->run(
            new PhoneOrEmailDTO($validated['email'] ?? null, $validated['phone'] ?? null),
            $user,
        );

        return response()->json(array_success($token , 'Successfully registration'), 200);

    }

}
