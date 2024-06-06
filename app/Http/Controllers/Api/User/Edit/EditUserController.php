<?php

namespace App\Http\Controllers\Api\User\Edit;
use App\Http\Controllers\Controller;
use App\Modules\User\Actions\User\UpdateUserAction;
use App\Modules\User\DTO\UpdateUserDTO;
use App\Modules\User\Models\User;
use App\Modules\User\Requests\Edit\EditUserRequest;
use App\Modules\User\Resources\UserResource;
use App\Services\Auth\AuthService;

use function App\Helpers\array_success;

class EditUserController extends Controller
{
    public function __construct(
        public AuthService $authService,
    ) {}
    public function __invoke(EditUserRequest $request)
    {
        $validated = $request->validated();

        /**
        * получаем авторизированного user у которого прошла авторизация
        * @var User
        */
        $user = $this->authService->getUserAuthRegister();

        abort_unless((bool) $user, 401, "Пользователь не до конца прошёл регистрацию.");


        $user = UpdateUserAction::run(
            new UpdateUserDTO(

                id: $validated['id'] ?? null,

                email: $validated['email'] ?? null,
                phone: $validated['phone'] ?? null,

                first_name: $validated['first_name'] ?? null,
                last_name: $validated['last_name'] ?? null,
                father_name: $validated['father_name'] ?? null,
            )
        );

        return response()->json(array_success(new UserResource($user) , 'Successfully update information user'), 200);

    }
}
