<?php
namespace App\Modules\Payment\Models;

use App\Modules\Payment\Enums\PaymentDriverEnum;
use App\Modules\Payment\Enums\PaymentStatusEnum;

class Payment extends Model
{

    use HasFactory;

    protected $fillable = [

        'uuid',

        'status',

        'currency_id', 'amount',

        'payable_type', 'payable_id',

        'method_id',


        'driver' ,

        'driver_payment_id',

        'driver_currency_id',

        'driver_amount'


    ];

    protected $casts = [

        'status' => PaymentStatusEnum::class,

        'amount' => AmountValue::class,

        'driver_amount' => AmountValue::class,

        'driver' => PaymentDriverEnum::class,

    ];

    public function payable() : MorphTo
    {

        return $this->morphTo();
    }

    public function method() : BelongsTo
    {

        return $this->BelongsTo(PaymentMethod::class);
    }


}
