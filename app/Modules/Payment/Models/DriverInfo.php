<?php

namespace App\Modules\Payment\Models;

use App\Modules\Notification\Traits\HasUuid;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverInfo extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'driver_infos';


    protected $fillable = [

        'name_type',
        'type_id',
        'parametr',
        'owner_id',
        'value',

    ];

    protected $guarded = [

        'uuid', 'id'

    ];

    protected $casts = [

    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

}
