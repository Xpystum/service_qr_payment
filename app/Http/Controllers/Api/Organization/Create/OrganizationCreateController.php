<?php

namespace App\Http\Controllers\Api\Organization\Create;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Action\Organization\CreateOrganizationAction;
use App\Modules\Organization\DTO\CreateOrganizationDTO;
use App\Modules\Organization\Enums\TypeOrganizationEnum;
use App\Modules\Organization\Requests\CreteOrganizationRequest;
use App\Modules\Organization\Resources\OrganizationResource;
use App\Modules\User\Models\User;
use App\Traits\TraitAuthService;

use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class OrganizationCreateController extends Controller
{
    use TraitAuthService;
    public function __invoke(CreteOrganizationRequest $request, CreateOrganizationAction $createOrganizationAction)
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
        response()->json(array_success(null, 'Failed create organization'), 404);
    }
}
