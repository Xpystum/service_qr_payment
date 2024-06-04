<?php

namespace App\Modules\User\Models;

use App\Modules\Notification\Traits\HasUuid;
use App\Modules\User\Enums\Password\PasswordStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [

       'notification_id',
       'code',
       'user_id',
       'status',
       'ip',

    ];

    protected $guarded = [
        'uuid',
        'id'
    ];


    protected $casts = [
        'status' => PasswordStatusEnum::class,
    ];
}
