<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Entry\LoginController;
use App\Http\Controllers\Api\Entry\RegistrationController;
use App\Http\Controllers\Api\Notification\NotificationController;



Route::post('/login', [LoginController::class, 'store']);
Route::post('/registration', [RegistrationController::class, 'store']);

//routing аутентификации по токену
Route::prefix('auth')->controller(AuthController::class)->group(function () {

    Route::post('/login', 'login');

    Route::middleware(['auth:api'])->group(function () {

        Route::post('/me', 'user');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');

    });

});

//верификация email и отправка повторного сообщение
Route::middleware(['auth:api'])->group(function () {

    Route::post('/confirmation/code', [NotificationController::class, 'confirmCode']);
    Route::post('/confirmation/code/again', [NotificationController::class, 'sendNotification']);

});




