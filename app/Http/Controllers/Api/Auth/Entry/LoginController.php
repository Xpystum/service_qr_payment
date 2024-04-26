<?php


namespace App\Http\Controllers\Api\Auth\Entry;

use App\Http\Controllers\Controller;
use App\Modules\User\Requests\Entry\LoginRequest;
use App\Services\Auth\DTO\UserAttemptDTO;
use App\Services\Auth\Traits\TraitController;


//для преобразование массива с сообщением
use function App\Helpers\array_success;

class LoginController extends Controller
{
    use TraitController;

    public function store(LoginRequest $request)
    {
        $validated = $request->validated();

        //выкидываем ошибку - если у нас прислали email и phone вместе
        abort_if( !isset($validated['email']) && !isset($validated['phone']) , 400, 'Only Email or Phone');

        $json_token = $this->authService->attemptUserAuth(
            new UserAttemptDTO(
                email: $validated['email'] ?? null,
                phone: $validated['phone'] ?? null,
                password: $validated['password'],
            )
        );

        abort_unless($json_token, 404, "Ошибка поиска User - Bad Request" );

        return response()->json(array_success($json_token, 'Successfully login'), 200);
    }
}
