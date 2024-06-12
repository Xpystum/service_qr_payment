<?php

namespace App\Modules\User\DTO\Passwords;
use App\Modules\Notification\Models\Notification;

class CreatePasswordDTO
{
    public function __construct(

        public readonly ?Notification $notify,

        public readonly int $user_id,

        public readonly string $ip,

    ) { }


}
