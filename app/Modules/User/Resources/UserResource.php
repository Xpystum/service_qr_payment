<?php

namespace App\Modules\User\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // * strtotime() - в PHP используется для преобразования текстового представления даты и времени в метку времени (timestamp)

        return [

            'uuid' => $this->uuid,
            'email' => $this->email,
            'phone' => $this->phone,

            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,

            'role' => $this->role,
            'auth' => $this->auth,

            // 'email_confirmed_at' => ($this->email_confirmed_at) ? date('Y-m-d H:i:s', strtotime($this->email_confirmed_at)) : null,
            // 'phone_confirmed_at' => ($this->phone_confirmed_at) ? date('Y-m-d H:i:s', strtotime($this->phone_confirmed_at)) : null,
        ];
    }
}
