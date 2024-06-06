<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Entry\LoginController;
use App\Http\Controllers\Api\Entry\RegistrationController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\User\Edit\EditUserController;
use App\Http\Controllers\Api\User\Password\PassworController;

//Регистрация и вход
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
    Route::post('/confirmation/send', [NotificationController::class, 'sendNotification']);
});

Route::prefix('create')->middleware(['auth:api'])->group(function () {
    //создание user который относится к админу: casier, manager
    Route::post('/user', '')
});

//работа с user (edit)
Route::prefix('user')->middleware(['auth:api'])->group(function () {
    Route::post('/edit', EditUserController::class);
});

Route::prefix('password')->group(function () {

    Route::post('/forgot', [PassworController::class, 'forgot']);
    Route::post('/change', [PassworController::class, 'change']);

});




