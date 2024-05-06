<?php

namespace App\Modules\Notifications\DTO;

use App\Modules\Notifications\Enums\ActiveStatusEnum;
use App\Modules\User\Models\User;
use Illuminate\Contracts\Support\Arrayable;

class CreatEmailDto implements Arrayable
{

    public function __construct(

        public readonly string $value,

        public readonly int $user_id,

        public readonly ActiveStatusEnum $status,

    ) { }

    public function toArray(): array {
        return [
            'value' => $this->value,
            'user_id' => $this->user_id,
            'status' => $this->status,
        ];
    }

}
