<?php

namespace App\Modules\User\Requests\Delete;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
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
