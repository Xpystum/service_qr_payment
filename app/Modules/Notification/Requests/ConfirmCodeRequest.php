<?php

namespace App\Modules\Notification\Requests;

use App\Http\Requests\ApiRequest;

class ConfirmCodeRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'code' => ['required', 'integer', 'min_digits:6', 'max_digits:6'],
        ];
    }
}
