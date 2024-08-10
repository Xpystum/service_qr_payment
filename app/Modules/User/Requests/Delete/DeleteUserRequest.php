<?php

namespace App\Modules\User\Requests\Delete;

use App\Http\Requests\ApiRequest;

class DeleteUserRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid' => ['required', 'uuid']
        ];
    }
}
