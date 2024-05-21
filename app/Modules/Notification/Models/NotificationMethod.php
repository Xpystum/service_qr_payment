<?php

namespace App\Modules\Notification\Models;


use App\Modules\Notification\Enums\MethodNotificationEnum;
use App\Modules\Notification\Enums\NotificationDriverEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationMethod extends Model
{

    protected $table = 'notification_method';
    use HasFactory;

    protected $fillable = [

        'name',
        'driver',
        'active',

    ];

    protected $casts = [

        'name' => MethodNotificationEnum::class,
        'driver' => NotificationDriverEnum::class,
        'active' => 'boolean',

    ];
}
