<?php

namespace App\Http\Controllers\Api\User\Create;

use App\Http\Controllers\Controller;
use App\Modules\User\Actions\User\CreatUserAction;
use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\PersonalAreaRepository;
use App\Modules\User\Requests\Create\CreateUserRequest;
use App\Modules\User\Resources\UserResource;
use App\Services\Auth\AuthService;

use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class UserCreateController extends Controller
{
    public function __construct(public AuthService $authService) {}
    public function __invoke(CreateUserRequest $request, PersonalAreaRepository $personalAreaRepository)
    {
        $validated = $request->validated();

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $personalArea = $personalAreaRepository->getPersonalArea($user);
        abort_unless( (bool) $personalArea , 'Ошибка сервера'  , '500');

        $userCreate = CreatUserAction::run(

            new CreatUserDTO(

                email: $validated['email'] ?? null,

                phone: $validated['phone'] ?? null,

                password: $validated['password'],

                personal_area_id: $personalArea->id,

                role: $validated['type'] ?? throw new \Exception('Не указан тип user', 422),

            )

        );

        abort_unless( (bool) $userCreate , 'Ошибка сервера'  , '500');

        $userResource = new UserResource($userCreate);

        return response()->json(array_success( $userResource, 'Successfully create user'), 200);

    }
}
