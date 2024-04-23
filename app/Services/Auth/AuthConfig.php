<?php

namespace App\Services\Auth;

class AuthConfig
{

    public function __construct(

        public string $guard,

        public string $UrlExpiresConfig,

    ) { }

}
