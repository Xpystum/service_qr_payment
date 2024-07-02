<?php

namespace App\Modules\Terminal\Models;

use App\Modules\Notification\Traits\HasUuid;
use App\Modules\Transactions\Models\Transaction;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Terminal extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'user_id', 'name',
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

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

}
