<?php

namespace App\Modules\Terminal\Requests;

use App\Http\Requests\ApiRequest;
use App\Modules\Terminal\DTO\ValueObject\TerminalVO;

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

    public function getValueObject(): TerminalVO
    {
        return TerminalVO::fromArray($this->validated());
    }

}
