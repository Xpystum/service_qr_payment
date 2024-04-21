<?php

namespace App\Services\Auth\Interface;
use Illuminate\Http\Request;

interface AuthInterface
{
    public function attemptUser();
    public function login(Request $request);
    public function user();
    public function logout();
    public function refresh();
    public function respondWithToken(string $token) : bool|string;
}
