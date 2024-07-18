<?php
namespace App\Modules\Payment\DTO\DriverInfo;

use App\Modules\Payment\DTO\Base\BaseDTO;
use App\Modules\Payment\Models\PaymentMethod;
use App\Modules\User\Models\User;

/**
 * [Description CreateDriverInfoDTO]
 */
class CreateDriverInfoDTO extends BaseDTO
{
    public function __construct(

        public ?PaymentMethod $payment_method = null,
        public ?string $parametr = null,
        public ?string $value = null,
        public ?User $user = null,

    ) { }

}
