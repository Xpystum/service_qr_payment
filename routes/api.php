<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Entry\LoginController;
use App\Http\Controllers\Api\Entry\RegistrationController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Organization\Create\OrganizationCreateController;
use App\Http\Controllers\Api\Organization\Deleted\OrganizationDeletedController;
use App\Http\Controllers\Api\Organization\Get\OrganizationGetController;
use App\Http\Controllers\Api\Organization\OrganizationController;
use App\Http\Controllers\Api\Payment\Create\PaymentCreateController;
use App\Http\Controllers\Api\Payment\Get\PaymentGetController;
use App\Http\Controllers\Api\Terminal\Create\TerminalCreateController;
use App\Http\Controllers\Api\Terminal\Get\TerminalGetController;
use App\Http\Controllers\Api\Terminal\TerminalController;
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
Route::prefix('organization')->controller(OrganizationController::class)->middleware(['auth:api'])->group(function () {

    //вернуть все организации User
    Route::get('/', 'index');

    //вернуть организацию по uuid
    Route::get('/{organization:uuid}', 'show');

    //Создать организацию User
    Route::post('/', 'create');

    //Изменить данные организации User
    Route::put('/{organization:uuid}', 'updated');

    //Удалить организацию User
    Route::delete('/{organization:uuid}', 'deleted');

});

//работа с Terminal
Route::prefix('terminal')->controller(TerminalController::class)->middleware(['auth:api', 'terminal'])->group(function () {

    //вернуть все терминалы по организации
    Route::get('/', 'index');

    //вернуть терминал по uuid
    Route::get('/{terminal:uuid}', 'show');

    //Создать терминал по организации
    Route::post('/', 'create');

    //Изменить название терминала
    Route::put('/{terminal:uuid}', 'update');

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

    Route::get('/{payment:uuid}', PaymentGetController::class);
    Route::post('/{transaction:uuid}/create', PaymentCreateController::class);

})->whereUuid('payment');




Route::prefix('password')->group(function () {
    Route::post('/forgot', [PassworController::class, 'forgot']);
    Route::post('/change', [PassworController::class, 'change']);
});




