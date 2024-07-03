<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Entry\LoginController;
use App\Http\Controllers\Api\Entry\RegistrationController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Organization\Create\OrganizationCreateController;
use App\Http\Controllers\Api\Organization\Deleted\OrganizationDeletedController;
use App\Http\Controllers\Api\Organization\Get\OrganizationGetController;
use App\Http\Controllers\Api\Terminal\Create\TerminalCreateController;
use App\Http\Controllers\Api\Terminal\Get\TerminalGetController;
use App\Http\Controllers\Api\Transaction\Create\TransactionCreateController;
use App\Http\Controllers\Api\Transaction\CreatePayment\TransactionCreatePaymentController;
use App\Http\Controllers\Api\Transaction\Get\TransactionGetController;
use App\Http\Controllers\Api\User\Create\UserCreateController;
use App\Http\Controllers\Api\User\Deleted\DeletedUserController;
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

    //создание user который относится к админу: casier, manager
    Route::post('/create', UserCreateController::class);

    //обновление данных у user
    Route::put('/update', EditUserController::class);

    //удаление user от user:admin
    Route::delete('/deleted', DeletedUserController::class);

});

//работа с organization
Route::prefix('organization')->middleware(['auth:api'])->group(function () {

    //вернуть все организации User
    Route::get('/', [OrganizationGetController::class, 'getAll']);

    //Создать организацию User
    Route::post('/create', OrganizationCreateController::class);

    //Изменить данные организации User
    Route::post('/put', OrganizationCreateController::class);

    //Удалить организацию User
    Route::delete('/delete', OrganizationDeletedController::class);

});

//работа с Terminal
Route::prefix('terminal')->middleware(['auth:api', 'terminal'])->group(function () {

    //вернуть все организации User
    Route::get('/', TerminalGetController::class);

    //Создать терминал для User
    Route::post('/create', TerminalCreateController::class);

    // //Изменить данные организации User
    // Route::post('/put', OrganizationCreateController::class);

    // //Удалить организацию User
    // Route::delete('/delete', OrganizationDeletedController::class);

});

//работа с Transaction
Route::prefix('transaction')->group(function () {

    Route::get('/{terminal:uuid}', TransactionGetController::class)->whereUuid('terminal');
    Route::post('/{terminal:uuid}/create', TransactionCreateController::class)->whereUuid('terminal');
    Route::post('/{transaction:uuid}/payment', TransactionCreatePaymentController::class)->whereUuid('transaction');

});

//работа с Payment
Route::prefix('payment')->group(function () {

    // Route::get('/{payment:uuid}', TransactionGetController::class);
    // Route::post('/{transaction:uuid}/create', PaymentCreateController::class);

})->whereUuid('payment');




Route::prefix('password')->group(function () {
    Route::post('/forgot', [PassworController::class, 'forgot']);
    Route::post('/change', [PassworController::class, 'change']);
});




