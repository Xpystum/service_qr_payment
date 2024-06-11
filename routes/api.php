<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Entry\LoginController;
use App\Http\Controllers\Api\Entry\RegistrationController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Organization\Create\OrganizationCreateController;
use App\Http\Controllers\Api\Organization\Deleted\OrganizationDeletedController;
use App\Http\Controllers\Api\Organization\Get\OrganizationGetController;
use App\Http\Controllers\Api\Organization\Update\OrganizationUpdateController;
use App\Http\Controllers\Api\User\Create\UserCreateController;
use App\Http\Controllers\Api\User\Edit\EditUserController;
use App\Http\Controllers\Api\User\Get\UserGetController;
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

    //TODO вернуть user
    Route::get('/', [UserGetController::class, 'all']);

    // Route::post('/deleted', EditUserController::class);

    //создание user который относится к админу: casier, manager
    Route::post('/create', UserCreateController::class);

    //обновление данных у user
    Route::put('/update', EditUserController::class);

});

//работа с organization
Route::prefix('organization')->middleware([])->group(function () {

    //вернуть все организации User
    Route::get('/', [OrganizationGetController::class, 'getAll']);

    //Создать организацию User
    Route::post('/create', OrganizationCreateController::class);

    //Изменить данные организации User
    Route::post('/put', OrganizationCreateController::class);

    //Удалить организацию User
    Route::delete('/delete', OrganizationDeletedController::class);

});

Route::prefix('password')->group(function () {

    Route::post('/forgot', [PassworController::class, 'forgot']);
    Route::post('/change', [PassworController::class, 'change']);

});




