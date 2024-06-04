<?php

namespace App\Modules\User\DTO;

use App\Modules\Notification\Models\Notification;
use Illuminate\Contracts\Support\Arrayable;

class CreatePasswordDTO
{
    public function __construct(

        public readonly ?Notification $notify,

        public readonly int $user_id,

        public readonly string $ip,

    ) { }


}
