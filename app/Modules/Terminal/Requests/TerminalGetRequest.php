<?php

namespace App\Modules\Terminal\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerminalGetRequest extends FormRequest
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
