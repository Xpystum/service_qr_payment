<?php
namespace App\Modules\Terminal\DTO\ValueObject;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class TerminalVO implements Arrayable
{

    public function __construct(
        public readonly ?string $name,
        public readonly ?string $organization_uuid,
    ) { }



    public static function fromArray(array $data): self
    {
        return new self(
            name: Arr::get($data, 'name' , null),
            organization_uuid: Arr::get($data, 'organization_uuid'),
        );
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'organization_uuid' => $this->organization_uuid,
        ];
    }

}
