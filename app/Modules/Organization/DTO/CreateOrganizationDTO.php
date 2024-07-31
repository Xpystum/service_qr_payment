<?php

namespace App\Modules\Organization\DTO;

use App\Modules\Organization\DTO\Base\BaseDTO;
use App\Modules\Organization\Enums\TypeOrganizationEnum;
use Illuminate\Contracts\Support\Arrayable;

class CreateOrganizationDTO extends BaseDTO implements Arrayable
{
    public function __construct(


        public readonly string $name,
        public readonly string $address,
        public readonly int $owner_id,
        public readonly ?string $phone_number,
        public readonly ?string $email,
        public readonly ?string $website,
        public readonly TypeOrganizationEnum $type,
        public readonly ?string $description,
        public readonly ?string $industry,
        public readonly ?string $founded_date,
        public readonly string $inn,
        public readonly ?string $kpp,
        public readonly ?string $registration_number,
        public readonly ?string $registration_number_individual,

    ) { }

    public static function make(array $data, int $user_id)
    {
        return new self(

            name: $data['name'],

            owner_id: $user_id,

            address: $data['address'],

            phone_number: $data['phone_number'] ?? null,

            email: $data['email'] ?? null,

            website: $data['website'] ?? null,

            type: TypeOrganizationEnum::returnObjectByString($data['type']),

            description: $data['description'] ?? null,

            industry: $data['industry'] ?? null,

            founded_date: $data['founded_date'] ?? null,

            inn: $data['inn'],

            kpp: $data['kpp'] ?? null,

            registration_number: $data['registration_number'] ?? null,

            registration_number_individual: $data['registration_number_individual'] ?? null,

        );
    }

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
            'registration_number_individual' => $this->registration_number_individual,
        ];
    }


}
