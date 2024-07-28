<?php

namespace App\Modules\Terminal\Resources;

use App\Modules\Organization\Resources\OrganizationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TerminalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            "uuid" => $this->uuid,
            'organization_uuid' => $this->organization->uuid,
        ];
    }
}
