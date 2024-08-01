<?php

namespace App\Modules\Notification\Action;

use App\Modules\Notification\Models\Notification;
use App\Modules\Notification\Traits\ConstructNotifyRepository;
use App\Modules\User\Actions\User\UpdateEmailConfirmUserAction;
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

    /**
     * Вернёт model - если проверка прошла, иначе null
     * @return Notification|null
     */
    public function run() : ?Notification
    {
        //проверяем подлинность полученного кода
        /**
         * @var Notification
         */
        $model = $this->repository->checkCodeNotification($this->code, $this?->user?->id);

        //#TODO Потом изменить (пока что что бы получить актуальный статус (я получаю все что могут быть и отнимаю количество попыток - потом удаляю))
        if( !$model ) { $this->reduceQuantity($this->user); }

        if($model)
        {
            //возвращаем ошибку проверки (если заявка уже completed)
            if($this->isStatusCompleted($model)) { return null; }

            //обновляем у user дату подтвреждение - email - временно берём из user - здесь сделаем репозиторий от user
            $statusUpdate = UpdateEmailConfirmUserAction::run($this->user, $model);
            if(!$statusUpdate) { return null; }
            //Вызов action у которого срабатывает событие в очереди для установки статуса completed
            CompleteNotificationAction::run($model);
            return $model;
        }

        return null;
    }

    private function isStatusCompleted(Notification $notify) : bool
    {
        return $this->repository->isStatusCompleted($notify);
    }

    /**
     *
     * Уменьшаем количество попыток - если они закончились возвращаем false
     * @param Notification $notify
     *
     * @return bool
     */
    private function reduceQuantity(User $user) : bool
    {
        #TODO Проблема - получается будут удаляться все заявки что с pending и у них вычитаться количество попыток
        // $notifyAll = (new ReturnAllNotificationByUserAction)->user($user)::run();
        $notifyAll = ReturnAllNotificationByUserAndPendingAction::run($user);

        foreach ($notifyAll as $notify) {
            if($notify->quantity > 0)
            {
                $notify->quantity = $notify->quantity - 1;
                if($notify->quantity == 0)
                {
                    if(DeletedNotificationAction::run($notify))
                    {
                        return false;
                    }
                }
                $notify->save();

            }
        }

        return true;
    }

}
