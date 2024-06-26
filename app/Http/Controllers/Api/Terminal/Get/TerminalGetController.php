<?php

namespace App\Http\Controllers\Api\Terminal\Get;

use App\Http\Controllers\Controller;
use App\Modules\Terminal\Repositories\TerminalRepository;
use App\Modules\Terminal\Resources\TerminalResource;
use App\Modules\User\Models\User;

use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class TerminalGetController extends Controller
{
    /**
     *  Вернуть все терминалы относящиеся к user
     *
     * @param TerminalRepository $terminalRepository
     *
     * @return [type]
     */
    public function __invoke(TerminalRepository $terminalRepository)
    {
        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        $collection = $terminalRepository->getTerminal($user);

        return response()->json(array_success( TerminalResource::collection($collection), 'Get all child terminal of the user'), 200);

    }
}
