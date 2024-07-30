<?php

namespace App\Modules\Payment\Drivers\Ykassa\Database\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class YkassaSpbResoure extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid_payment' => $this->payable_uuid,
            'spb_url' => $this->url,
            'value_payment' => $this->value,
            'status_paid' => $this->paid,
            'status_payment' => $this->status,
        ];
    }
}
