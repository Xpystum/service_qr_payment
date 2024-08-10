<?php

namespace App\Modules\Terminal\Requests;

use App\Http\Requests\ApiRequest;

class TerminalGetRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'organization_uuid' => ['required', 'uuid'],
        ];
    }
}
