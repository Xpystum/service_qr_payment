<?php

namespace App\Modules\Payment\Models;

use App\Modules\Notification\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverInfo extends Model
{
    use HasFactory, HasUuid;

    protected $connection = 'driver_info';


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

}
