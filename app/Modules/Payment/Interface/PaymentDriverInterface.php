<?php

namespace App\Modules\Payment\Interface;

use App\Modules\Payment\Models\Payment;
use Illuminate\Contracts\View\View;

interface PaymentDriverInterface
{

    public function process(Payment $payment);

}
