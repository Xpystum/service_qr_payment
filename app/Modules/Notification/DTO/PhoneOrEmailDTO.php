<?php

namespace App\Modules\Notification\DTO;

use App\Modules\Notification\DTO\Base\BaseDTO;
class PhoneOrEmailDTO extends BaseDTO
{
    public function __construct(
        public ?string $email,
        public ?string $phone,
    ) { }

}
