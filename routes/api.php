<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Entry\LoginController;
use App\Http\Controllers\Api\Entry\RegistrationController;
use App\Services\Auth\App\Http\Controllers\Api\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'store']);
Route::post('/registration', [RegistrationController::class, 'store']);

Route::prefix('auth')->controller(AuthController::class)->group(function () {

    Route::post('/login', 'login');

    Route::middleware(['api'])->group(function () {

        Route::post('/me', 'user');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');

    });

});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
