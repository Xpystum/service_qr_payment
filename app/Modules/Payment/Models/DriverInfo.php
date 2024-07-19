<?php

namespace App\Modules\Payment\Models;

use App\Modules\Notification\Traits\HasUuid;
use App\Modules\Payment\Enums\DriverInfo\DriverInfoParametrEnum;
use App\Modules\Payment\Enums\PaymentDriverEnum;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'name_type' => PaymentDriverEnum::class,
        'parametr' => DriverInfoParametrEnum::class,
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }


}
