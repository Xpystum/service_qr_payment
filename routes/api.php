<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Entry\LoginController;
use App\Http\Controllers\Api\Entry\RegistrationController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Organization\Create\OrganizationCreateController;
use App\Http\Controllers\Api\User\Create\UserCreateController;
use App\Http\Controllers\Api\User\Edit\EditUserController;
use App\Http\Controllers\Api\User\Password\PassworController;

//Регистрация и вход
Route::post('/login', [LoginController::class, 'store']);
Route::post('/registration', [RegistrationController::class, 'store']);


//routing аутентификации по токену
Route::prefix('auth')->controller(AuthController::class)->group(function () {

    Route::post('/login', 'login');

    Route::middleware(['auth:api'])->group(function () {

        Route::get('/me', 'user');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');

    });

});

//верификация email и отправка повторного сообщение
Route::middleware(['auth:api'])->group(function () {
    Route::post('/confirmation/code', [NotificationController::class, 'confirmCode']);
    Route::post('/confirmation/send', [NotificationController::class, 'sendNotification']);
});


//работа с user
Route::prefix('user')->middleware(['auth:api'])->group(function () {
    Route::update('/update', EditUserController::class);

    //TODO сделать потом
    // Route::post('/get', EditUserController::class);
    // Route::post('/deleted', EditUserController::class);

     //создание user который относится к админу: casier, manager
    Route::post('/create', UserCreateController::class);
});

//работа с organization
Route::prefix('organization')->middleware([])->group(function () {
    // Route::post('/edit', EditUserController::class);

    Route::post('/create', OrganizationCreateController::class);
});

Route::prefix('password')->group(function () {

    Route::post('/forgot', [PassworController::class, 'forgot']);
    Route::post('/change', [PassworController::class, 'change']);

});




