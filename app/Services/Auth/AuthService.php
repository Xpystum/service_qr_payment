<?php

namespace App\Services\Auth;

use App\Services\Auth\App\Action\AttemptUserAuthAction;
use App\Services\Auth\App\Action\GetUserAuthAction;
use App\Services\Auth\App\Action\GetUserAuthRegisterAction;
use App\Services\Auth\App\Action\loginUserAuthAction;
use App\Services\Auth\App\Action\LogoutUserAuthAction;
use App\Services\Auth\App\Action\RefreshUserAuthAction;
use App\Services\Auth\Interface\AuthInterface;
use App\Services\Auth\DTO\BaseDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuthService
{

    public function __construct(

       public AuthInterface $serviceAuth

    ) {
        $this->serviceAuth = $serviceAuth;
    }

    /**
     * Вернуть юзера по Bearer токену и зарегистрированного (auth:true в БД)
     *
     * @return null|Model
     */
    public function getUserAuthRegister() : null|Model
    {
        return GetUserAuthRegisterAction::make($this->serviceAuth)->run();
    }

    /**
     * Вернуть юзера по Bearer токену
     *
     * @return null|Model
     */
    public function getUserAuth() : null|Model
    {
        return GetUserAuthAction::make($this->serviceAuth)->run();
    }


    /**
     * Найти user по данным email/phone/password
     *
     * @param BaseDTO $data
     *
     * @return bool|array
     */
    public function attemptUserAuth(BaseDTO $data) : bool|array
    {
        return AttemptUserAuthAction::make($this->serviceAuth)->run($data);
    }

    /**
     * //Удалить Bearer для user (выйти) *which will invalidate the current token and unset the authenticated user.
     * @return bool
     */
    public function logout() : bool
    {
        return LogoutUserAuthAction::make($this->serviceAuth)->run();
    }

    /**
     * Удаляет старый Bearer (заносит в черный список) и присылает новый
     * @return null|array
     */
    public function refresh() : null|array
    {
        return RefreshUserAuthAction::make($this->serviceAuth)->run();
    }

    /**
     * Возваращет token по модели user (если модель существует в бд)
     * @return null|array
     */
    public function loginUser(Model $model) : null|array
    {
        return loginUserAuthAction::make($this->serviceAuth)->run($model);
    }

}
