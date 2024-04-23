<?php

namespace App\Services\Auth\App\Action;

use App\Services\Auth\App\Action\Base\AbstractAuthAction;
use App\Services\Auth\DTO\BaseDTO;
use Illuminate\Http\Request;

class RefreshUserAuthAction extends AbstractAuthAction
{
    public function run() : null|array
    {
        return $this->authMethod->refresh();
    }

}
