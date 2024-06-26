<?php

namespace App\Http\Controllers\Api\Terminal\Create;

use App\Http\Controllers\Controller;
use App\Modules\Terminal\Action\Terminal\CreateTerminalAction;
use App\Modules\Terminal\Requests\TerminalRequest;
use App\Modules\Terminal\Resources\TerminalResource;
use App\Modules\User\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class TerminalCreateController extends Controller
{
    /**
     * Update the given blog post.
     *
     * @throws AuthorizationException
     */
    public function __invoke(TerminalRequest $request,CreateTerminalAction $createTerminalAction)
    {
        $validated = $request->validated();

        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        //проверяем есть ли полномочия у пользователя на создание
        $response = Gate::authorize('createTerminal', $user);

        abort_unless($response->allowed(), 403, $response->message());

        $modelTerminal = $createTerminalAction::run($user, $validated['name']);

        return $modelTerminal?
        response()->json(array_success( TerminalResource::make($modelTerminal), 'Successfully create terminal'), 200)
            :
        response()->json(array_error(null, 'Failed create terminal'), 404);

    }
}
