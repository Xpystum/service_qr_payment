<?php

namespace App\Services\Auth\App\Action;

use App\Services\Auth\App\Action\Base\AbstractAuthAction;
use App\Services\Auth\DTO\BaseDTO;

class AttemptUserAuthAction extends AbstractAuthAction
{
    public function run(BaseDTO $data)
    {
        return $this->authMethod->attemptUser($data);
    }

}
