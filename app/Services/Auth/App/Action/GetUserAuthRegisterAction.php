<?php

namespace App\Services\Auth\App\Action;

use App\Services\Auth\App\Action\Base\AbstractAuthAction;

class GetUserAuthRegisterAction extends AbstractAuthAction
{
    public function run()
    {
        return $this->authMethod->userIsRegister();
    }

}
