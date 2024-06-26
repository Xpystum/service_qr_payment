<?php

namespace App\Http\Controllers\Api\Organization\Deleted;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Action\Organization\DeletedOrganizationAction;
use App\Modules\Organization\Requests\DeletedOrganizationRequest;
use App\Modules\User\Models\User;
use App\Traits\TraitAuthService;

use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class OrganizationDeletedController extends Controller
{

    public function __invoke(DeletedOrganizationRequest $request , DeletedOrganizationAction $deletedOrganizationAction)
    {
        $validated = $request->validated();

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $status = $deletedOrganizationAction::run($validated['uuid'], $user->id);

        return $status?
        response()->json(array_success(null , 'Successfully deleted organization'), 200)
            :
        response()->json(array_success(null, 'Failed deleted organization'), 404);
    }
}
