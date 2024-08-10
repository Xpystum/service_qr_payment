<?php

namespace App\Modules\Notification\Requests;
use Illuminate\Validation\Rule;

use App\Http\Requests\ApiRequest;

class SendNotificationRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
                Rule::in(['phone', 'email']),
            ]
        ];
    }



}
