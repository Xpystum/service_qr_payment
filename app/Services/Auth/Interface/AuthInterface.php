<?php

namespace App\Services\Auth\Interface;
use Illuminate\Http\Request;
use App\Services\Auth\DTO\BaseDTO;

use App\Services\Auth\AuthConfig;
use Illuminate\Database\Eloquent\Model;

interface AuthInterface
{

    public function __construct(AuthConfig $config);
    public function attemptUser(BaseDTO $data);
    public function loginUser(Model $model);
    public function isLogin(BaseDTO $data);
    public function user();
    public function logout();
    public function refresh();
    public function respondWithToken(string $token);
}
