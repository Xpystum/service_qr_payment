<?php
namespace App\Modules\Organization\DTO\ValueObject;

use App\Modules\Organization\Enums\TypeOrganizationEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class OrganizationVO implements Arrayable
{
    public function __construct(

        public readonly string $name,
        public readonly string $address,
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

    public static function fromArray(array $data): self
    {
        return new self(
            name: Arr::get($data, 'name' , null),
            address: Arr::get($data, 'address'),
            phone_number: Arr::get($data, 'phone_number' , null),
            email: Arr::get($data, 'email' , null),
            website: Arr::get($data, 'website' , null),
            type: TypeOrganizationEnum::returnObjectByString(Arr::get($data, 'type', null)),
            description: Arr::get($data, 'description' , null),
            industry: Arr::get($data, 'industry' , null),
            founded_date: Arr::get($data, 'founded_date' , null),
            inn: Arr::get($data, 'inn' , null),
            kpp: Arr::get($data, 'kpp' , null),
            registration_number: Arr::get($data, 'registration_number' , null),
            registration_number_individual: Arr::get($data, 'registration_number_individual' , null),
        );
    }

    public function toArray(): array {

        return [
            'name' => $this->name,
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
