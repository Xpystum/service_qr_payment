<?php

namespace App\Modules\Payment\Requests;

use App\Http\Requests\ApiRequest;
use Illuminate\Validation\Rule;

class DriverInfoCreateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        #TODO Нужно указать что мы принимаем массив и продумать это т.к с фронта придётся множество запросов отправлять на заполнение
        return [
            'type_id' => ['required', 'integer'],
            'parametr' => ['required', 'string'],
            'value' => ['required', 'string'],
        ];
    }
}
