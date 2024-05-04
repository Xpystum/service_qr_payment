<?php

namespace App\Modules\Notifications\Models;

use App\Modules\Notification\Enums\ActiveStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = [

        'uuid',
        'value',
        'user_id',
        'status',
        'code',

    ];

    protected $casts = [

        'status' => ActiveStatusEnum::class,
        'code' => 'encrypted',

    ];
}
