<?php

namespace App\Modules\Payment\Models;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [

        'name', 'active',

        'driver', 'driver_currency_id'

    ];

    protected $casts = [

        'active' => 'boolean',

        'driver' => PaymentDriverEnum::class,

    ];


}
