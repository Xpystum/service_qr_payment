<?php

namespace App\Modules\Notification\DTO;

use App\Models\User;
use App\Modules\Notification\DTO\Base\BaseDTO;
use App\Modules\Notification\DTO\Config\AeroConfigDTO;
use App\Modules\Notification\DTO\Phone\AeroPhoneDTO;

class AeroDTO extends BaseDTO
{
    public User $user;
    public AeroPhoneDTO $phoneData;

    public function __construct(User $user, AeroPhoneDTO $phoneData)
    {
        $this->user = $user;
        $this->phoneData = $phoneData;
    }

    public function getUser() : User
    {
        return $this->user;
    }
}
