<?php

namespace App\Http\Controllers\Api\Entry;
use App\Http\Controllers\Controller;
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

    public function store(RegistrationRequest $request)
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


        abort_unless($user, 500, "Error server");

        $token = $this->authService->loginUser($user);

        abort_unless($token, 404, "Ошибка получение токена");

        //Вызываем событие отправки кода на почту
        event(new UserCreatedEvent($user));

        return response()->json(array_success($token , 'Successfully registration'), 200);

    }


}
