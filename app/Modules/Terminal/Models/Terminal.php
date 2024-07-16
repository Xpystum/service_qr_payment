<?php

namespace App\Modules\Terminal\Models;

use App\Modules\Notification\Traits\HasUuid;
use App\Modules\Organization\Models\Organization;
use App\Modules\Transactions\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Terminal extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'organization_id', 'name',
    ];

    protected $guarded = [
        'id', 'uuid'
    ];

    protected $cast = [

    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

}
