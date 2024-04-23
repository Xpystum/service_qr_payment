<?php

namespace App\Services\Auth\App\Action;
use App\Services\Auth\App\Action\Base\AbstractAuthAction;
use Illuminate\Database\Eloquent\Model;

class loginUserAuthAction extends AbstractAuthAction
{
    public function run(Model $model) : null|array
    {
        return $this->authMethod->loginUser($model);
    }

}
