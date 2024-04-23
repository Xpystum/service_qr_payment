<?php

namespace App\Services\Auth\App\Action;
use App\Services\Auth\App\Action\Base\AbstractAuthAction;
use Illuminate\Database\Eloquent\Model;

class GetUserAuthAction extends AbstractAuthAction
{
    public function run() : null|Model
    {
        return $this->authMethod->user();
    }

}
