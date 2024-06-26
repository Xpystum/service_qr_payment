<?php

namespace App\Modules\Currencies\Source;

use App\Helpers\Values\AmountValue;

class SourcePrice
{
    public function __construct(
        public string $currency,
        public AmountValue $value,
    ) { }

}
