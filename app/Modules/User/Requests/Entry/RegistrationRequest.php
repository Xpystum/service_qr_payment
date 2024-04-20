<?php




namespace App\Modules\User\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\User\Rules\EmailOrPhoneRule;
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

            'email' => ['required_without_all:phone', 'exclude_with:phone', 'string', 'email:filter', 'max:100', 'unique:App\Modules\User\Models\User'],
            'phone' => ['required_without_all:email', 'exclude_with:email', 'numeric', 'regex:/^(\+7|8)(\d{10})$/', 'unique:App\Modules\User\Models\User'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],

        ];
    }

    // protected function passedValidation(): void
    // {
    //     $this->replace([
    //         'email' => $this->filled('email') ? 'null' : $this->email ,
    //         'phone' => $this->filled('phone') ? $this->phone : 'null',
    //         'password' => $this->password,
    //     ]);
    // }
}
