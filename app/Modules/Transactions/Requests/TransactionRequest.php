<?php

namespace App\Modules\Transactions\Requests;

use App\Http\Requests\ApiRequest;

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
}
