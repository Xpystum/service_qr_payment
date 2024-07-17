<?php

namespace App\Modules\Transactions\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "driver_currency_id" => $this->driver_currency_id,
            "amount" => (string) $this->amount,
            "uuid" => $this->uuid,
            "status" => $this->status,
            "created_at" => $this->created_at,
        ];
    }
}
