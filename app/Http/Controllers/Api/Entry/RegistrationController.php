<?php

namespace App\Http\Controllers\Api\Entry;
use App\Http\Controllers\Controller;
use App\Modules\Notification\Models\Notification;
use App\Modules\Notification\Services\NotificationServiceProvider;
use App\Modules\User\Requests\Entry\RegistrationRequest;

use App\Modules\User\Actions\CreatUserAction;

use App\Modules\User\DTO\CreatUserDto;
use App\Modules\User\Events\UserCreatedEvent;
use App\Traits\TraitAuthService;

//для преобразование массива с сообщением
use function App\Helpers\array_success;

class RegistrationController extends Controller
{
    use TraitAuthService;

    public function store(RegistrationRequest $request, NotificationServiceProvider $serviceNotificaion)
    {
        $validated = $request->validated();

        //выкидываем ошибку - если у нас прислали email и phone вместе
        abort_if( !isset($validated['email']) && !isset($validated['phone']) , 400, 'Only Email or Phone');


        $user = CreatUserAction::run(

            new CreatUserDto(

                email: $validated['email'] ?? null,

                phone: $validated['phone'] ?? null,

                password: $validated['password'],

            )

        );


        abort_unless( (bool) $user, 500, "Error server");


        $token = $this->authService->loginUser($user);

        abort_unless( (bool) $token, 404, "Ошибка получение токена");

        switch ($validated['type'] ?? null) {

            case 'phone':
            {
                break;
            }

            case 'email':
            {
                break;
            }


            default:
            {

            }

                abort( (bool) $token, 404, "Ошибка получение токена");

                break;
        }

        return response()->json(array_success($token , 'Successfully registration'), 200);

    }

}
