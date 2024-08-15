<?php

namespace App\Modules\User\Requests\Create;

use App\Modules\User\Enums\RoleUserEnum;
use App\Modules\User\Rules\EmailRule;
use App\Modules\User\Rules\PhoneRule;
use App\Http\Requests\ApiRequest;
use App\Modules\User\DTO\ValueObject\User\UserVO;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class CreateUserRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'email' => (new EmailRule)->addRule('unique:App\Modules\User\Models\User')->toArray(),
            'phone' => (new PhoneRule)->addRule('unique:App\Modules\User\Models\User')->toArray(),

            'role' =>  ['required', 'string' ,Rule::enum(RoleUserEnum::class)->only([RoleUserEnum::manager, RoleUserEnum::cashier])],

            'password' => ['required', 'string', Password::defaults(), 'confirmed'],

        ];
    }

    public function getValueObject(): UserVO
    {
        return UserVO::fromArray($this->validated());
    }
}
