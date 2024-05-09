<?php

namespace App\Modules\Notifications\Models;

use App\Modules\Notifications\Enums\ActiveStatusEnum;
use App\Modules\Notifications\Traits\UpdateCode;
use App\Modules\User\Models\User;
use App\Traits\HasCode;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Email extends Model
{
    use HasUuid, HasCode , HasFactory;


    protected $fillable = [
        'uuid',
        'value',
        'user_id',
        'status',
        'code',
    ];

    protected $casts = [

        'status' => ActiveStatusEnum::class,

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
