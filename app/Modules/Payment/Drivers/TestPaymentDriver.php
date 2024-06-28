<?php

namespace App\Modules\Payment\Drivers;

use App\Modules\Payment\Interface\PaymentDriverInterface;
use App\Modules\Payment\Models\Payment;
use Illuminate\Contracts\View\View;

class TestPaymentDriver implements PaymentDriverInterface
{

   public function view(Payment $payment): View
   {
        return view('payments::test', compact('payment'));
   }

}
