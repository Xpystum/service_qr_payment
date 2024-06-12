<?php

namespace App\Modules\User\Requests\Edit;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'id' => ['required', 'integer','exists:App\Modules\User\Models\User'],

            'phone' => ['nullable' ,'numeric', 'regex:/^(\+7|8)(\d{10})$/' , 'unique:App\Modules\User\Models\User'],
            'email' => ['nullable' ,'string', 'email:filter', 'max:100' , 'unique:App\Modules\User\Models\User'],

            'first_name' => ['nullable' ,'string', 'max:255' , 'min:2'],
            'last_name' => ['nullable' ,'string', 'max:255', 'min:2'],
            'father_name' => ['nullable' ,'string', 'max:255', 'min:2'],

        ];
    }

    public function withValidator($validator)
    {
            //вызываем после валидации
            $validator->after(function ($validator) {


                $data = $validator->getData();
                $fieldsToCheck = ['email', 'phone' , 'first_name', 'last_name', 'father_name'];
                $hasAny = false;


                //проверяем сущесвует хотя бы 1 не пустое поле
                foreach ($fieldsToCheck as $field) {
                    if (!empty($data[$field])) {
                        $hasAny = true;
                        break;
                    }
                }

                if (!$hasAny) {
                    $validator->errors()->add('id', 'При указании id, нужно указать любое дополнительное поле.');
                }

            });
    }
}
