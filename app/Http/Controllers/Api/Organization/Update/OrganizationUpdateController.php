<?php

namespace App\Http\Controllers\Api\Organization\Update;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Action\Organization\UpdateOrganizationAction;
use App\Modules\Organization\DTO\UpdateOrganizationDTO;
use App\Modules\Organization\Enums\TypeOrganizationEnum;
use App\Modules\Organization\Requests\UpdateOrganizationRequest;
use App\Modules\User\Models\User;
use App\Traits\TraitAuthService;

use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class OrganizationUpdateController extends Controller
{

    public function __invoke(UpdateOrganizationRequest $request, UpdateOrganizationAction $updateOrganizationAction)
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
}
