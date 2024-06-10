<?php

namespace App\Modules\Organization\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Modules\Organization\Enums\TypeOrganizationEnum;
use App\Modules\Organization\Rules\OgrnepRule;
use App\Modules\Organization\Rules\OgrnRule;
use Illuminate\Validation\Rule;

class UpdateOrganizationRequest extends FormRequest
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
        $rules = [
            'uuid' => ['required', 'uuid'],
            'name' => ['nullable' , 'string' , 'max:101' , 'min:2'],
            'address' => ['nullable' , 'string' , 'max:255' , 'min:12'],
            'phone_number' => ['nullable' , 'string'],
            'email' => ['nullable', "string", "email:filter", "max:100"],
            'website' => ['nullable', "string"],
            'type' =>  ['nullable', 'string' , Rule::enum(TypeOrganizationEnum::class)->only([TypeOrganizationEnum::ooo, TypeOrganizationEnum::ip])],
            'description' => ['nullable'],
            'industry' => ['nullable'],
            'founded_date' => ['nullable'],
            'inn' => ['nullable' , 'numeric', 'regex:/^(([0-9]{12})|([0-9]{10}))?$/'],
            'kpp' => ['nullable' , 'numeric', 'regex:/^(([0-9]{12})|([0-9]{10}))?$/'],
            'registration_number' => ['nullable' , 'numeric' , 'regex:/^([0-9]{13})?$/' , (new OgrnRule)],
            'registration_number_individual' => ['nullable' , 'numeric' , 'regex:/^\d{15}$/', (new OgrnepRule)],
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
            //вызываем после валидации
            $validator->after(function ($validator) {


                $data = $validator->getData();

                //перечисляем другие поля
                $fieldsToCheck = [
                    'name', 'address',
                    'phone_number', 'email', 'website',
                    'type',
                    'description', 'industry', 'founded_date',
                    'inn', 'kpp',
                    'registration_number',  'registration_number_individual',
                ];

                $hasAny = false;


                //проверяем сущесвует хотя бы 1 не пустое поле
                foreach ($fieldsToCheck as $field) {
                    if (!empty($data[$field])) {
                        $hasAny = true;
                        break;
                    }
                }

                if (!$hasAny) {
                    $validator->errors()->add('error', 'При указании uuid и owner_id - должны быть дополнительно указаны поля для изменения');
                }

            });
    }
}
