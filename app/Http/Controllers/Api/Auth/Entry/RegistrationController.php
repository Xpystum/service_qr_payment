<?php

namespace App\Http\Controllers\Api\Auth\Entry;
use App\Http\Controllers\Controller;
use App\Modules\User\Requests\Entry\RegistrationRequest;

use App\Modules\User\Action\CreatUserAction;

use App\Modules\User\DTO\CreatUserDto;
use App\Services\Auth\Traits\TraitController;

//для преобразование массива с сообщением
use function App\Helpers\array_success;

class RegistrationController extends Controller
{
    use TraitController;

    public function store(RegistrationRequest $request)
    {

        $validated = $request->validated();

        //выкидываем ошибку - если у нас прислали email и phone вместе
        abort_if( !isset($validated['email']) && !isset($validated['phone']) , 400, 'Only Email or Phone');

        $user = (new CreatUserAction)->run(

            new CreatUserDto(

                email: $validated['email'] ?? null,

                phone: $validated['phone'] ?? null,

                password: $validated['password'],

            )

        );

        abort_unless($user, 500, "Error server");


        $token = $this->authService->loginUser($user);


        return response()->json(array_success($token , 'Successfully registration'), 200);

    }


}
