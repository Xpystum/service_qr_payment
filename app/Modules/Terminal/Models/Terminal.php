<?php

namespace App\Modules\Terminal\Models;

use App\Modules\Notification\Traits\HasUuid;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Terminal extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'user_id', 'name'
    ];

    protected $guarded = [
        'id', 'uuid'
    ];

    protected $cast = [

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
