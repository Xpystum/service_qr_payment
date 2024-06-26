<?php

namespace App\Modules\Terminal\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerminalRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required' , 'string' , 'max:255' , 'min:3'],
        ];
    }
}
