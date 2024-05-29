<?php

namespace App\Modules\Notification\DTO;

use App\Modules\Notification\DTO\Base\BaseDTO;
use App\Modules\Notification\Enums\MethodNotificationEnum;

/**
 * Dto для выбора email или phone
 *
 * @property ?string $email
 * @property ?string $phone
 * @property ?MethodNotificationEnum $email
 */
class PhoneOrEmailDTO extends BaseDTO
{
    public function __construct(
        public ?string $email = null,
        public ?string $phone = null,
        public ?MethodNotificationEnum $type = null,
    ) { }

}
