<?php

namespace App\Modules\Notification\DTO;


use App\Modules\Notification\DTO\Base\BaseDTO;
use App\Modules\Notification\DTO\Phone\AeroPhoneDTO;
use App\Modules\User\Models\User;

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
