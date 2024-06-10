<?php

namespace App\Modules\Organization\Resources;

use App\Modules\Organization\Enums\TypeOrganizationEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'uuid' => $this->uuid,
            'name' => $this->name,
            'owner_id' => $this->owner_id,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'website' => $this->website,
            'type' => $this->type->value,
            'description' => $this->description,
            'industry' => $this->industry,
            'founded_date' => $this->founded_date,
            'inn' => $this->inn,
            'kpp' => $this->when(TypeOrganizationEnum::ooo === $this->type, $this->kpp),
            'registration_number' => $this->when(TypeOrganizationEnum::ooo === $this->type, $this->registration_number) ,
            'registration_number_individual' => $this->when(TypeOrganizationEnum::ip === $this->type, $this->registration_number_individual),

        ];
    }

    private function isType(TypeOrganizationEnum $type) : array
    {
        if(TypeOrganizationEnum::ooo === $type)
        {
            return [

                'name' => $this->name,
                'owner_id' => $this->owner_id,
                'address' => $this->address,
                'phone_number' => $this->phone_number,
                'email' => $this->email,
                'website' => $this->website,
                'type' => $this->type->value,
                'description' => $this->description,
                'industry' => $this->industry,
                'founded_date' => $this->founded_date,
                'inn' => $this->inn,
                'kpp' => $this->kpp,
                'registration_number' => $this->registration_number,

            ];

        } else {

            return [

                'name' => $this->name,
                'owner_id' => $this->owner_id,
                'address' => $this->address,
                'phone_number' => $this->phone_number,
                'email' => $this->email,
                'website' => $this->website,
                'type' => $this->type->value,
                'description' => $this->description,
                'industry' => $this->industry,
                'founded_date' => $this->founded_date,
                'inn' => $this->inn,
                'registration_number_individual' => $this->registration_number_individual,

            ];

        }
    }
}
