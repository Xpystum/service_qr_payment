<?php
namespace App\Modules\Notification\Action;

use App\Modules\Notification\Enums\ActiveStatusEnum;
use App\Modules\Notification\Enums\MethodNotificationEnum;
use App\Modules\Notification\Models\Notification;
use App\Modules\Notification\Models\NotificationMethod;
use App\Modules\User\Models\User;

use function App\Helpers\Mylog;

class CreateNotificationAction
{
    private readonly NotificationMethod $method;
    private readonly User $user;

     /**
     * установка метода нотификации
     *
     * @param NotificationMethod $driver
     * @return static
     *
     */
    public function method(NotificationMethod $method) : static
    {
        $this->method = $method;

        return $this;
    }

    public function user(User $model) : static
    {
        $this->user = $model;

        return $this;
    }

    public function run() : ?Notification
    {

        if(!is_null($this->method))
        {
            $value = $this->valueIsNotification($this->method , $this->user);
            $model = Notification::query()
                ->create([
                    'method_id' => $this->method->id,
                    'user_id' => $this->user->id,
                    'status' => ActiveStatusEnum::pending->value,
                    'value' => $value,
                ]);
            return $model;
        }

        return null;
    }

    private function valueIsNotification(NotificationMethod $method, User $user) : string
    {

        return match ($method->name) {

            MethodNotificationEnum::email => $user->email,

            MethodNotificationEnum::phone => $user->phone,

            default => function () {

                Mylog('Ошибка при установлении значение value в Notification');
                throw new \InvalidArgumentException(
                    "Ошибка выбора \"имени\" метода нотификации: [{$this->method->name}] не поддерживается"
                );

            }

        };
    }
}
