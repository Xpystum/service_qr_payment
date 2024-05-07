<?php

namespace App\Modules\Notifications\Events;

use App\Modules\Notifications\Enums\ActiveStatusEnum;
use App\Modules\Notifications\Models\Email;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailCreatedEvent implements ShouldDispatchAfterCommit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(

        public Email $email,
        public ActiveStatusEnum $status,

    ) { }

}
