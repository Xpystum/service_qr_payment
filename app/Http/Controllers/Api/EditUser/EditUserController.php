<?php

namespace App\Http\Controllers\Api\EditUser;

use App\Http\Controllers\Controller;
use App\Modules\User\Actions\UpdateUserAction;
use App\Modules\User\DTO\UpdateUserDTO;
use App\Modules\User\Models\User;
use App\Modules\User\Requests\Edit\EditUserRequest;
use App\Modules\User\Resources\UserResource;
use Illuminate\Http\Request;

use function App\Helpers\array_success;

class EditUserController extends Controller
{
    public function __invoke(EditUserRequest $request)
    {
        $validated = $request->validated();


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

        response()->json(array_success(new UserResource($user) , 'Successfully update information user'), 200);

    }
}
