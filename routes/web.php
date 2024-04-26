<?php

use App\Services\Auth\AuthService;
use App\Services\Auth\Drivers\AuthJwt;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

