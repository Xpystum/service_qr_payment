<?php

namespace App\Modules\Notification\Models;

use App\Modules\Notification\Enums\ActiveStatusEnum;
use App\Modules\Notification\Traits\HasCode;
use App\Modules\Notification\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table = 'notification';
    use HasFactory;
    use HasUuid;
    use HasCode;

    protected $fillable = [

        'uuid',
        'method_id',
        'user_id',
        'status',
        'code',
        'value',

    ];

    protected $casts = [
        'status' => ActiveStatusEnum::class,
    ];

    public function method(): BelongsTo
    {
        return $this->belongsTo(NotificationMethod::class);
    }
}
