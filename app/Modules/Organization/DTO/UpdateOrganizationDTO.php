<?php

namespace App\Modules\Organization\DTO;
use App\Modules\Organization\DTO\Base\BaseDTO;
use App\Modules\Organization\Enums\TypeOrganizationEnum;
use Illuminate\Contracts\Support\Arrayable;

class UpdateOrganizationDTO extends BaseDTO implements Arrayable
{
    public function __construct(

        public readonly string $uuid,
        public readonly int $owner_id,
        public readonly ?string $name,
        public readonly ?string $address,
        public readonly ?string $phone_number,
        public readonly ?string $email,
        public readonly ?string $website,
        public readonly ?TypeOrganizationEnum $type,
        public readonly ?string $description,
        public readonly ?string $industry,
        public readonly ?string $founded_date,
        public readonly ?string $inn,
        public readonly ?string $kpp,
        public readonly ?string $registration_number,
        public readonly ?string $registration_number_individual,

    ) { }

    public function filterNull() : array
    {
        $collection = collect($this->toArray());

        $filtered = $collection->filter(function ($value) {
            return !is_null($value);
        });

        return $filtered->toArray();
    }

    public function toArray(): array {

        return [
            'name' => $this->name,
            'owner_id' => $this->owner_id,
            'uuid' => $this->uuid,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'website' => $this->website,
            'type' => $this->type?->value,
            'description' => $this->description,
            'industry' => $this->industry,
            'founded_date' => $this->founded_date,
            'inn' => $this->inn,
            'kpp' => $this->kpp,
            'registration_number' => $this->registration_number,
            'registration_number_individual' => $this->registration_number_individual,
        ];
    }


}
