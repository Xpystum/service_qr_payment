<?php




namespace App\Modules\User\Requests\Entry;

use App\Modules\User\Rules\EmailRule;
use App\Modules\User\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => (new EmailRule)->toArray(),
            'phone' => (new PhoneRule)->toArray(),
            // 'email' => ['required_without_all:phone', 'exclude_with:phone', 'string', 'email:filter', 'max:100', 'unique:App\Modules\User\Models\User'],
            // 'phone' => ['required_without_all:email', 'exclude_with:email', 'numeric', 'regex:/^(\+7|8)(\d{10})$/', 'unique:App\Modules\User\Models\User'],

            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            'agreement' => ['required', 'boolean'],
        ];
    }

}
