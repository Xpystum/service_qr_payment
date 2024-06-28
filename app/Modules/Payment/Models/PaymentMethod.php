<?php

namespace App\Modules\Payment\Models;

use App\Modules\Payment\Enums\PaymentDriverEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
