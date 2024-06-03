<?php

namespace App\Modules\Notification\Action;

use App\Modules\Notification\Models\Notification;
use App\Modules\Notification\Traits\ConstructNotifyRepository;
use App\Modules\User\Actions\UpdateEmailConfirmUserAction;
use App\Modules\User\Models\User;

class CheckNotificationAction
{

    use ConstructNotifyRepository;

    private readonly User $user;
    private readonly int $code;

    public function user(User $user) : static
    {
        $this->user = $user;

        return $this;
    }

    public function code(int $code) : static
    {
        $this->code = $code;

        return $this;
    }

    public function run() : bool
    {
        //проверяем подлинность полученного кода
        /**
         * @var Notification
         */
        $model = $this->repository->checkCodeNotification($this->code, $this?->user?->id);

        if($model)
        {
            //возвращаем ошибку проверки (если заявка уже completed)
            if($this->isStatusCompleted($model)) { return false; }

            //обновляем у user дату подтвреждение - email - временно берём из user - здесь сделаем репозиторий от user
            $statusUpdate = UpdateEmailConfirmUserAction::run($this->user, $model);
            if(!$statusUpdate) { return false; }
            //Вызов action у которого срабатывает событие в очереди для установки статуса completed
            CompleteNotificationAction::run($model);
            return true;
        }

        return false;
    }

    private function isStatusCompleted(Notification $notify) : bool
    {
        return $this->repository->isStatusCompleted($notify);
    }

}
