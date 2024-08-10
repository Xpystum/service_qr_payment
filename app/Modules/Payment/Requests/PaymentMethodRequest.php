<?php
namespace App\Modules\Payment\Requests;

use App\Modules\Payment\Rules\ValidateStatusPayment;
use App\Http\Requests\ApiRequest;

class PaymentMethodRequest extends ApiRequest
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
