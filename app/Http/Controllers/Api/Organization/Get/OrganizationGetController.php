<?php

namespace App\Http\Controllers\Api\Organization\Get;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Repositories\OrganizationRepositories;
use App\Modules\Organization\Resources\OrganizationResource;
use App\Modules\User\Models\User;

use App\Traits\TraitAuthService;

use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class OrganizationGetController extends Controller
{

    public function getAll(OrganizationRepositories $organizationRepositories)
    {
        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $arrayOrganization = $organizationRepositories->getOrganization($user);

        return response()->json(array_success(OrganizationResource::collection($arrayOrganization), 'Get all child organizations of the user'), 200);
    }
}
