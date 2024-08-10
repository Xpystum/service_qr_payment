<?php

namespace App\Modules\User\Requests\Entry;

use App\Modules\User\Rules\EmailRule;
use App\Modules\User\Rules\PhoneRule;
use App\Http\Requests\ApiRequest;
use App\Modules\User\DTO\ValueObject\User\UserVO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * После успешкой валидации делаем ещё проверку.
     * @return [type]
     */
    protected function passedValidation()
    {
        $email = $this->input('email');
        $phone = $this->input('phone');
        //выкидываем ошибку - если у нас прислали email и phone вместе
        abort_if( isset($email) && isset($phone) , 400, 'Only Email or Phone');
    }


    public function rules(): array
    {
        return [
            'email' => (new EmailRule)->addRule('unique:App\Modules\User\Models\User')->toArray(),
            'phone' => (new PhoneRule)->addRule('unique:App\Modules\User\Models\User')->toArray(),
            // 'email' => ['required_without_all:phone', 'exclude_with:phone', 'string', 'email:filter', 'max:100', 'unique:App\Modules\User\Models\User'],
            // 'phone' => ['required_without_all:email', 'exclude_with:email', 'numeric', 'regex:/^(\+7|8)(\d{10})$/', 'unique:App\Modules\User\Models\User'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            'agreement' => ['required', 'boolean'],
        ];
    }

    public function getValueObject(): UserVO
    {
        return UserVO::fromArray($this->validated());
    }

}
