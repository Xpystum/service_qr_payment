<?php

namespace App\Modules\User\Observers;

use App\Modules\User\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    // public function created(User $user): void
    // {
    //     //
    // }

    /**
     * Handle the User "updated" event.
     */
    // public function updated(User $user): void
    // {
    //     //в данном сервесе это не понадобилось.
    //     $this->NotificationMethod($user);
    // }

    /**
     * Handle the User "deleted" event.
     */
    // public function deleted(User $user): void
    // {
    //     //
    // }

    /**
     * Handle the User "restored" event.
     */
    // public function restored(User $user): void
    // {
    //     //
    // }

    /**
     * Handle the User "force deleted" event.
     */
    // public function forceDeleted(User $user): void
    // {
    //     //
    // }

    // логика для отправки notification
    // private function NotificationMethod(User $user)
    // {
    //     if ($user->wasChanged('email')) {
    //         // Код, который должен выполниться, если поле email было изменено
    //         dd('email');
    //     } elseif($user->wasChanged('phone')) {
    //         dd('phone');
    //     }


    // }
}
