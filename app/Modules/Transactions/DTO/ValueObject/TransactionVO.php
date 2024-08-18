<?php

namespace App\Modules\Transactions\DTO\ValueObject;

use App\Helpers\Values\AmountValue;
use Illuminate\Support\Arr;

class TransactionVO
{
    public function __construct(
        public readonly AmountValue $amount,
        public readonly string $terminal_uuid,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            amount: AmountValue::make(Arr::get($data, 'amount' , null)),
            terminal_uuid: Arr::get($data, 'terminal_uuid', null),
        );
    }

}
