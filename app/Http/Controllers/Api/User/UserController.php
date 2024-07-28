<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Modules\User\Actions\User\CreatUserAction;
use App\Modules\User\Actions\User\DeleteUserAction;
use App\Modules\User\Actions\User\UpdateUserAction;
use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\DTO\UpdateUserDTO;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\PersonalAreaRepository;
use App\Modules\User\Repositories\UserRepository;
use App\Modules\User\Requests\Create\CreateUserRequest;
use App\Modules\User\Requests\Delete\DeleteUserRequest;
use App\Modules\User\Requests\Edit\EditUserRequest;
use App\Modules\User\Resources\UserResource;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class UserController extends Controller
{

    /**
     * Вернуть всех user которые принадлежат user:admin
     * @return [type]
     */
    public function index(UserRepository $userRepository)
    {
        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $users = $userRepository->getAssocialUser($user);

        #TODO Добавить ресурс возврата user (не полностью)
        return response()->json(array_success( UserResource::collection($users), 'Successfully return users associal user:admin'), 200);
    }
    /**
     * Создание user от admin, manager/cashier
     *
     * @param CreateUserRequest $request
     * @param PersonalAreaRepository $personalAreaRepository
     *
     * @return \Response
     */
    public function create(CreateUserRequest $request, PersonalAreaRepository $personalAreaRepository)
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
    public function update(EditUserRequest $request)
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
    public function delete(DeleteUserRequest $request, DeleteUserAction $deleteUserAction)
    {
        $validated = $request->validated();

        $status = $deleteUserAction->run($validated['uuid']);

        return $status ?
            response()->json(array_success('Successfully deleted user'), 200)
        :
            response()->json(array_error('Failed deleted user'), 404);
    }
}
