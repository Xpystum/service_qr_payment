<?php

namespace App\Services\Auth;

use App\Services\Auth\App\Action\AttemptUserAuthAction;
use App\Services\Auth\Interface\AuthInterface;
use Illuminate\Http\Request;

class AuthService
{

    public function __construct(

       public AuthInterface $serviceAuth

    ) {
        $this->serviceAuth = $serviceAuth;
    }

    public function login()
    {

    }

    public function attemptUserAuth(Request $request)
    {
        return AttemptUserAuthAction::make($this->serviceAuth)->run($request);
    }


}
