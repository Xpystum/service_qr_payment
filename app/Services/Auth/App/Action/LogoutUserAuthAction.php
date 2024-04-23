<?php

namespace App\Services\Auth\App\Action;
use App\Services\Auth\App\Action\Base\AbstractAuthAction;
use Illuminate\Database\Eloquent\Model;

class LogoutUserAuthAction extends AbstractAuthAction
{
    public function run() : bool
    {
        return $this->authMethod->logout();
    }

}
