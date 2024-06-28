<?php

namespace App\Modules\Payment\Interface;

use App\Helpers\Values\AmountValue;

//Интерфейс оплаты
interface Payable
{

    public function getPayableName(): string;
    public function getPayableCurrencyId(): string;
    public function getPayableAmount(): AmountValue;
    public function getPayableType(): string;
    public function getPayableId(): int;
    public function getPayableUrl(): string;

}
