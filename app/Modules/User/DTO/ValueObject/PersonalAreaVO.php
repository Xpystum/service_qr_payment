<?php
namespace App\Modules\User\DTO\ValueObject;


use Illuminate\Support\Arr;

final class PersonalAreaVO
{
    public function __construct(

        public readonly ?string $personal_area_id = null,

        public readonly ?string $role = null,

    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            personal_area_id: Arr::get($data, 'personal_area_id'),
            role: Arr::get($data, 'role'),
        );
    }
}
