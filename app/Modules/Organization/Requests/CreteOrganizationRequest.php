<?php

namespace App\Modules\Organization\Requests;

use App\Http\Requests\ApiRequest;
use App\Modules\Organization\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\Enums\TypeOrganizationEnum;
use App\Modules\Organization\Rules\OgrnepRule;
use App\Modules\Organization\Rules\OgrnRule;
use Illuminate\Validation\Rule;

class CreteOrganizationRequest extends ApiRequest
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

            'name' => ['required' , 'string' , 'max:101' , 'min:2'],
            'address' => ['required' , 'string' , 'max:255' , 'min:12'],
            'phone_number' => ['required' , 'string'],
            'email' => ['required', "string", "email:filter", "max:100"],
            'website' => ['required', "string"],
            'type' =>  ['required', 'string' , Rule::enum(TypeOrganizationEnum::class)->only([TypeOrganizationEnum::ooo, TypeOrganizationEnum::ip])],
            'description' => ['nullable', 'string'],
            'industry' => ['nullable', 'string'],
            'founded_date' => ['nullable', 'date'],
            'inn' => ['required' , 'numeric', 'regex:/^(([0-9]{12})|([0-9]{10}))?$/'],
        ];

        // Если тип ооо, добавляем к правилам валидации kpp и ogrn
        if (strtolower($this->input('type')) == strtolower(TypeOrganizationEnum::ooo->value)) {
            $rules['kpp'] = ['required', 'numeric' , 'regex:/^([0-9]{9})?$/'];
            $rules['registration_number'] = ['required' , 'numeric' , 'regex:/^([0-9]{13})?$/' , (new OgrnRule)];
        }

        // если ИП, добавляем огрнип
        if( strtolower($this->input('type')) == strtolower(TypeOrganizationEnum::ip->value))
        {
            $rules['registration_number_individual'] = ['required' , 'numeric' , 'regex:/^\d{15}$/', (new OgrnepRule)];
        }

        return $rules;
    }

    public function getValueObject(): OrganizationVO
    {
        return  OrganizationVO::fromArray($this->validated());
    }

}
