<?php

namespace App\Modules\Transactions\Resources;

use App\Modules\Transactions\Resources\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentTransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'amount' => $this->amount,
            'driver' => $this->driver,
            // 'transaction' => TransactionResource::make($this->payable),
        ];
    }
}
