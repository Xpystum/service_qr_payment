<?php

namespace App\Http\Controllers\Api\Terminal;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Repositories\OrganizationRepositories;
use App\Modules\Terminal\Action\Terminal\CreateTerminalAction;
use App\Modules\Terminal\Action\Terminal\UpdateTerminalAction;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Terminal\Repositories\TerminalRepository;
use App\Modules\Terminal\Requests\TerminalGetRequest;
use App\Modules\Terminal\Requests\TerminalRequest;
use App\Modules\Terminal\Requests\TerminalUpdateRequest;
use App\Modules\Terminal\Resources\TerminalResource;
use App\Modules\User\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class TerminalController extends Controller
{

    /**
    *  Вернуть все терминалы относящиеся к organization
    *
    * @param TerminalGetRequest $request
    * @param TerminalRepository $terminalRepository
    *
    * @return [type]
    */
    public function index(TerminalGetRequest $request, TerminalRepository $terminalRepository, OrganizationRepositories $organizationRepositories)
    {

        $validated = $request->validated();

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        {
            $organization = $organizationRepositories->uuidOrganization($validated['organization_uuid']);
            abort_unless((bool) $organization, 404,  'Ресурс по uuid не был найден на сервере.');
        }

        $collection = $terminalRepository->getTerminal($organization->id);

        return response()->json(array_success( TerminalResource::collection($collection), 'Get all child terminal of the user'), 200);

    }


    /**
     *
     * Создать терминал по organization
     *
     * @param TerminalRequest $request
     * @param CreateTerminalAction $createTerminalAction
     * @param OrganizationRepositories $organizationRepositories
     *
     * @return [type]
     */
    public function create(TerminalRequest $request, CreateTerminalAction $createTerminalAction, OrganizationRepositories $organizationRepositories)
    {
        $validated = $request->validated();

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        {
            $organization = $organizationRepositories->uuidOrganization($validated['organization_uuid']);
            abort_unless((bool) $organization, 404,  'Ресурс по uuid не был найден на сервере.');
        }

        $modelTerminal = $createTerminalAction::run( $organization, $validated['name']);

        return $modelTerminal?
        response()->json(array_success( TerminalResource::make($modelTerminal), 'Successfully create terminal'), 200)
            :
        response()->json(array_error(null, 'Failed create terminal'), 404);

    }

    public function show(Terminal $terminal)
    {
        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        response()->json(array_success( TerminalResource::make($terminal), 'Show terminal by uuid'), 200);
    }

    public function update(Terminal $terminal, TerminalUpdateRequest $request, UpdateTerminalAction $action)
    {
        $validated = $request->validated();

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $status = $action->name($validated['name'])->run($terminal);

        return $status?
        response()->json(array_success(null , 'Successfully update terminal'), 200)
            :
        response()->json(array_error(null, 'Failed update terminal'), 404);

    }
}
