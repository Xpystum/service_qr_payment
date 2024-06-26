<?php

namespace App\Http\Middleware;

use App\Modules\User\Models\User;
use App\Traits\TraitAuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

use function App\Helpers\isAuthorized;

class TerminalMiddleware
{

    use TraitAuthService;

    public function handle(Request $request, Closure $next): Response
    {
        /**
        * @var User
        */
        $user = isAuthorized($this->authService);

        //проверяем есть ли полномочия у пользователя на создание
        $response = Gate::authorize('terminal', $user);

        abort_unless($response->allowed(), 403, $response->message());

        return $next($request);
    }
}
