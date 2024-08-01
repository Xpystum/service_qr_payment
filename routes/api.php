<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Callback\YkassaCallbackController;
use App\Http\Controllers\Api\DriverInfo\DriverInfoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Entry\LoginController;
use App\Http\Controllers\Api\Entry\RegistrationController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Organization\OrganizationController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\Terminal\TerminalController;
use App\Http\Controllers\Api\Transaction\TransactionController;
use App\Http\Controllers\Api\User\Password\PassworController;
use App\Http\Controllers\Api\User\UserController;

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


Route::group( ['middleware' => ['auth:api']], function (){

    //верификация email и отправка повторного сообщение
    Route::prefix('confirmation')->group(function () {
        Route::post('/code', [NotificationController::class, 'confirmCode']);
        Route::post('/send', [NotificationController::class, 'sendNotification']);
    });

    //работа с user
    Route::prefix('user')->controller(UserController::class)->group(function () {

        //TODO вернуть user
        Route::get('/',  'index')->middleware(['admin_user']);

        //создание user который относится к админу: casier, manager (создавать может только admin)
        Route::post('/', 'create')->middleware(['admin_user']);

        //обновление данных у user
        Route::put('/', 'update');

        //удаление user от user:admin
        Route::delete('/', 'delete')->middleware(['admin_user']);

    });

    //работа с organization
    Route::prefix('organization')->controller(OrganizationController::class)->middleware(['admin_user'])->group(function () {

        //вернуть все организации User
        Route::get('/', 'index');

        //вернуть организацию по uuid
        Route::get('/{organization:uuid}', 'show')->whereUuid('organization');

        //Создать организацию User
        Route::post('/', 'create');

        //Изменить данные организации User
        Route::put('/{organization:uuid}', 'updated')->whereUuid('organization');

        //Удалить организацию User
        Route::delete('/{organization:uuid}', 'deleted')->whereUuid('organization');

    });

    //работа с Terminal
    Route::prefix('terminal')->controller(TerminalController::class)->middleware(['admin/manager_user'])->group(function () {

        //вернуть все терминалы по организации
        Route::get('/{organization:uuid}', 'index')->whereUuid('organization');

        //Создать терминал по организации
        Route::post('/', 'create');

        //вернуть терминал по uuid
        Route::get('/{terminal:uuid}', 'show')->whereUuid('terminal');

        //Изменить название терминала
        Route::put('/{terminal:uuid}', 'update')->whereUuid('terminal');

        //Удалить организацию User
        Route::delete('/{terminal:uuid}', 'deleted')->whereUuid('terminal');

    });

    //работа с Transaction
    Route::prefix('transaction')->controller(TransactionController::class)->middleware(['admin/manager_user'])->group(function () {

        //вернуть транзакции пагинацией по терминалу
        Route::get('/{terminal:uuid}/pagination', 'index')->whereUuid('terminal');

        //вернуть все транзакции у терминал без пагинации
        Route::get('/{terminal:uuid}/all', 'all')->whereUuid('terminal');

        //вернуть транзакцию по uuid
        Route::get('/{transaction:uuid}', 'show')->whereUuid('transaction');

        //создать транзакцию
        Route::post('/', 'create');

        //создание payment
        Route::post('/{transaction:uuid}/payment', 'payment')->whereUuid('transaction');

        //вернуть payment по transaction
        Route::get('/{transaction:uuid}/payment', 'payment_index')->whereUuid('transaction');

    });

    //работа с Payment
    Route::prefix('payment')->controller(PaymentController::class)->group(function () {

        //Получение всех активных методов оплаты
        Route::get('/', 'checkout')->whereUuid('payment')->name('payment.checkout');

        //Получение конкретного payment по uuid
        Route::get('/{payment:uuid}', 'show')->whereUuid('payment');

        //Получение конкретного payment по uuid
        Route::get('/{payment:uuid}/process', 'process')->whereUuid('payment');

    });

    //Работа с DriverInfo
    Route::prefix('driver-info')->middleware(['admin_user'])->controller(DriverInfoController::class)->group(function () {

        //получение списков параметров всех платежек (этот роут должен находиться выше роута с paymentMethod)
        Route::get('/storage', 'storage');

        //Сохранения данных
        Route::put('/save', 'save')->middleware();

        // Получение всех значений у метода оплаты по [user] [payment_method]
        Route::get('/{paymentMethod:id}/show', 'show');

    });

});

//callback с платежных агрегаторов
Route::prefix('callbacks')->group(function () {

    Route::post('/ykassa', [YkassaCallbackController::class, 'callback']);

});


Route::prefix('password')->group(function () {
    Route::post('/forgot', [PassworController::class, 'forgot']);
    Route::post('/change', [PassworController::class, 'change']);
});




