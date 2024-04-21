<?php

use App\Http\Controllers\Api\Auth\Entry\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\Entry\LoginController;
use App\Http\Controllers\Api\Auth\Entry\RegistrationController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/login', [LoginController::class, 'index']);
Route::post('/registration', [RegistrationController::class, 'index']);


Route::prefix('auth')->controller(AuthController::class)->group(function () {

    Route::post('/login', 'login');

    Route::middleware(['api'])->group(function () {

        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::post('/me', 'user');

    });

});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
