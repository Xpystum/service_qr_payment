<?php

namespace App\Http\Controllers\Api\User\Deleted;

use App\Http\Controllers\Controller;
use App\Modules\User\Actions\User\DeleteUserAction;
use App\Modules\User\Requests\Delete\DeleteUserRequest;
use App\Traits\TraitAuthService;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class DeletedUserController extends Controller
{

    public function __invoke(DeleteUserRequest $request , DeleteUserAction $deleteUserAction)
    {
        $validated = $request->validated();

        $status = $deleteUserAction->run($validated['uuid']);

        return $status ?
            response()->json(array_success('Successfully deleted user'), 200)
        :
            response()->json(array_error('Failed deleted user'), 404);
    }
}
