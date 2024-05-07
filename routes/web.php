<?php

use App\Modules\User\Enums\RoleUserEnum;
use App\Services\Auth\AuthService;
use App\Services\Auth\Drivers\AuthJwt;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    dd(RoleUserEnum::admin->value);
});

