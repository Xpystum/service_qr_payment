<?php

namespace App\Modules\Organization\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganizationCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection
        ];
        // return $this->isType($this->type);
    }

    // private function isType(TypeOrganizationEnum $type) : array
    // {
    //     if(TypeOrganizationEnum::ooo === $type)
    //     {
    //         return [

    //             'name' => $this->name,
    //             'owner_id' => $this->owner_id,
    //             'address' => $this->address,
    //             'phone_number' => $this->phone_number,
    //             'email' => $this->email,
    //             'website' => $this->website,
    //             'type' => $this->type->value,
    //             'description' => $this->description,
    //             'industry' => $this->industry,
    //             'founded_date' => $this->founded_date,
    //             'inn' => $this->inn,
    //             'kpp' => $this->kpp,
    //             'registration_number' => $this->registration_number,

    //         ];

    //     } else {

    //         return [

    //             'name' => $this->name,
    //             'owner_id' => $this->owner_id,
    //             'address' => $this->address,
    //             'phone_number' => $this->phone_number,
    //             'email' => $this->email,
    //             'website' => $this->website,
    //             'type' => $this->type->value,
    //             'description' => $this->description,
    //             'industry' => $this->industry,
    //             'founded_date' => $this->founded_date,
    //             'inn' => $this->inn,
    //             'registration_number_individual' => $this->registration_number_individual,

    //         ];

    //     }
    // }
}
