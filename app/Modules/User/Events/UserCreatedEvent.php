<?php

namespace App\Modules\User\Events;

use App\Modules\Notifications\Models\Email;
use App\Modules\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreatedEvent implements ShouldDispatchAfterCommit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;
    // public Email|null $email;

    /**
     * Create a new event instance.
     */
    public function __construct($user, $email = null)
    {
        $this->user = $user;
        // $this->email = $email;
    }

}
