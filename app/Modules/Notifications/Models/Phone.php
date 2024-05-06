<?php

namespace App\Modules\Notifications\Models;

use App\Modules\Notifications\Enums\ActiveStatusEnum;
use App\Traits\HasCode;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    // use HasUuid;
    // use HasCode;

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
