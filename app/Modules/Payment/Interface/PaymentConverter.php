<?php

namespace App\Modules\Payment\Interface;

use App\Helpers\Values\AmountValue;

interface PaymentConverter
{
    public function convert(AmountValue $amount, string $from, string $to): AmountValue;
}
