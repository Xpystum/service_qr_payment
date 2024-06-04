<?php

namespace App\Services\Auth\Drivers;

use Illuminate\Http\Request;
use App\Services\Auth\Interface\AuthInterface;
use App\Services\Auth\AuthConfig;
use App\Services\Auth\DTO\BaseDTO;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;


class AuthJwt implements AuthInterface
{
    public AuthConfig|null $config = null;

    public function __construct(
        AuthConfig $config
    ) {

        $this->config = $config;

    }


    public function attemptUser(BaseDTO $data) : bool|array
    {
        if(!$data) {
            return false;
        }

        return $this->checkUserAuth($data->toArray());

    }

    public function isLogin(BaseDTO $data) : bool|string
    {

        if(!$data) {
            return false;
        }

        return $this->checkUserAuth($data->toArray());
    }

    /**
     * @param Authenticatable $model
     *
     * @return null
     */
    public function loginUser(Model $model) : null|array
    {
        if(!$model) { return null; }

        /**
        *@var string $token
        */
        $token = auth($this->config->guard)->login($model);

        return $this->respondWithToken($token);

    }


    //возвращает user по jwt token в header
    public function user() : null|Model
    {
        return auth($this->config->guard)->user();
    }

    //возвращает user по jwt token в headere который прошёл регистрацию (auth:true в бд) иначел возвращает null
    public function userIsRegister() : ?Model
    {
        $user = auth($this->config->guard)->user();

        if($user->auth) { return $user; }

        return null;
    }

    /**
     * Добавление токена в черный список (выход)
     * если - true мы удалили токен
     *
     * @return bool
     */
    public function logout() : bool
    {

        // JWT_SHOW_BLACKLIST_EXCEPTION=true - нужно добавить в .env
        // $forever = true;
        // JWTAuth::parseToken()->invalidate( $forever );

        //проверяем активен ли токен
        $status = auth('api')->check();

        if($status)
        {
            #TODO найти определении что бы не выдавало ошибку
            //удаляем токен (вносим в черный список)
            auth($this->config->guard)->invalidate(true);

            return true;
        }
        else{

            return false;

        }

    }

    public function refresh() : null|array
    {
        $status = auth($this->config->guard)->check();


        if($status)
        {
            $newToken = auth($this->config->guard)->refresh(true, true);
            return $this->respondWithToken($newToken);
        }

        return null;

    }


    public function respondWithToken(string $token) : null|array
    {

        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config($this->config->UrlExpiresConfig) * 60,
        ];

        return $data;

    }

    private function checkUserAuth(array $credentials) : bool|array
    {
        if (! $token = auth($this->config->guard)->attempt($credentials) )
        {
            return false;
        }
        return $this->respondWithToken($token);
    }
}
