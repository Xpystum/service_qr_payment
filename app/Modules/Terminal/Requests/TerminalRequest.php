<?php

namespace App\Modules\Terminal\Requests;

use App\Http\Requests\ApiRequest;

class TerminalRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required' , 'string' , 'max:255' , 'min:3'],
            'organization_uuid' => ['required', 'uuid'],
        ];
    }
}
