<?php

namespace App\Modules\User\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\User\Rules\EmailOrPhoneRule;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'email' => ['required_without_all:phone', 'exclude_with:phone', 'string', 'email:filter', 'max:100', 'exists:users,email'],
            'phone' => ['required_without_all:email', 'exclude_with:email', 'numeric', 'regex:/^(\+7|8)(\d{10})$/', 'exists:users,phone'],
            'password' => ['required', 'string', Password::defaults()],

        ];
    }

}
