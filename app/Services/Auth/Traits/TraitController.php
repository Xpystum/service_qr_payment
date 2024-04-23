<?php

namespace App\Services\Auth\Traits;

use App\Services\Auth\AuthService;

trait TraitController
{

    protected AuthService $authService;

    //сразу используем DI для того что бы не указывать каждый раз в методах
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

}
