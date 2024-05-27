<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Modules\Notification\Requests\ConfirmCodeRequest;
use App\Modules\Notification\Services\NotificationService;
use App\Modules\Notification\Traits\SetTraitNotificationService;
use App\Modules\User\Models\User;
use App\Modules\User\Resources\UserResource;
use App\Services\Auth\AuthService;
use App\Traits\SetTraitAuthService;

//для преобразование массива с сообщением
use function App\Helpers\array_success;
use function App\Helpers\array_error;

class NotificationController extends Controller
{

    public function __construct(public NotificationService $serviceNotify, public AuthService $authService)
    {

    }

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

        abort_unless($status, 400, 'Ошибка, неверный код.');

        //для надежности проверки статуса
        if($status)
        {


            
            return response()->json(array_success(new UserResource($user) , 'Successfully confirm email'), 200);
        }

        return response()->json(array_error(null , 'Error confirm'), 404);


        // if($status)
        // {
        //     //обновляем у user дату подтвреждение - email
        //     $statusUpdate = UpdateEmailConfrimUser::run($user);

        //     abort_unless($statusUpdate, 500, 'Ошибка на сервере');

        //     /**
        //     * Получаем из collection models email со статусом "pending"
        //     * @var Email
        //     */
        //     $email = $repositoryEmail->returnEmailPending($user->emails);

        //     //событие в очереди для установки статуса completed
        //     event(new EmailCreatedEvent($email, ActiveStatusEnum::completed));

        //     return response()->json(array_success(new UserResource($user) , 'Successfully confirm email'), 200);
        // }

        return response()->json(array_error(null , 'Error confirm'), 404);
    }

    // public function sendNotification(Request $request, EmailRepository $repositoryEmail, UserRepository $repositoryUser)
    // {

    //     /**
    //     * получаем авторизированного user
    //     * @var User
    //     */
    //     $user = $this->authService->getUserAuth();

    //     /**
    //     * получаем email -> user
    //     * @var Email
    //     */
    //     $email = $repositoryEmail->returnEmailPending($user->emails);

    //     abort_if($repositoryUser->isEmailConfirmed(), 404, 'Email подтверждён');

    //     event(new UserCreatedEvent($user, $email));

    //     return response()->json(array_error(null , 'Successfully email send'), 200);

    // }
}
