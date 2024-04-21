<?php

namespace App\Services\Auth\Drivers;

use Illuminate\Http\Request;
use App\Services\Auth\Interface\AuthInterface;

class AuthJwt implements AuthInterface
{
    public function attemptUser() { }
    public function login(Request $request) : bool|string
    {
        $credentials = $request->only(['email' ,'password', 'phone']);
        $token = auth('api')->attempt($credentials);

        if (! $token = auth()->attempt($credentials)) {
            return false;
        }
        
        return $this->respondWithToken($token);
    }
    public function user() { }
    public function logout() { }
    public function refresh() { }
    public function respondWithToken(string $token) : bool|string
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
        ];



        return json_encode($data);

    }
}
