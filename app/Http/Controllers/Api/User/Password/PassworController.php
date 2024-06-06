<?php

namespace App\Http\Controllers\Api\User\Password;
use App\Http\Controllers\Controller;
use App\Modules\Notification\DTO\PhoneOrEmailDTO;
use App\Modules\Notification\Enums\MethodNotificationEnum;
use App\Modules\Notification\Services\NotificationService;
use App\Modules\User\Actions\Passwords\UpdatePasswordAction;
use App\Modules\User\Actions\User\UpdateUserAction;
use App\Modules\User\DTO\UpdateUserDTO;
use App\Modules\User\Events\PasswordCreatedEvent;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\UserRepository;
use App\Modules\User\Requests\Password\PasswordChangeRequest;
use App\Modules\User\Requests\Password\PasswordForgotRequest;
use App\Services\Auth\AuthService;

use function App\Helpers\array_error;
use function App\Helpers\valueIfSet;

class PassworController extends Controller
{
    public function __construct(
        public NotificationService $serviceNotify,
        public AuthService $authService,
        public UserRepository $userRepository,
    ) { }
    public function forgot(PasswordForgotRequest $request)
    {
        $validated = $request->validated();

        //выкидываем ошибку - если у нас прислали email и phone вместе
        abort_if( !isset($validated['email']) && !isset($validated['phone']) , 422, 'Only Email or Phone.');

        /**
        * получаем авторизированного user у которого прошла авторизация
        * @var User
        */
        $user = $this->userRepository->getUserAndRegister(valueIfSet($validated['phone']) , valueIfSet($validated['email']));

        //выкидываем 404 если пользователь по полученным данным не найден
        abort_unless( (bool) $user , 404 , 'Пользователь не найден или не до конца прошёл регистрацию.');

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
        //событие на создание password записи
        event(new PasswordCreatedEvent($user, $request->ip()));

        return response()->json(array_error(null , 'Код для восстановление пароля был отправлен.'), 200);

    }

    public function change(PasswordChangeRequest $request, UpdatePasswordAction $updatePasswordAction, UpdateUserAction $updateUserAction)
    {
        $validated = $request->validated();

        /**
        * получаем авторизированного user у которого прошла авторизация
        * @var User
        */
        $user = $this->userRepository->getUserAndRegister(valueIfSet($validated['phone']) , valueIfSet($validated['email']));

        //выкидываем 404 если пользователь по полученным данным не найден
        abort_unless( (bool) $user , 404 , 'Пользователь не найден или не до конца прошёл регистрацию.');

        $modelNotify = $this->serviceNotify
        ->checkNotification()
        ->code($validated['code'] ?? null)
        ->user($user)
        ->run();

        abort_unless( (bool) $modelNotify, 'Неверный код.', 422);

        //обновление записи в таблице pass
        $updatePasswordAction::run($modelNotify);

        //обновлем пароль у user - надо выносить в event
        $updateUserAction::run(
            new UpdateUserDTO(
                id: $modelNotify->user_id,
                password: $validated['password'],
            )
        );

        return response()->json(array_error(null , 'Пароль был успешно изменён.'), 200);

    }
}
