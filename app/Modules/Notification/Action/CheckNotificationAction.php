<?php

namespace App\Modules\Notification\Action;

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
        //возвращаем ошибку проверки (если заявка уже completed)
        if($this->isStatusCompleted($this->user)) { return false; }

        //проверяем подлинность полученного кода
        $status = $this->repository->checkCodeNotification($this->code, $this->user->id);

        if($status)
        {
            //обновляем у user дату подтвреждение - email - временно берём из user - здесь сделаем репозиторий от user
            $statusUpdate = UpdateEmailConfirmUserAction::run($this->user);
            if(!$statusUpdate) { return false; }

            //Вызов action у которого срабатывает событие в очереди для установки статуса completed
            CompleteNotificationAction::run($this->user->lastNotify);
            return true;
        }

        return false;
    }

    private function isStatusCompleted(User $user) : bool
    {
        return (bool) $user->lastNotifyAndCompleted;
    }

}
