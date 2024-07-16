<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Action\Organization\CreateOrganizationAction;
use App\Modules\Organization\Action\Organization\DeletedOrganizationAction;
use App\Modules\Organization\Action\Organization\UpdateOrganizationAction;
use App\Modules\Organization\DTO\CreateOrganizationDTO;
use App\Modules\Organization\DTO\UpdateOrganizationDTO;
use App\Modules\Organization\Enums\TypeOrganizationEnum;
use App\Modules\Organization\Models\Organization;
use App\Modules\Organization\Repositories\OrganizationRepositories;
use App\Modules\Organization\Requests\CreteOrganizationRequest;
use App\Modules\Organization\Requests\DeletedOrganizationRequest;
use App\Modules\Organization\Requests\UpdateOrganizationRequest;
use App\Modules\Organization\Resources\OrganizationResource;
use App\Modules\User\Models\User;
use App\Traits\TraitAuthService;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;
class OrganizationController extends Controller
{

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
        /**
        * @var User
        */
        $user = isAuthorized($this->authService);


        return response()->json(array_success( $organization, 'Return organization'), 200);
    }

    public function create(CreteOrganizationRequest $request, CreateOrganizationAction $createOrganizationAction)
    {
        $validated = $request->validated();

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $model = $createOrganizationAction->run(
            new CreateOrganizationDTO(

                name: $validated['name'],

                owner_id: $user->id,

                address: $validated['address'],

                phone_number: $validated['phone_number'] ?? null,

                email: $validated['email'] ?? null,

                website: $validated['website'] ?? null,

                type: TypeOrganizationEnum::returnObjectByString($validated['type']),

                description: $validated['description'] ?? null,

                industry: $validated['industry'] ?? null,

                founded_date: $validated['founded_date'] ?? null,

                inn: $validated['inn'],

                kpp: $validated['kpp'] ?? null,

                registration_number: $validated['registration_number'] ?? null,

                registration_number_individual: $validated['registration_number_individual'] ?? null,
            )
        );

        #TODO сделать конструкцию if снизу
        $organizationResource = new OrganizationResource($model);

        return $model?
        response()->json(array_success( $organizationResource, 'Successfully create organization'), 200)
            :
        response()->json(array_error(null, 'Failed create organization'), 404);
    }

    public function updated(UpdateOrganizationRequest $request, UpdateOrganizationAction $updateOrganizationAction)
    {
        $validated = $request->validated();

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $status = $updateOrganizationAction->run(
            new UpdateOrganizationDTO(

                uuid: $validated['uuid'],

                owner_id: $user->id,

                name: $validated['name'] ?? null,

                address: $validated['address'] ?? null,

                phone_number: $validated['phone_number'] ?? null,

                email: $validated['email'] ?? null,

                website: $validated['website'] ?? null,

                type: TypeOrganizationEnum::returnObjectByString($validated['type'] ?? null) ?? null,

                description: $validated['description'] ?? null,

                industry: $validated['industry'] ?? null,

                founded_date: $validated['founded_date'] ?? null,

                inn: $validated['inn'] ?? null,

                kpp: $validated['kpp'] ?? null,

                registration_number: $validated['registration_number'] ?? null,

                registration_number_individual: $validated['registration_number_individual'] ?? null,
            )
        );

        return $status?
        response()->json(array_success(null , 'Successfully update organization'), 200)
            :
        response()->json(array_success(null, 'Failed update organization'), 404);
    }

    public function deleted(DeletedOrganizationRequest $request , DeletedOrganizationAction $deletedOrganizationAction)
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
