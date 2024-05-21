<?php

namespace App\Modules\Notification\Notify;

use App\Models\User;
use App\Modules\Notification\Models\Notification as ModelsNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMessageSmtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(

        private ModelsNotification $notify,

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
                    ->line("Введите код подтверждения: {$this->notify->code}" );

        return $message;
    }
}
