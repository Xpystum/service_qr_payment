<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Modules\Notifications\Action\UpdateStatusEmailAction;
use App\Modules\Notifications\Enums\ActiveStatusEnum;
use App\Modules\Notifications\Events\EmailCreatedEvent;
use App\Modules\Notifications\Repositories\EmailRepository;
use App\Modules\Notifications\Requests\ConfirmRequest;
use App\Modules\User\Actions\UpdateEmailConfrimUser;
use App\Modules\User\Models\User;
use App\Modules\User\Resources\UserResource;
use App\Services\Auth\Traits\TraitController;

//для преобразование массива с сообщением
use function App\Helpers\array_success;
use function App\Helpers\array_error;

class NotificationController extends Controller
{

    use TraitController;

    public function confirmEmailOrPhone(ConfirmRequest $request, EmailRepository $repository)
    {

        $validated = $request->validated();

        /**
        * получаем авторизированного user
        * @var User
        */
        $user = $this->authService->getUserAuth();

        //проверяем подлинность полученного кода
        $status = $repository->checkCode($validated['code'], $user->id);

        abort_unless($status, 400, 'Ошибка, неверный код.');

        if($status)
        {
            //обновляем у user дату подтвреждение - email
            $statusUpdate = UpdateEmailConfrimUser::run($user);

            abort_unless($statusUpdate, 500, 'Ошибка на сервере');

            //событие в очереди для установки статуса completed
            event(new EmailCreatedEvent($user->emailConfirm, ActiveStatusEnum::completed));

            return response()->json(array_success(new UserResource($user) , 'Successfully confirm email'), 200);
        }

        return response()->json(array_error(null , 'Error confirm'), 404);
    }
}
