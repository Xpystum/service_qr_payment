<?php

namespace App\Traits;

use App\Services\Auth\AuthService;

trait SetTraitAuthService
{

    protected AuthService $authService;

    //сразу используем DI для того что бы не указывать каждый раз в методах
    public function setTraitAuthService(AuthService $authService)
    {
        $this->authService = $authService;
    }

}
