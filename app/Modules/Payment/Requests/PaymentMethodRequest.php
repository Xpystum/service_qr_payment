<?php
namespace App\Modules\Payment\Requests;

use App\Modules\Payment\Rules\ValidateStatusPayment;
use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'method_id' => ['required', 'integer' , new ValidateStatusPayment],
        ];
    }
}
