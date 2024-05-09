<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Modules\Notifications\Action\UpdateCodeAction;
use App\Modules\Notifications\Enums\ActiveStatusEnum;
use App\Modules\Notifications\Events\EmailCreatedEvent;
use App\Modules\Notifications\Repositories\EmailRepository;
use App\Modules\Notifications\Requests\ConfirmRequest;
use App\Modules\User\Actions\UpdateEmailConfrimUser;
use App\Modules\User\Events\UserCreatedEvent;
use App\Modules\User\Models\User;
use App\Modules\Notifications\Models\Email;
use App\Modules\User\Repositories\UserRepository;
use App\Modules\User\Resources\UserResource;
use App\Traits\TraitAuthService;
use Illuminate\Http\Request;

//для преобразование массива с сообщением
use function App\Helpers\array_success;
use function App\Helpers\array_error;

class NotificationController extends Controller
{

    use TraitAuthService;

    public function confirmEmailOrPhone(ConfirmRequest $request, EmailRepository $repositoryEmail)
    {

        $validated = $request->validated();

        /**
        * получаем авторизированного user
        * @var User
        */
        $user = $this->authService->getUserAuth();

        //проверяем подлинность полученного кода
        $status = $repositoryEmail->checkCode($validated['code'], $user->id);

        abort_unless($status, 400, 'Ошибка, неверный код.');

        if($status)
        {
            //обновляем у user дату подтвреждение - email
            $statusUpdate = UpdateEmailConfrimUser::run($user);

            abort_unless($statusUpdate, 500, 'Ошибка на сервере');

            /**
            * Получаем из collection models email со статусом "pending"
            * @var Email
            */
            $email = $repositoryEmail->returnEmailPending($user->emails);

            //событие в очереди для установки статуса completed
            event(new EmailCreatedEvent($email, ActiveStatusEnum::completed));

            return response()->json(array_success(new UserResource($user) , 'Successfully confirm email'), 200);
        }

        return response()->json(array_error(null , 'Error confirm'), 404);
    }

    public function sendNotificationEmail(Request $request, EmailRepository $repositoryEmail, UserRepository $repositoryUser)
    {

        /**
        * получаем авторизированного user
        * @var User
        */
        $user = $this->authService->getUserAuth();

        /**
        * получаем email -> user
        * @var Email
        */
        $email = $repositoryEmail->returnEmailPending($user->emails);

        abort_if($repositoryUser->isEmailConfirmed(), 404, 'Email подтверждён');

        event(new UserCreatedEvent($user, $email));

        return response()->json(array_error(null , 'Successfully Email send'), 200);

    }
}
