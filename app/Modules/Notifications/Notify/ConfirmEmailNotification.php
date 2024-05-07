<?php

namespace App\Modules\Notifications\Notify;

use App\Modules\Notifications\Models\Email;
use App\Modules\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(

        private Email $email,

    ) { }

    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {

        $message = (new MailMessage)
                    ->subject('Подтверждение почты')
                    ->greeting('Здравствуйте!')
                    ->line("Введите код подтверждения: {$this->email->code}" );

        return $message;
    }
}
