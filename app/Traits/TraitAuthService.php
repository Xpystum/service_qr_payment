<?php

namespace App\Traits;

use App\Services\Auth\AuthService;

trait TraitAuthService
{

    protected AuthService $authService;

    //сразу используем DI для того что бы не указывать каждый раз в методах
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

}
