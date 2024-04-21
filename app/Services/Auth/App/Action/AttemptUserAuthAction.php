<?php

namespace App\Services\Auth\App\Action;
use Illuminate\Http\Request;

class AttemptUserAuthAction extends AbstractAuthAction
{
    public function run(Request $request)
    {
        return $this->authMethod->login($request);
    }

}
