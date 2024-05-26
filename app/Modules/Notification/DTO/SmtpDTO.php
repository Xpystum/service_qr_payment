<?php

namespace App\Modules\Notification\DTO;


use App\Modules\Notification\DTO\Base\BaseDTO;
use App\Modules\User\Models\User;

class SmtpDTO extends BaseDTO
{
    //лучше разбить модель в будущем (на мелкие части и не передавать большую модель) если указать readonly мы не нарушаем Single Responsibility Principle
    public function __construct(
        public readonly User $user,
    ) { }
}
