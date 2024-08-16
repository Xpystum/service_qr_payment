<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Action\Organization\CreateOrganizationAction;
use App\Modules\Organization\Action\Organization\DeletedOrganizationAction;
use App\Modules\Organization\Action\Organization\UpdateOrganizationAction;
use App\Modules\Organization\DTO\CreateOrganizationDTO;
use App\Modules\Organization\DTO\UpdateOrganizationDTO;
use App\Modules\Organization\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\Enums\TypeOrganizationEnum;
use App\Modules\Organization\Models\Organization;
use App\Modules\Organization\Repositories\OrganizationRepositories;
use App\Modules\Organization\Requests\CreteOrganizationRequest;
use App\Modules\Organization\Requests\UpdateOrganizationRequest;
use App\Modules\Organization\Resources\OrganizationResource;
use App\Modules\User\Models\User;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;
class OrganizationController extends Controller
{

    /**
     * Вернуть все организации которые принадлежат user:admin
     * @param OrganizationRepositories $organizationRepositories
     *
     * @return [type]
     */
    public function index(OrganizationRepositories $organizationRepositories)
    {
        /**
        * @var User
        */
        $user = isAuthorized($this->authService);


        $arrayOrganization = $organizationRepositories->getOrganization($user);


        return response()->json(array_success(OrganizationResource::collection($arrayOrganization), 'Get all child organizations of the user'), 200);
    }

    public function show(Organization $organization)
    {
        return response()->json(array_success( OrganizationResource::make($organization), 'Return organization'), 200);
    }

    public function create(CreteOrganizationRequest $request, CreateOrganizationAction $createOrganizationAction)
    {
        /**
        * @var OrganizationVO
        */
        $organizationVO = $request->getValueObject();

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $model = $createOrganizationAction->run(CreateOrganizationDTO::make($organizationVO, $user));


        return $model?
        response()->json(array_success( OrganizationResource::make($model), 'Successfully create organization'), 201)
            :
        response()->json(array_error(null, 'Failed create organization'), 404);
    }

    public function updated(
        Organization $organization,
        UpdateOrganizationRequest $request,
        UpdateOrganizationAction $updateOrganizationAction
    ) {
        /**
         * @var OrganizationVO
         */
        $organizationVO = $request->getValueObject();

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $status = $updateOrganizationAction->run(UpdateOrganizationDTO::make($organizationVO, $user, $organization->uuid));

        dd($status);

        return $status?
        response()->json(array_success(null , 'Successfully update organization'), 200)
            :
        response()->json(array_success(null, 'Failed update organization'), 404);
    }

    public function deleted(Organization $organization , DeletedOrganizationAction $deletedOrganizationAction)
    {

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $status = $deletedOrganizationAction::run($organization->uuid, $user->id);

        return $status?
        response()->json(array_success(null , 'Successfully deleted organization'), 200)
            :
        response()->json(array_success(null, 'Failed deleted organization'), 404);
    }
}
