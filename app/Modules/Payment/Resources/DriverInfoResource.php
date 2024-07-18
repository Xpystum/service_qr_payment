<?php

namespace App\Modules\Payment\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverInfoResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name_type' => $this->name_type,
            'type_id' => $this->type_id,
            'parametr' => $this->parametr,
            'owner_uuid' => $this->owner->uuid,
            'value' => $this->value,
        ];
    }
}
