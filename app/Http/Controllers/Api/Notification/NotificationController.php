<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Modules\Notification\DTO\PhoneOrEmailDTO;
use App\Modules\Notification\Enums\MethodNotificationEnum;
use App\Modules\Notification\Requests\ConfirmCodeRequest;
use App\Modules\Notification\Requests\SendNotificationRequest;
use App\Modules\Notification\Services\NotificationService;
use App\Modules\User\Actions\IsNotificationConfirmAction;
use App\Modules\User\Models\User;
use App\Modules\User\Resources\UserResource;
use App\Services\Auth\AuthService;

//для преобразование массива с сообщением
use function App\Helpers\array_success;
use function App\Helpers\array_error;

class NotificationController extends Controller
{

    public function __construct(
        public NotificationService $serviceNotify,
        public AuthService $authService,
    )
    {}

    public function confirmCode(ConfirmCodeRequest $request)
    {
        $validated = $request->validated();

        /**
        * получаем авторизированного user
        * @var User
        */
        $user = $this->authService->getUserAuth();

        abort_unless( (bool) $user, 401, "Не авторизован");

        //проверяем подлинность полученного кода
        $status = $this->serviceNotify
        ->checkNotification()
        ->user($user)
        ->code($validated['code'] ?? null)
        ->run();

        abort_unless($status, 400, 'Ошибка, неверный код или он уже был подтверждён.');

        //для надежности проверки статуса
        return $status ?
        response()->json(array_success(new UserResource($user) , 'Successfully confirm notification'), 200)
            :
        response()->json(array_error(null , 'Error confirm'), 404);

    }

    #TODO Переисать логику (когда нужно подтверждать либо телефон, либо емайл - сделать проверку. Сейчас у меня если какая из нотифкаиция выполнена по майлу
    # или по телефону - то выкидывает в abort
    public function sendNotification(SendNotificationRequest $request)
    {
        $validated = $request->validated();
        
        /**
        * получаем авторизированного User
        * @var User
        */
        $user = $this->authService->getUserAuth();

        $type = $validated['type'];

        abort_if( IsNotificationConfirmAction::run($validated['type'], $user ), 401, "$type уже подтверждён." );

        $this->serviceNotify->selectSendNotification()
        ->run(
            new PhoneOrEmailDTO(
                type: MethodNotificationEnum::returnObjectByString($validated['type'])
            ),
            $user,
        );

        return response()->json(array_error(null , 'Successfully notification send'), 200);

    }
}
