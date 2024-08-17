<?php

namespace App\Http\Controllers\Api\Terminal;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Models\Organization;
use App\Modules\Organization\Repositories\OrganizationRepositories;
use App\Modules\Terminal\Action\Handlers\CreateTerminalHandler;
use App\Modules\Terminal\Action\Terminal\CreateTerminalAction;
use App\Modules\Terminal\Action\Terminal\DeletedTerminalAction;
use App\Modules\Terminal\Action\Terminal\UpdateTerminalAction;
use App\Modules\Terminal\DTO\ValueObject\TerminalVO;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Terminal\Repositories\TerminalRepository;
use App\Modules\Terminal\Requests\TerminalGetRequest;
use App\Modules\Terminal\Requests\TerminalRequest;
use App\Modules\Terminal\Requests\TerminalUpdateRequest;
use App\Modules\Terminal\Resources\TerminalResource;
use App\Modules\User\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class TerminalController extends Controller
{
    use AuthorizesRequests;

    /**
    *  Вернуть все терминалы относящиеся к organization
    *
    * @param TerminalGetRequest $request
    * @param TerminalRepository $terminalRepository
    *
    * @return [type]
    */
    public function index(Organization $organization, TerminalRepository $terminalRepository)
    {
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
    public function create(TerminalRequest $request, CreateTerminalHandler $handler)
    {
        /**
        * @var TerminalVO
        */
        $terminalVO = $request->getValueObject();

        $modelTerminal = $handler->handle($terminalVO);


        return $modelTerminal?
        response()->json(array_success( TerminalResource::make($modelTerminal), 'Successfully create terminal'), 201)
            :
        response()->json(array_error(null, 'Failed create terminal'), 404);

    }

    public function show(Terminal $terminal)
    {
        return response()->json(array_success( TerminalResource::make($terminal), 'Show terminal by uuid'), 200);
    }


    public function update(Terminal $terminal, TerminalUpdateRequest $request, UpdateTerminalAction $action)
    {
        $validated = $request->validated();

        $status = $action->name($validated['name'])->run($terminal);

        return $status?
        response()->json(array_success(null , 'Successfully update terminal'), 200)
            :
        response()->json(array_error(null, 'Failed update terminal'), 404);
    }

    public function deleted(Terminal $terminal, DeletedTerminalAction $deletedTerminalAction)
    {
        $status = $deletedTerminalAction->run($terminal);

        return $status?
        response()->json(array_success(null , 'Terminal deleted'), 200)
            :
        response()->json(array_error(null, 'Terminal failed deleted'), 404);
    }
}
