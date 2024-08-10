<?php

namespace App\Modules\User\Requests\Entry;

use App\Http\Requests\ApiRequest;
use App\Modules\User\Rules\EmailRule;
use App\Modules\User\Rules\PhoneRule;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends ApiRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'email' => (new EmailRule)->addRule('exists:users,email')->toArray(),
            'phone' => (new PhoneRule)->addRule('exists:users,email')->toArray(),
            // 'email' => ['required_without_all:phone', 'exclude_with:phone', 'string', 'email:filter', 'max:100', 'exists:users,email'],
            // 'phone' => ['required_without_all:email', 'exclude_with:email', 'numeric', 'regex:/^(\+7|8)(\d{10})$/', 'exists:users,phone'],
            'password' => ['required', 'string', Password::defaults()],

        ];
    }

}
