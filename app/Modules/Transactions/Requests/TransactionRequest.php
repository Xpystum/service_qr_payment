<?php

namespace App\Modules\Transactions\Requests;

use App\Http\Requests\ApiRequest;
use App\Modules\Transactions\DTO\ValueObject\TransactionVO;

class TransactionRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric'],
            'terminal_uuid' => ['required', 'uuid'],
        ];
    }

    public function getValueObject() : TransactionVO
    {
       return TransactionVO::fromArray($this->validated());
    }
}
