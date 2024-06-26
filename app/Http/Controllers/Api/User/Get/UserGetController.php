<?php

namespace App\Http\Controllers\Api\User\Get;

use App\Http\Controllers\Controller;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\UserRepository;
use App\Modules\User\Resources\UserResource;
use App\Traits\TraitAuthService;

use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class UserGetController extends Controller
{

    /**
     * Вернуть всех user которые принадлежат user:admin
     * @return [type]
     */
    public function all(UserRepository $userRepository)
    {
        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $users = $userRepository->getAssocialUser($user);

        #TODO Добавить ресурс возврата user (не полностью)
        return response()->json(array_success( UserResource::collection($users), 'Successfully return users associal user:admin'), 200);
    }

}
