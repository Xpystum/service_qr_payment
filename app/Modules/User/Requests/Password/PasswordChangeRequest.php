<?php

namespace App\Modules\User\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordChangeRequest extends FormRequest
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
            'email' => ['required_without_all:phone', 'exclude_with:phone', 'string', 'email:filter', 'max:100'],
            'phone' => ['required_without_all:email', 'exclude_with:email', 'numeric', 'regex:/^(\+7|8)(\d{10})$/'],
            'password' => ['required', 'string', Password::defaults()],
            'code' => ['required', 'integer', 'min_digits:6', 'max_digits:6'],
        ];
    }
}