<?php

namespace App\Http\Controllers\Api\User\Password;
use App\Http\Controllers\Controller;
use App\Modules\Notification\DTO\PhoneOrEmailDTO;
use App\Modules\Notification\Enums\MethodNotificationEnum;
use App\Modules\Notification\Services\NotificationService;
use App\Modules\User\Repositories\UserRepository;
use App\Modules\User\Requests\Password\PasswordChangeRequest;
use App\Modules\User\Requests\Password\PasswordForgotRequest;

use function App\Helpers\array_error;
use function App\Helpers\valueIfSet;

class PassworController extends Controller
{
    public function __construct(
        public NotificationService $serviceNotify,
    ) { }
    public function forgot(
        PasswordForgotRequest $request,
        UserRepository $userRepository,
    )
    {
        $validated = $request->validated();

        //выкидываем ошибку - если у нас прислали email и phone вместе
        abort_if( !isset($validated['email']) && !isset($validated['phone']) , 422, 'Only Email or Phone.');

        $user = $userRepository->getUser(valueIfSet($validated['phone']) , valueIfSet($validated['email']));

        //выкидываем 404 если пользователь по полученным данным не найден
        abort_unless( (bool) $user , 404 , 'Пользователь не найден.');

        //указываем тип отправки для нотифкации
        $type = valueIfSet($validated['email']) ?
                'email'
                    :
                ( valueIfSet($validated['phone']) ? 'phone' : null );


        //вызываем выбор типа отрпавки и саму отправку
        $this->serviceNotify->selectSendNotification()
        ->run(
            new PhoneOrEmailDTO(
                type: MethodNotificationEnum::returnObjectByString($type)
            ),
            $user,
        );

        return response()->json(array_error(null , 'Код для восстановление пароля был отправлен.'), 200);

        // $nptify = $notificationRepository->getNotification()

        // //создаём запись по смене пароля
        // $passModel = $createPasswordAction->run(
        //     new CreatePasswordDTO(

        //     )
        // );

    }

    public function change(PasswordChangeRequest $request)
    {
        $validated = $request->validated();

        $status = $this->serviceNotify
        ->checkNotification()
        ->code($validated['code'] ?? null)
        ->run();

        dd($status);
    }
}
